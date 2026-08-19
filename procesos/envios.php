<?php
include('../conexion/conexion.php');


$ncontrol = $_POST['pregunta_1'];
$id_encuesta = $_POST['id_encuesta'];
$user = $_POST['pregunta_2'];
$area = $_POST['almacen'];
$planta = $_POST['puebla'];

//! COnsulta para obtener el ultimo id_user
$consulta = "SELECT max(id_user) from registro_usuarios";
$usersId = $conexion->query($consulta);


//?comprobacion de datos
if(!empty($usersId)){

 
    foreach($usersId as $ids){
            //?se obtiene el ultimo id;
            $endId = $ids['max(id_user)'];
    }

    $endId = $endId +1; 
}else{
    //TODO si no exiten datos se asiga el id por defalut(1)
    $endId = 1;
}
//?Preparacion de sentencia para el registro del usuario
$sql_user ="INSERT INTO registro_usuarios (id_user,ncontrol,usuario,area,planta) VALUES(?,?,?,?,?)";

//* Verifiacion de insertacion de datos
if (!$stmt = $conexion->prepare($sql_user)) {
    die("Error :" . $conexion->errno);
} else {
    $stmt->bind_param("iisss",$endId ,$ncontrol, $user,$area,$planta);
    if(!$stmt->execute()){
        die('Error en la preparación de la consulta: ' . ($stmt->error));
    }
}

//?Preparacion de sql para registro de respuestas
$sql_resp = "INSERT INTO respuestas (n_control,user_id,id_encuesta,id_pregunta,respuesta) VALUES (?, ?, ?, ?,?)";

$stmt = $conexion->prepare($sql_resp);

//*Comprobacion de consulta
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conexion->error);
} else {

    foreach ($_POST as $key => $value) {;

        //*busqueda de las respuestas dentro del form
        if (strpos($key, 'pregunta_') === 0) {

            //! Se reemplaza
            $id_pregunta = str_replace('pregunta_', '', $key);

            //?complementacion de sentencia
            $stmt->bind_param("iiiis", $ncontrol,$endId,$id_encuesta,$id_pregunta, $value);

            //*comprobacion de ejecucion
            if (!$stmt->execute()) {
                die('Error en la preparación de la consulta: ' . ($stmt->error));
            }
        }
    }
    $stmt->close();
}


$conexion->close();
echo '<script>
alert("Datos envias de manera correcta");
window.location.href = "../form.php?enc=1";
</script>';
