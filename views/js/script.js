// Sidebar Toggle
document.getElementById('toggleSidebar').addEventListener('click', toggleSidebar);
document.getElementById('mobileToggle').addEventListener('click', toggleSidebar);

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    const navbar = document.querySelector('.navbar');
    const footer = document.querySelector('.footer');
    const hamburgerIcon = document.getElementById('hamburgerIcon');
    const closeIcon = document.getElementById('closeIcon');
    const mobileMenuIcon = document.getElementById('mobileMenuIcon');
    const mobileCloseIcon = document.getElementById('mobileCloseIcon');

    if (window.innerWidth <= 991) {
        sidebar.classList.toggle('show');
        // Toggle mobile icons
        if (sidebar.classList.contains('show')) {
            mobileMenuIcon.style.display = 'none';
            mobileCloseIcon.style.display = 'inline-block';
        } else {
            mobileMenuIcon.style.display = 'inline-block';
            mobileCloseIcon.style.display = 'none';
        }
    } else {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
        navbar.classList.toggle('expanded');
        footer.classList.toggle('expanded');

        if (sidebar.classList.contains('collapsed')) {
            hamburgerIcon.style.display = 'none';
            closeIcon.style.display = 'inline-block';
            document.getElementById('sidebarTitle').textContent = 'DSH';
        } else {
            hamburgerIcon.style.display = 'inline-block';
            closeIcon.style.display = 'none';
            document.getElementById('sidebarTitle').textContent = 'Dashboard';
        }
    }
}

// Función para actualizar el estado inicial
function updateInitialState() {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    const navbar = document.querySelector('.navbar');
    const footer = document.querySelector('.footer');
    const sidebarTitle = document.getElementById('sidebarTitle');
    const hamburgerIcon = document.getElementById('hamburgerIcon');
    const closeIcon = document.getElementById('closeIcon');
    const mobileMenuIcon = document.getElementById('mobileMenuIcon');
    const mobileCloseIcon = document.getElementById('mobileCloseIcon');

    if (window.innerWidth <= 991) {
        sidebar.classList.remove('collapsed');
        main.classList.remove('expanded');
        navbar.classList.remove('expanded');
        footer.classList.remove('expanded');
        sidebarTitle.textContent = 'Dashboard';
        hamburgerIcon.style.display = 'inline-block';
        closeIcon.style.display = 'none';
        mobileMenuIcon.style.display = 'inline-block';
        mobileCloseIcon.style.display = 'none';
    } else {
        if (sidebar.classList.contains('collapsed')) {
            sidebarTitle.textContent = 'DSH';
            hamburgerIcon.style.display = 'none';
            closeIcon.style.display = 'inline-block';
        } else {
            sidebarTitle.textContent = 'Dashboard';
            hamburgerIcon.style.display = 'inline-block';
            closeIcon.style.display = 'none';
        }
    }
}

// Ejecutar al cargar la página y al cambiar el tamaño de la ventana
window.addEventListener('load', updateInitialState);
window.addEventListener('resize', function () {
    updateInitialState();
    if (window.innerWidth > 991) {
        document.getElementById('sidebar').classList.remove('show');
    }
});

