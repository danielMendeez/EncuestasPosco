<?php

session_start();

include("../conexion/conexion.php");
require_once("../procesos/operaciones.php");

if ($_SESSION['loggedin'] != TRUE ) {

    header('Location: login.html');
}elseif($_SESSION['permiso'] != 2){

    header('Location: index.php');

}

$year = $_SESSION['year'];


header("Pragma: public");
header("Expires: 0");
$filename = "Reporte año: ".$year." .xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

#encabezado{
    background-color:#ddefff;
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bold;
}
td{

    font-family: Arial, Helvetica, sans-serif;
    font-weight:normal;
}


table,th,td{
    border: 1px solid black;
    
}

</style>
</head>

<body>

    <table>
        <tr>
            <th>
                <h2 for="">Consulta de Usuarios: <?php echo "" . $year . ""; ?></h2>
            </th colspan="">
        </tr>
    </table>
    <table>

        <tr id="encabezado">
            <th>Nombre</th>
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

        <tr id="datos">
            <?php
            $sql = "SELECT n_control, usuario FROM usuarios";
            $result2 = $conexion->query($sql);

            foreach ($result2 as $row) {
                $cont = 0;
                $nc = $row['n_control'];

                echo "<td>" . $row['usuario'] . "</td>";
                echo "<td>" . $nc . "</td>";
                for ($i = 1; $i <= 12; $i++) {

                    $sql1 = "SELECT fn_mes($nc,$i,$year)";
                    $mes = $conexion->query($sql1);
                    foreach ($mes as $data) {
                        $cont = $cont + $data['fn_mes(' . $nc . ',' . $i . ',' . $year . ')'];
                        echo "<td>" . $data['fn_mes(' . $nc . ',' . $i . ',' . $year . ')'] . "</td>";
                    }
                }
                echo "<td>" . $cont . "</td>";
                echo "</tr>";
            }


            ?>

    </table>


</body>

</html>