<?php
include 'conexion/conexion.php';
include 'procesos/operaciones.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js">

    <link rel="stylesheet" href="css/main.css">

    <title>Encuesta</title>
</head>

<body>



    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    

                    <?php
                    $perfil = $_GET['enc'];


                    generarForm($conexion, $perfil);
                    ?>



                </div>
            </div>
        </div>
    </div>

</body>


</html>