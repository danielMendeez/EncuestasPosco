<?php
session_start();
include '../conexion/conexion.php';
include '../procesos/operaciones.php'; 

$numcontrol = $_SESSION['numc'];

if ($_SESSION['loggedin'] != TRUE ) {

    header('Location: login.html');
}elseif($_SESSION['permiso'] != 1){

    header('Location: index.php');

}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/text.css">
    <title>Resetear contraseña</title>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Cambio de Contraseña
                    </div>

                    <?php if (! $_POST) {
                    ?>
                        <div class="card-body">
                <form action="" method="post">
                <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="pass1" name="pass1" placeholder="Introduce tu contraseña" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Confirma tu Contraseña</label>
                        <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Introduce tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <?php
                    } else {

                        if($_POST['pass1'] == $_POST['pass2']){
                            //!encriptacion de contraseña
                            $hashPass = password_hash($_POST['pass1'], PASSWORD_DEFAULT);



                            $sql = "UPDATE admins SET password = ? WHERE N_control = ?";
                            $stmt = $conexion->prepare($sql);
                            $stmt->bind_param("ss", $hashPass, $numcontrol);


                            //?comprobacion de la actualizacion
                            if ($stmt->execute()) {
                                
                            echo '<script>alert("Las contraseñas cambiada");
                            window.location.replace("index.php")</script>';
                            }
                        

                        }else{
                            echo '<script>alert("Las contraseñas no coinciden!");
                            window.location.replace("cambiarpass.php")</script>';
                        }
                    }

                    

    ?>
</body>

</html>