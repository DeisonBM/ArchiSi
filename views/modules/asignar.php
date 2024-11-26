<?php
if (!isset($_SESSION["id"])) {
    echo "<div class='alert alert-danger'>Error: Debes iniciar sesión para asignar un libro.</div>";
    exit;
}
?>

<div class="container">
    <h1>Asignar Libros</h1>
    <form method="post">
        <label for="tipo">Seleccionar tipo de libro:</label>
        <select id="tipo" name="tipo" class="form-select">
            <option value="Mercantil">Mercantil</option>
            <option value="Proponentes">Proponentes</option>
            <option value="ESADL">ESADL</option>
        </select>
        <label for="asignar">Asignar:</label>
        <select id="asignar" name="asignar" class="form-select">
            <option value="libro">Libro Individual</option>
            <option value="caja">Caja Completa</option>
        </select>
        <button type="submit" class="btn btn-primary mt-3">Asignar</button>
    </form>

    <?php
    require_once "controllers/AssignController.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["tipo"], $_POST["asignar"])) {
        try {
            $tipo = $_POST["tipo"];
            $asignar = $_POST["asignar"];
            $usuarioId = $_SESSION["id"];

            if ($asignar === "libro") {
                $result = AssignController::assignBookToUser($usuarioId, $tipo);
                echo "<div class='alert alert-success mt-3'>Asignado: {$result['caja_codigo']} - {$result['libro_codigo']}</div>";
            } elseif ($asignar === "caja") {
                $result = AssignController::assignBoxToUser($usuarioId, $tipo);
                echo "<div class='alert alert-success mt-3'>Caja completa asignada: {$result['caja_codigo']}</div>";
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>";
        }
    }
    ?>
</div>
