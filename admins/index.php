<?php
session_start();

include("../conexion/conexion.php");
require_once("../procesos/operaciones.php");

if ($_SESSION['loggedin'] != TRUE) {

    header('Location: login.html');
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/text.css">

    <title>Index</title>
</head>

<body>

    <header>
        <?php
        crNavbar($conexion, $_SESSION['permiso']);
        ?>
    </header>

    <div class="m-0 row justify-content-center">

        <div class="col-auto p-7 text-center">



            <?php
            echo '<h1>Bienvenido</h1>';
            echo '<h2>Usuario: ' . $_SESSION['user'] . ' </h2> <br>';
            opciones($conexion, $_SESSION['permiso']);
            ?>
        </div>        
    </div>



</body>

</html>