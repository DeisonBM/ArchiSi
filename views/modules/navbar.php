<nav class="navbar">
    <div class="d-flex gap-3">
        <button class="btn btn-light d-lg-none" id="mobileToggle">
            <i class="fas fa-bars" id="mobileMenuIcon"></i>
            <i class="fas fa-times" id="mobileCloseIcon" style="display: none;"></i>
        </button>
        <button class="btn btn-light"><i class="fas fa-bell"></i></button>
        <button class="btn btn-light"><i class="fas fa-envelope"></i></button>
        <div class="dropdown">
            <button class="btn btn-light" type="button" id="userMenu" data-bs-toggle="dropdown">
                <i class="fas fa-user"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Perfil</a></li>
                <li><a class="dropdown-item" href="#">Configuración</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="salir">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="inicio">Inicio</a>
            </li>
            <?php if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] === 1) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="usuarios">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="recibir">Recibir Libros</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="recibir">Recibir Libros</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
