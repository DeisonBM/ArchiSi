<?php
ob_start();  // Inicia el buffer de salida

// Resto del código PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();  
}
session_unset();
session_destroy();
header("Location: login");
exit();
ob_end_flush();  // Libera el buffer de salida cuando se termina
?>
