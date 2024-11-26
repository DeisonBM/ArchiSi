<?php
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    echo "<div class='alert alert-danger'>Error: No tienes permisos para acceder a esta página.</div>";
    exit;
}

require_once "models/AssignModel.php";

try {
    $librosMercantil = AssignModel::getBooksAndBoxes("mercantil");
    $librosProponentes = AssignModel::getBooksAndBoxes("proponentes");
    $librosEsadl = AssignModel::getBooksAndBoxes("esadl");
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    exit;
}

$swalMessage = ''; // Variable para almacenar el mensaje de SweetAlert

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["tipo"])) {
    $tipo = $_POST["tipo"];
    try {
        AssignModel::generateBooks($tipo, 250); // Generar 50 cajas (5 libros por caja)
        // Mensaje de éxito en formato SweetAlert
        $swalMessage = "Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Se generaron 50 cajas y 250 libros para {$tipo}.',
        });";
    } catch (Exception $e) {
        // Mensaje de error en formato SweetAlert
        $swalMessage = "Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{$e->getMessage()}',
        });";
    }
}
?>

<h3>Administrador: Libros y Cajas - Mercantil</h3>
<!-- Botón para abrir el modal -->


    <div class="row g-4 mb-4">



        <table id="librosTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Caja</th>
                    <th>Libro</th>
                    <th>Estado</th>
                    <th>Usuario Asignado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($librosMercantil as $index => $libro): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $libro["caja_codigo"] ?></td>
                        <td><?= $libro["libro_codigo"] ?></td>
                        <td><?= $libro["estado"] ?></td>
                        <td><?= $libro["usuario_nombre"] ?? "Disponible" ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para Generar más Cajas y Libros -->
    <div class="modal fade" id="generateModal" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateModalLabel">Generar más Cajas y Libros</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para generar más cajas y libros -->
                    <form method="post" action="libros">
                        <div class="form-group">
                            <label for="tipo">Seleccionar tipo:</label>
                            <select id="tipo" name="tipo" class="form-select">
                                <option value="mercantil">Mercantil</option>
                                <option value="proponentes">Proponentes</option>
                                <option value="esadl">ESADL</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Generar 50 cajas y libros</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mostrar el mensaje de SweetAlert (Si existe) -->
    <script>
    <?php if ($swalMessage): ?>
        <?= $swalMessage ?>
    <?php endif; ?>

    // Inicializar DataTables
    $(document).ready(function() {
        $('#librosTable').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros", // Ya está configurado
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
            "pageLength": 25, // Establece el valor predeterminado (25 registros por página)
            "lengthMenu": [5, 25, 50, 100], // Opciones para seleccionar cantidad de registros por página
        });
    });
</script>

