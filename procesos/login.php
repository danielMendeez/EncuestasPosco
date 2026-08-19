<?php
include('../conexion/conexion.php');

session_start();

$numcon = $_POST['nc'];

$stmt = $conexion->prepare('SELECT id_admin,usuario,password,perfil,n_permiso FROM admins WHERE N_control = ?');
$stmt->bind_param("i", $numcon);
$stmt->execute();

$passdef = "x" . $numcon;


$stmt->bind_result($idUser, $nameUser, $hashpass, $perfilUser, $permiso);

if ($stmt->fetch()) {

    if (1==1) {

        //Actualiza el id de sesión actual con uno generado más reciente
        session_regenerate_id();

        //Creacon de variables $_SESSION
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['user'] =  $nameUser;
        $_SESSION['id'] = $idUser;
        $_SESSION['numc'] = $numcon;
        $_SESSION['perfil'] = $perfilUser;
        $_SESSION['permiso'] = $permiso;

        $stmt->close();

        if ($_POST['pass'] == $passdef) {


            echo '<script>alert("Login exitoso. Tienes la contraseña por default. Favor de cambiarla.");
        window.location.replace("../admins/cambiarpass.php")</script>';
        } else {

            echo '<script>alert("Login exitoso");
        window.location.replace("../admins/index.php")</script>';
        }
        //header('Location: index.html');
        exit();
    } else {
        echo '<script>alert("Contraseña incorrecta!");
        window.location.replace("../admins/login.html")</script>';
        //header('Location: index.html');
        exit();
    }
} else {
    $stmt->close();
    echo '<script>alert("El usuario no existe!");
        window.location.replace("../admins/login.html")</script>';
    //header('Location: index.html');
    exit();
}
