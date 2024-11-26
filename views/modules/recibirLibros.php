<?php
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    echo "<div class='alert alert-danger'>Error: No tienes permisos para acceder a esta página.</div>";
    exit;
}

require_once "models/AssignModel.php";

$librosPendientes = AssignModel::getPendingBooks();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["recibir_libro_id"])) {
    $libroId = $_POST["recibir_libro_id"];
    try {
        AssignModel::markBookAsDelivered($libroId);
        echo "<div class='alert alert-success mt-3'>El libro ha sido marcado como entregado.</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>";
    }
    // Recargar libros pendientes después de recibir
    $librosPendientes = AssignModel::getPendingBooks();
}
?>

<div class="container">
    <h1>Libros Pendientes de Recepción</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Libro</th>
                <th>Caja</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($librosPendientes)): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay libros pendientes de recepción.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($librosPendientes as $index => $libro): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $libro["libro_codigo"] ?></td>
                        <td><?= $libro["caja_codigo"] ?></td>
                        <td><?= $libro["usuario_nombre"] ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="recibir_libro_id" value="<?= $libro['id'] ?>">
                                <button type="submit" class="btn btn-success btn-sm">Recibir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
