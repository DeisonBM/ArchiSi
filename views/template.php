<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ArchiSi</title>
    <link href="views/img/asignar.png" rel="icon">
    <link href="views/img/asignar.png" rel="apple-touch-icon">

    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Incluir Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Incluir DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Incluir SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.7/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Incluir SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.7/dist/sweetalert2.all.min.js"></script>

    <!-- Incluir DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap y Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="views/css/css/bootstrap.min.css">

    <!-- Incluir SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">


    <!-- Data tables -->
    <link rel="stylesheet" href="views/css/DataTables/datatables.min.css">

    <!-- Estilos adicionales -->
    <link href="views/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="views/css/other.css">

    <!-- Incluir SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</head>

<body>

    <?php


    /*=============================================
        SIDEBAR
    =============================================*/
    include "views/modules/sidebar.php";

    /*=============================================
        MENU
    =============================================*/
    include "views/modules/navbar.php";

    /*=============================================
        CONTENIDO
    =============================================*/

    echo '<div class="main-content" id="main">';
    

    if (isset($_GET["ruta"])) {

        // Verificar la ruta solicitada
        if (
            $_GET["ruta"] == "inicio" ||
            $_GET["ruta"] == "user" ||
            $_GET["ruta"] == "asignar" ||
            $_GET["ruta"] == "libros" ||
            $_GET["ruta"] == "EntregarLibros" ||
            $_GET["ruta"] == "recibirLibros" ||
            $_GET["ruta"] == "salir"
        ) {
            include "views/modules/" . $_GET["ruta"] . ".php";
        } else {
            include "views/modules/404.php";  // Si la ruta no existe, muestra error 404
        }
    } else {
        include "views/modules/inicio.php";  // Página de inicio por defecto
    }

    echo '</div>';

    /*=============================================
        FOOTER
    =============================================*/
    include "views/modules/footer.php";

    ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="views/js/script.js"></script>
    <script src="views/js/other.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="views/css/js/bootstrap.bundle.min.js"></script>
    <script src="views/css/DataTables/datatables.min.js"></script>


    <!-- Incluir SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>

</body>

</html>