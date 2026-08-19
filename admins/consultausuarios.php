<?php
session_start();

include("../conexion/conexion.php");
require_once("../procesos/operaciones.php");

if ($_SESSION['loggedin'] != TRUE ) {

    header('Location: login.html');
}elseif($_SESSION['permiso'] != 2){

    header('Location: index.php');

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/text.css">
    <title>consulta</title>
</head>

<body>
    <header>
        <?php
        crNavbar($conexion,$_SESSION['permiso']);
        ?>
    </header>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Consulta
                    </div>
                    <div class="card-body">
                        <form action="usuarios.php" method="post">

                            <div class="mb-3">
                                <label for="date" class="form-label">Año de consulta</label>
                                <input type="text" class="form-control" id="date1" name="date1" placeholder="Introduce el año" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">consulta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const hoy = new Date();

        year = hoy.getFullYear()
        document.getElementById('date1').value = year;


    </script>



</body>

</html>