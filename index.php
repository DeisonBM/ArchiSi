<?php
require_once "controllers/template.controller.php";
require_once "controllers/UserController.php";
require_once "controllers/AssignController.php"; // Agregar aquí
require_once "models/UserModel.php";
require_once "models/AssignModel.php";

// Asegurarse de iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Procesar login
if (isset($_POST["usuario"]) && isset($_POST["password"])) {
    $loginResponse = UserController::loginUser($_POST["usuario"], $_POST["password"]);

    if ($loginResponse === "ok") {
        header("Location: index.php?ruta=inicio");
        exit(); // Detener ejecución después de redirigir
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '$loginResponse'
                });
              </script>";
    }
}

// Mostrar la plantilla
$template = new ControllerTemplate();
$template->ctrTemplate();
?>
