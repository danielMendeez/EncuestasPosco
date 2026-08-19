<?php

session_start();

include("../conexion/conexion.php");
require_once("../procesos/operaciones.php");

if ($_SESSION['loggedin'] != TRUE ) {

    header('Location: login.html');
}elseif($_SESSION['permiso'] != 2){

    header('Location: index.php');

}

$encuesta = $_SESSION['encuesta'];
$inicio = $_SESSION['date1'];
$fin = $_SESSION['date2'];
$depa = $_SESSION['perfil'];
header("Pragma: public");
header("Expires: 0");
$filename = "Respuestas: (".$inicio.") - (".$fin.").xls";
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
    <title>consulta</title>
</head>

<body>
   
                    <table >

                        <!--  Encabezdo de tabla -->
                   
                           
                                <?php
                                $question = $conexion ->query("SELECT *");
                                $result = $conexion->query("CALL PintarColumnas($encuesta)");

                                if ($result) {
                                    // Cycle through results
                                    foreach ($result as $result2) {
                                        echo '<th id="encabezado">' . $result2["ID"] . '</th>';
                                    }
                                    //! Free result set
                                    $result->close();
                                    $conexion->next_result();
                                }
                                //var_dump($sentencia);

                                ?>
                            
                       

                       
                            <tr>
                                <?php
                                $i = 1;
                                if (!$data = $conexion->query("CALL SP_PintarResultados($encuesta,'$depa','$inicio','$fin')")) {
                                    die("Error: " . $conexion->error);
                                } else {
                                    foreach ($data as $datos) {
                                        

                                        if($datos['Id_Pregunta']==3){
                                            echo "<td>" . $i . "</td>";
                                        echo "<td>" . $datos["area"] . "</td>";
                                        echo "<td>" . $datos["mes"] . "</td>";
                                        echo "<td>" . $datos["ncontrol"] . "</td>";
                                        echo "<td>" . $datos["usuario"] . "</td>";
                                        echo "<td>" . $datos["respuesta"] . "</td>";
                                        }
                                        else if($datos['Id_Pregunta']==4){
                                            echo "<td>" . $datos["respuesta"] . "</td>";
                                        }
                                        else if($datos['Id_Pregunta']>=5){
                                            echo "<td>" . $datos["respuesta"] . "</td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                        
                                    }
                                }


                                ?>
                      
                    </table>

</body>

</html>