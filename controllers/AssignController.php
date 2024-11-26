<?php
require_once "models/AssignModel.php";

class AssignController {
    // Asignar un libro a un usuario
    public static function assignBookToUser($usuarioId, $tipo) {
        switch (strtolower($tipo)) {
            case 'mercantil':
            case 'proponentes':
            case 'esadl':
                return self::assignBook($usuarioId, $tipo);
            default:
                throw new Exception("Tipo de libro inválido.");
        }
    }

    // Asignar una caja completa a un usuario
    public static function assignBoxToUser($usuarioId, $tipo) {
        switch (strtolower($tipo)) {
            case 'mercantil':
            case 'proponentes':
            case 'esadl':
                return self::assignCompleteBox($usuarioId, $tipo);
            default:
                throw new Exception("Tipo de libro inválido.");
        }
    }

    private static function assignBook($usuarioId, $tipo) {
        $libro = AssignModel::getAvailableBook($tipo);

        if (!$libro) {
            AssignModel::generateBooks($tipo, 20);
            $libro = AssignModel::getAvailableBook($tipo);
            if (!$libro) {
                throw new Exception("No se pudieron generar libros disponibles para el tipo {$tipo}.");
            }
        }

        AssignModel::assignBookToUser($tipo, $libro['id'], $usuarioId);

        return [
            "caja_codigo" => $libro["caja_codigo"],
            "libro_codigo" => $libro["codigo"]
        ];
    }

    private static function assignCompleteBox($usuarioId, $tipo) {
        $caja = AssignModel::getAvailableBoxWithBooks($tipo);

        if (!$caja) {
            AssignModel::generateBooks($tipo, 20);
            $caja = AssignModel::getAvailableBoxWithBooks($tipo);
            if (!$caja) {
                throw new Exception("No se pudieron generar libros suficientes para una caja.");
            }
        }

        AssignModel::assignCompleteBoxToUser($tipo, $caja['id'], $usuarioId);

        return [
            "caja_codigo" => $caja["codigo"]
        ];
    }
}
?>
