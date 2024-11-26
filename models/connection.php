<?php
class Connection {
    public static function connect() {
        try {
            $link = new PDO("mysql:host=localhost;dbname=archisi", "root", ""); // Ajusta tus credenciales
            $link->exec("set names utf8");
            return $link;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>
