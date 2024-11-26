<?php
require_once "models/UserModel.php";

class UserController
{
    const UPLOAD_DIR = 'ArchiSi/views/img/avatar/';

    // Método para listar todos los usuarios
    public static function listUsers()
    {
        return UserModel::getUsers();
    }

    // Método para crear un nuevo usuario
    public static function createUser($data, $file)
    {
        $usuarioBase = ucfirst(substr($data["nombre"], 0, 2)) . strtolower($data["apellido"]);

        if (self::usuarioExiste($usuarioBase)) {
            return "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nombre de usuario en uso, elige otro.'
                });
            </script>";
        }

        $data["usuario"] = $usuarioBase;
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        $data["foto"] = self::guardarFoto($file);

        $result = UserModel::createUser($data);
        if ($result) {
            return "<script>Swal.fire('Éxito', 'Usuario creado correctamente.', 'success');</script>";
        } else {
            return "<script>Swal.fire('Error', 'Hubo un problema al crear el usuario.', 'error');</script>";
        }
    }

    // Método para actualizar un usuario
    public static function updateUser($id, $data, $file)
    {
        $fotoAnterior = UserModel::getUserPhoto($id);
        $nuevaFoto = self::guardarFoto($file, $fotoAnterior);
        $data["foto"] = $nuevaFoto;

        $result = UserModel::updateUser($id, $data);
        if ($result) {
            return "<script>Swal.fire('Éxito', 'Usuario actualizado correctamente.', 'success');</script>";
        } else {
            return "<script>Swal.fire('Error', 'Hubo un problema al actualizar el usuario.', 'error');</script>";
        }
    }

    // Método para eliminar un usuario
    public static function deleteUser($id)
    {
        $foto = UserModel::getUserPhoto($id);
        if ($foto && file_exists($foto) && basename($foto) !== "default.jpg") {
            unlink($foto);
        }

        $result = UserModel::deleteUser($id);
        if ($result) {
            return "<script>Swal.fire('Éxito', 'Usuario eliminado correctamente.', 'success');</script>";
        } else {
            return "<script>Swal.fire('Error', 'Hubo un problema al eliminar el usuario.', 'error');</script>";
        }
    }

    // Método para manejar el inicio de sesión
    public static function loginUser($usuario, $password)
    {
        $user = UserModel::getUserByUsername($usuario);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Establecer variables de sesión
                $_SESSION["iniciarSesion"] = "ok";
                $_SESSION["id"] = $user["id"];
                $_SESSION["nombre"] = $user["nombre"];
                $_SESSION["apellido"] = $user["apellido"];
                $_SESSION["role_id"] = $user["role_id"];

                // Actualizar último login
                UserModel::updateLastLogin($user["id"], date("Y-m-d H:i:s"));

                return "<script>Swal.fire('Éxito', 'Bienvenido, " . $user["nombre"] . "!', 'success');</script>";
            } else {
                return "<script>Swal.fire('Error', 'Contraseña incorrecta.', 'error');</script>";
            }
        } else {
            return "<script>Swal.fire('Error', 'Usuario no encontrado.', 'error');</script>";
        }
    }

    // Método privado para verificar si un nombre de usuario ya existe
    private static function usuarioExiste($usuario)
    {
        return UserModel::existeUsuario($usuario);
    }

    // Método privado para gestionar la subida y guardado de la foto
    private static function guardarFoto($file, $fotoAnterior = null)
    {
        if (!file_exists(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0777, true);
        }

        if ($file["error"] == UPLOAD_ERR_OK) {
            $filename = uniqid() . "_" . basename($file["name"]);
            $uploadFile = self::UPLOAD_DIR . $filename;

            if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
                if ($fotoAnterior && file_exists($fotoAnterior) && basename($fotoAnterior) !== "default.jpg") {
                    unlink($fotoAnterior);
                }
                return $uploadFile;
            } else {
                throw new Exception("Error al mover el archivo al directorio de destino.");
            }
        }

        return $fotoAnterior ?? self::UPLOAD_DIR . "default.jpg";
    }
}
?>
