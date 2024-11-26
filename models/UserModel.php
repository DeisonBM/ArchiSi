<?php
require_once "models/connection.php";

class UserModel {

    // Método para obtener todos los usuarios
    public static function getUsers() {
        $stmt = Connection::connect()->prepare(
            "SELECT u.id, u.nombre, u.apellido, u.usuario, u.foto, u.estado, r.nombre AS rol 
             FROM usuarios u 
             JOIN roles r ON u.role_id = r.id"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener un usuario por su nombre de usuario
    public static function getUserByUsername($usuario) {
        $stmt = Connection::connect()->prepare(
            "SELECT id, nombre, apellido, usuario, password, estado, foto, role_id 
             FROM usuarios 
             WHERE usuario = :usuario"
        );
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un único usuario
    }

    // Método para crear un nuevo usuario
    public static function createUser($data) {
        $stmt = Connection::connect()->prepare(
            "INSERT INTO usuarios (nombre, apellido, usuario, password, estado, role_id, foto) 
             VALUES (:nombre, :apellido, :usuario, :password, :estado, :role_id, :foto)"
        );
        $stmt->bindParam(":nombre", $data["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $data["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $data["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $data["password"], PDO::PARAM_STR); // Contraseña cifrada
        $stmt->bindParam(":estado", $data["estado"], PDO::PARAM_INT);
        $stmt->bindParam(":role_id", $data["role_id"], PDO::PARAM_INT);
        $stmt->bindParam(":foto", $data["foto"], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Método para actualizar un usuario
    public static function updateUser($id, $data) {
        $stmt = Connection::connect()->prepare(
            "UPDATE usuarios 
             SET nombre = :nombre, apellido = :apellido, estado = :estado, role_id = :role_id, foto = :foto 
             WHERE id = :id"
        );
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $data["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $data["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $data["estado"], PDO::PARAM_INT);
        $stmt->bindParam(":role_id", $data["role_id"], PDO::PARAM_INT);
        $stmt->bindParam(":foto", $data["foto"], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Método para eliminar un usuario
    public static function deleteUser($id) {
        $stmt = Connection::connect()->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Método para obtener la foto de un usuario
    public static function getUserPhoto($id) {
        $stmt = Connection::connect()->prepare("SELECT foto FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn(); // Retorna solo el campo 'foto'
    }

    // Método para verificar si un nombre de usuario ya existe
    public static function existeUsuario($usuario) {
        $stmt = Connection::connect()->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Retorna true si ya existe
    }

    // Método para actualizar el último login de un usuario
    public static function updateLastLogin($userId, $fecha) {
        $stmt = Connection::connect()->prepare("UPDATE usuarios SET ultimo_login = :ultimo_login WHERE id = :id");
        $stmt->bindParam(":ultimo_login", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
