<?php

session_start();

include("../conexion/conexion.php");
require_once("../procesos/operaciones.php");
if ($_SESSION['loggedin'] != TRUE ) {

    header('Location: login.html');
}elseif($_SESSION['permiso'] != 2){

    header('Location: index.php');

}

$year = $_POST['date1'];

$depa =  $_SESSION['perfil'];

$_SESSION['year'] = $year;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/text.css">
    <title>consulta</title>
</head>

<body>
    <header>
        <?php
        crNavbar($conexion, $_SESSION['permiso']);

        $sql_user = "SELECT n_control, usuario FROM usuarios WHERE departamento = '$depa' ";
        $users = $conexion->query($sql_user);
        ?>
    </header>

    
    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header">
                    <?php

                    if(mysqli_num_rows($users)==0){

                        echo'<div class="card-body">
                                <div class="alert alert-warning" role="alert" style="text-align: center;">
                                        NO EXITEN DATOS!
                                </div>
                                <a href="consultausuarios.php" class="btn btn-primary w-100" >Realizar otra consulta </a>
                            </div>';
                    }else{
                    ?>
                    <table>
                        <tr>
                            <th><label for="">Consulta de Usuarios: <?php echo "" . $year . ""; ?></label></th colspan="12">
                            <th> <a class="btn btn-success" href="userexcel.php" role="button">Descargar</a></th>
                        </tr>
                    </table>
                    </script>
                </div>
                <div class="card-body">
                    <table class="table" id="respuestas">

                        <!--  Encabezdo de tabla -->
                        <thead class="table-dark">
                            <tr>
                                <th>nombre</th>
                                <th>NC</th>
                                <th>Enero</th>
                                <th>Febrero</th>
                                <th>Marzo</th>
                                <th>Abril</th>
                                <th>Mayo</th>
                                <th>Junio</th>
                                <th>Julio</th>
                                <th>Agosto</th>
                                <th>Septiembre</th>
                                <th>Octubre</th>
                                <th>Noviembre</th>
                                <th>Diciembre</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <?php


                                foreach ($users as $row) {
                                    $cont = 0;
                                    $nc = $row['n_control'];

                                    echo "<th>" . $row['usuario'] . "</th>";
                                    echo "<th>" . $nc . "</th>";
                                    for ($i = 1; $i <= 12; $i++) {

                                        $sql1 = "SELECT fn_mes($nc,$i,$year)";
                                        $mes = $conexion->query($sql1);
                                        foreach ($mes as $data) {
                                            $cont = $cont + $data['fn_mes(' . $nc . ',' . $i . ',' . $year . ')'];
                                            echo "<th>" . $data['fn_mes(' . $nc . ',' . $i . ',' . $year . ')'] . "</th>";
                                        }
                                    }
                                    echo "<th>" . $cont . "</th>";
                                    echo "</tr>";
                                }
                            }


                                ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

</body>

</html>