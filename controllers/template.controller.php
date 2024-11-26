<?php
class ControllerTemplate {

    // Método principal para cargar la plantilla
    public function ctrTemplate() {
        // Asegurarse de que las sesiones estén habilitadas solo si no hay una sesión activa

        // Verifica si el usuario está autenticado
        if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] === "ok") {
            // Incluir la estructura de la plantilla autenticada
            include "views/template.php";
        } else {
            // Si no está autenticado, redirige al login
            include "views/modules/login.php";
        }
    }
}
?>
