<?php
require_once "models/connection.php";

class AssignModel
{
    public static function getBooksAndBoxes($tipo)
    {
        $stmt = Connection::connect()->prepare(
            "SELECT 
                l.codigo AS libro_codigo, 
                l.estado, 
                u.nombre AS usuario_nombre, 
                c.codigo AS caja_codigo 
             FROM libros_{$tipo} l
             LEFT JOIN usuarios u ON l.usuario_id = u.id
             JOIN cajas_{$tipo} c ON l.caja_id = c.id
             ORDER BY c.id, l.id"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAvailableBook($tipo)
    {
        $stmt = Connection::connect()->prepare(
            "SELECT 
                l.id, l.codigo, c.codigo AS caja_codigo 
             FROM libros_{$tipo} l
             JOIN cajas_{$tipo} c ON l.caja_id = c.id
             WHERE l.estado = 'Disponible' 
             ORDER BY l.id ASC LIMIT 1"
        );
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAvailableBoxWithBooks($tipo)
    {
        $stmt = Connection::connect()->prepare(
            "SELECT 
                c.id, c.codigo 
             FROM cajas_{$tipo} c
             JOIN libros_{$tipo} l ON l.caja_id = c.id
             WHERE c.libros_asignados = 0
             GROUP BY c.id
             HAVING COUNT(l.id) = 5
             LIMIT 1"
        );
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function generateBooks($tipo, $cantidad)
    {
        $connection = Connection::connect();

        // Obtener el último ID de la tabla de cajas y libros
        $lastBox = self::getLastBox($tipo);
        $newBoxId = $lastBox ? $lastBox['id'] + 1 : 1;

        $lastBook = self::getLastBookId($tipo);
        $newBookId = $lastBook ? $lastBook + 1 : 1;

        $cajasNecesarias = ceil($cantidad / 5);

        for ($i = 0; $i < $cajasNecesarias; $i++) {
            // Crear una nueva caja
            $codigoCaja = ucfirst($tipo) . " Caja " . ($newBoxId + $i) . "D";
            $stmt = $connection->prepare(
                "INSERT INTO cajas_{$tipo} (codigo, capacidad, libros_asignados, estado, created_at) 
                 VALUES (:codigo, 5, 0, 'Disponible', NOW())"
            );
            $stmt->bindParam(":codigo", $codigoCaja, PDO::PARAM_STR);
            $stmt->execute();

            // Obtener el ID de la caja recién creada
            $cajaId = $connection->lastInsertId();
            if (!$cajaId) {
                throw new Exception("No se pudo obtener el ID de la caja recién creada.");
            }

            // Crear 5 libros para la nueva caja
            for ($j = 0; $j < 5; $j++) {
                $codigoLibro = "Libro " . ($newBookId++) . "D";
                $stmt = $connection->prepare(
                    "INSERT INTO libros_{$tipo} (caja_id, codigo, estado) 
                     VALUES (:cajaId, :codigo, 'Disponible')"
                );
                $stmt->bindParam(":cajaId", $cajaId, PDO::PARAM_INT);
                $stmt->bindParam(":codigo", $codigoLibro, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }

    public static function assignBookToUser($tipo, $libroId, $usuarioId)
    {
        $stmt = Connection::connect()->prepare(
            "UPDATE libros_{$tipo} 
             SET usuario_id = :usuarioId, estado = 'Asignado', asignado_at = NOW() 
             WHERE id = :libroId"
        );
        $stmt->bindParam(":usuarioId", $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(":libroId", $libroId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function assignCompleteBoxToUser($tipo, $cajaId, $usuarioId)
    {
        $stmt = Connection::connect()->prepare(
            "UPDATE libros_{$tipo} 
             SET usuario_id = :usuarioId, estado = 'Asignado', asignado_at = NOW() 
             WHERE caja_id = :cajaId AND estado = 'Disponible'"
        );
        $stmt->bindParam(":usuarioId", $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(":cajaId", $cajaId, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = Connection::connect()->prepare(
            "UPDATE cajas_{$tipo} 
             SET libros_asignados = 5, estado = 'Completa' 
             WHERE id = :cajaId"
        );
        $stmt->bindParam(":cajaId", $cajaId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function getLastBookId($tipo)
    {
        $stmt = Connection::connect()->prepare(
            "SELECT MAX(id) AS max_id FROM libros_{$tipo}"
        );
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['max_id'] : 0;
    }

    public static function getLastBox($tipo)
    {
        $stmt = Connection::connect()->prepare(
            "SELECT * FROM cajas_{$tipo} ORDER BY id DESC LIMIT 1"
        );
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function getUserAssignedBooks($userId)
    {
        $stmt = Connection::connect()->prepare(
            "SELECT l.id, l.codigo AS libro_codigo, c.codigo AS caja_codigo, l.estado
             FROM libros_mercantil l
             JOIN cajas_mercantil c ON l.caja_id = c.id
             WHERE l.usuario_id = :userId
             UNION ALL
             SELECT l.id, l.codigo, c.codigo, l.estado
             FROM libros_proponentes l
             JOIN cajas_proponentes c ON l.caja_id = c.id
             WHERE l.usuario_id = :userId
             UNION ALL
             SELECT l.id, l.codigo, c.codigo, l.estado
             FROM libros_esadl l
             JOIN cajas_esadl c ON l.caja_id = c.id
             WHERE l.usuario_id = :userId"
        );
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPendingBooks()
    {
        $stmt = Connection::connect()->prepare(
            "SELECT l.id, l.codigo AS libro_codigo, c.codigo AS caja_codigo, u.nombre AS usuario_nombre
             FROM libros_mercantil l
             JOIN cajas_mercantil c ON l.caja_id = c.id
             JOIN usuarios u ON l.usuario_id = u.id
             WHERE l.estado = 'Pendiente'
             UNION ALL
             SELECT l.id, l.codigo, c.codigo, u.nombre
             FROM libros_proponentes l
             JOIN cajas_proponentes c ON l.caja_id = c.id
             JOIN usuarios u ON l.usuario_id = u.id
             WHERE l.estado = 'Pendiente'
             UNION ALL
             SELECT l.id, l.codigo, c.codigo, u.nombre
             FROM libros_esadl l
             JOIN cajas_esadl c ON l.caja_id = c.id
             JOIN usuarios u ON l.usuario_id = u.id
             WHERE l.estado = 'Pendiente'"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function markBookAsPending($libroId)
    {
        // Verificar en cuál tabla se encuentra el libro
        $tables = ['libros_mercantil', 'libros_proponentes', 'libros_esadl'];
        foreach ($tables as $table) {
            $stmt = Connection::connect()->prepare(
                "SELECT COUNT(*) AS count FROM $table WHERE id = :libroId"
            );
            $stmt->bindParam(":libroId", $libroId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                // Actualizar el estado a 'Pendiente'
                $updateStmt = Connection::connect()->prepare(
                    "UPDATE $table SET estado = 'Pendiente' WHERE id = :libroId"
                );
                $updateStmt->bindParam(":libroId", $libroId, PDO::PARAM_INT);
                $updateStmt->execute();
                return; // Salir del bucle después de actualizar
            }
        }

        throw new Exception("El libro con ID $libroId no se encontró en ninguna tabla.");
    }



    public static function markBookAsDelivered($libroId)
    {
        // Verificar en cuál tabla se encuentra el libro
        $tables = ['libros_mercantil', 'libros_proponentes', 'libros_esadl'];
        foreach ($tables as $table) {
            $stmt = Connection::connect()->prepare(
                "SELECT COUNT(*) AS count FROM $table WHERE id = :libroId"
            );
            $stmt->bindParam(":libroId", $libroId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                // Actualizar el estado a 'Entregado'
                $updateStmt = Connection::connect()->prepare(
                    "UPDATE $table SET estado = 'Entregado' WHERE id = :libroId"
                );
                $updateStmt->bindParam(":libroId", $libroId, PDO::PARAM_INT);
                $updateStmt->execute();
                return; // Salir del bucle después de actualizar
            }
        }

        throw new Exception("El libro con ID $libroId no se encontró en ninguna tabla.");
    }
}
