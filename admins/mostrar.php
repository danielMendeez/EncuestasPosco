<?php

session_start();

include("../conexion/conexion.php");
require_once("../procesos/operaciones.php");

if ($_SESSION['loggedin'] != TRUE ) {

    header('Location: login.html');
}elseif($_SESSION['permiso'] != 2){

    header('Location: index.php');

}

$encuesta = $_POST['encuesta'];
$inicio = $_POST['date1'];
$fin = $_POST['date2'];
$depa = $_SESSION['perfil'];

$_SESSION['encuesta'] = $encuesta;
$_SESSION['date1'] = $inicio;
$_SESSION['date2'] = $fin;

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

        //*Preparacion de consulta respuestas


        ?>
    </header>
    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="excel.php" role="button">Descargar</a>
                    </script>
                </div>
                <div class="card-body">
                    <table class="table" id="respuestas">

                        <!--  Encabezdo de tabla -->
                        <thead class="table-dark">
                            <tr>
                                <?php
                                $question = $conexion->query("SELECT *");
                                $result = $conexion->query("CALL PintarColumnas($encuesta)");

                                $nrows = mysqli_num_rows($result);

                                if ($result) {
                                    // Cycle through results
                                    foreach ($result as $result2) {
                                        echo "<th>" . $result2["ID"] . "</th>";
                                    }
                                    //! Free result set
                                    $result->close();
                                    $conexion->next_result();
                                } else {
                                }
                                //var_dump($sentencia);

                                ?>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <?php
                                $i = 1;
                                if (!$data = $conexion->query("CALL SP_PintarResultados($encuesta,'$depa','$inicio','$fin')")) {
                                    echo '<div class="card-body">
                                    <div class="alert alert-danger" role="alert" style="text-align: center;">
                                            Error en la consulta: ' . $conexion->error . '
                                    </div>
                                    <a href="consultarespuesta.php" class="btn btn-primary w-100" >Realizar otra consulta </a>
                                </div>';
                                } else {
                                    if (mysqli_num_rows($data) == 0) {
                                        echo'
                                        <th colspan = '. $nrows.'>
                                        <div class="alert alert-warning" role="alert" style="text-align: center;">
                                                NO EXITEN DATOS!
                                                </div>
                                                <th>

                                ';
                                    } else {
                                        foreach ($data as $datos) {


                                            if ($datos['Id_Pregunta'] == 3) {
                                                echo "<th>" . $i . "</th>";
                                                echo "<th>" . $datos["area"] . "</th>";
                                                echo "<th>" . $datos["mes"] . "</th>";
                                                echo "<th>" . $datos["ncontrol"] . "</th>";
                                                echo "<th>" . $datos["usuario"] . "</th>";
                                                echo "<th>" . $datos["respuesta"] . "</th>";
                                            } else if ($datos['Id_Pregunta'] == 4) {
                                                echo "<th>" . $datos["respuesta"] . "</th>";
                                            } else if ($datos['Id_Pregunta'] >= 5) {
                                                echo "<th>" . $datos["respuesta"] . "</th>";
                                                echo "</tr>";
                                                $i++;
                                            }
                                        }
                                    }
                                }
                                ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>




</body>

</html>