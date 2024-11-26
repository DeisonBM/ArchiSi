<?php
$usuarios = UserController::listUsers();
?>

<div class="container-fluid mt-1">
    <h2 class="text-center mb-3">Gestión de Usuarios</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">
        <i class="fas fa-user-plus"></i> Crear Usuario
    </button>

    <!-- Tabla con DataTable -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="usuariosTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th>Foto</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)) : ?>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= $usuario['nombre'] ?></td>
                            <td><?= $usuario['apellido'] ?></td>
                            <td><?= $usuario['usuario'] ?></td>
                            <td>
                                <img src="<?= $usuario['foto'] ?>" alt="Foto de <?= $usuario['nombre'] ?>" class="img-thumbnail" style="width: 50px; height: 50px;">
                            </td>
                            <td><?= $usuario['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                            <td><?= $usuario['rol'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" 
                                    onclick="abrirEditarUsuario(<?= $usuario['id'] ?>, '<?= $usuario['nombre'] ?>', '<?= $usuario['apellido'] ?>', <?= $usuario['estado'] ?>, <?= isset($usuario['role_id']) ? $usuario['role_id'] : 'null' ?>)">
                                    Editar
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(<?= $usuario['id'] ?>)">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearUsuarioLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre de Usuario</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" required>
                        <small id="usuarioError" class="form-text text-danger" style="display: none;">Este nombre de usuario ya está en uso.</small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Rol</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="crearUsuario" class="btn btn-primary">
                        <i class="fas fa-save"></i> Crear
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" id="edit_apellido" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role_id" class="form-label">Rol</label>
                        <select name="role_id" id="edit_role_id" class="form-control" required>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_estado" class="form-label">Estado</label>
                        <select name="estado" id="edit_estado" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_foto" class="form-label">Foto</label>
                        <input type="file" name="foto" id="edit_foto" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editarUsuario" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Inicializar DataTable
    $(document).ready(function() {
        $('#usuariosTable').DataTable({
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
            }
        });
    });

    function eliminarUsuario(id) {
        Swal.fire({
            icon: 'warning',
            title: '¿Estás seguro?',
            text: 'Este usuario será eliminado permanentemente.',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `index.php?ruta=user&delete=${id}`;
            }
        });
    }

    function abrirEditarUsuario(id, nombre, apellido, estado, role_id) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_apellido').value = apellido;
        document.getElementById('edit_estado').value = estado;
        document.getElementById('edit_role_id').value = role_id;
        new bootstrap.Modal(document.getElementById('editarUsuarioModal')).show();
    }

    <?php
    // Lógica PHP para la creación, edición y eliminación de usuarios
    if (isset($_POST['crearUsuario'])) {
        $data = [
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'usuario' => $_POST['usuario'],
            'password' => $_POST['password'],
            'estado' => $_POST['estado'],
            'role_id' => $_POST['role_id'],
        ];
        $file = $_FILES['foto'];

        // Verificar que el nombre de usuario no exista antes de crear el usuario
        if (UserModel::existeUsuario($data['usuario'])) {
            echo "<script>Swal.fire('Error', 'El nombre de usuario ya está en uso.', 'error');</script>";
        } else {
            if (UserController::createUser($data, $file)) {
                echo "<script>Swal.fire('Éxito', 'Usuario creado correctamente', 'success');</script>";
            }
        }
    }

    if (isset($_POST['editarUsuario'])) {
        $id = $_POST['id'];
        $data = [
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'estado' => $_POST['estado'],
            'role_id' => $_POST['role_id'],
        ];
        $file = $_FILES['foto'];
        if (UserController::updateUser($id, $data, $file)) {
            echo "<script>Swal.fire('Éxito', 'Usuario actualizado correctamente', 'success');</script>";
        }
    }

    if (isset($_GET['delete'])) {
        if (UserController::deleteUser($_GET['delete'])) {
            echo "<script>Swal.fire('Éxito', 'Usuario eliminado correctamente', 'success');</script>";
        }
    }
    ?>
</script>
