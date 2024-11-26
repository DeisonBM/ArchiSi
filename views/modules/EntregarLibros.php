<?php
if (!isset($_SESSION["id"])) {
    echo "<div class='alert alert-danger'>Error: Debes iniciar sesión para gestionar libros.</div>";
    exit;
}

require_once "models/AssignModel.php";

$userId = $_SESSION["id"];
$librosAsignados = AssignModel::getUserAssignedBooks($userId);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["entregar_libro_id"])) {
    $libroId = $_POST["entregar_libro_id"];
    try {
        AssignModel::markBookAsPending($libroId);
        echo "<div class='alert alert-success mt-3'>El libro se ha marcado como pendiente de entrega.</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>";
    }
    // Recargar los libros asignados
    $librosAsignados = AssignModel::getUserAssignedBooks($userId);
}
?>

    <div class="row g-4 mb-4">
       
        
    <h2 class="text-center mb-3">Mis Libros</h2>
        <table id="librosTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Libro</th>
                    <th>Caja</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($librosAsignados as $index => $libro): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $libro["libro_codigo"] ?></td>
                        <td><?= $libro["caja_codigo"] ?></td>
                        <td><?= $libro["estado"] ?></td>
                        <td>
                            <?php if ($libro["estado"] === "Asignado"): ?>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="entregar_libro_id" value="<?= $libro['id'] ?>">
                                    <button type="submit" class="btn btn-warning btn-sm">Entregar</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">No disponible</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Inicializar DataTable
        $(document).ready(function() {
            $('#librosTable').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sPrevious": "Anterior",
                        "sNext": "Siguiente",
                        "sLast": "Último"
                    }
                },
                "pagingType": "full_numbers", // Estilo de paginación completa
                "lengthMenu": [5, 10, 25, 50, 100], // Número de registros por página
                "pageLength": 10 // Número inicial de registros por página
            });
        });
    </script>
</body>
</html>
