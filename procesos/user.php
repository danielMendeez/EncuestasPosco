<?php
include('../conexion/conexion.php');




//?Preparacion de sql
$sql = "INSERT INTO respuestas (n_control, usuario, area) VALUES (?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conexion->error);
} else {

    $stmt->bind_param("iis", $_POST['nc'], $_POST['user'], $_POST['area']);

    //*comprobacion de ejecucion
    if (!$stmt->execute()) {
        die('Error en la preparación de la consulta: ' . ($stmt->error));
    }
    $stmt->close();
}


$conexion->close();
echo '<script> alert("Datos envias de manera correcta"); ?>';
