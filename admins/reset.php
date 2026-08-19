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

    <header>
        <?php
        crNavbar($conexion, $_SESSION['permiso']);
        ?>
    </header>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Reseteo de contraseña
                    </div>

                    <?php if (! $_POST) {
                    ?>
                        <div class="card-body">
                            <form action="reset.php" method="post">
                                <div class="mb-3">

                                    <label class="form-label">Usuario</label>
                                    <?php
                                    //? creamos la sentencia SQL y la ejecutamos
                                    $ssql = "SELECT N_control, usuario FROM admins where N_control != $numcontrol;";
                                    $result = $conexion->query($ssql);
                                    ?>
                                    <select class="form-select" aria-label="Default select example" id="user" name="user">
                                        <option selected></option>
                                        <?php
                                        while ($row = $result->fetch_array()) {
                                            echo "<option value = " . $row['N_control'] . ">" . $row['N_control'] . ". - " . $row['usuario'] . "</option>";
                                            //echo '<option>' . $row["nombre"] . '</option>';
                                        }

                                        ?>
                                    </select>

                                </div>
                                <button type="submit" class="btn btn-primary w-100">Reset</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <?php
                    } else {

                        $passdefault = "x".$_POST['user'];
                            //!encriptacion de contraseña
                            $hashPass = password_hash($passdefault, PASSWORD_DEFAULT);



                            $sql = "UPDATE admins SET password = ? WHERE N_control = ?";
                            $stmt = $conexion->prepare($sql);
                            $stmt->bind_param("ss", $hashPass, $_POST['user']);


                            //?comprobacion de la actualizacion
                            if ($stmt->execute()) {
                                echo '<div class="card-body">
                    <div class="alert alert-success" role="alert"> Contraseña actualizada!!!!</div>';
                                echo ' <a href="index.php" class="btn btn-primary w-100" >Regresar </a>
                    </div>';
                            }
                        }
                    

    ?>
</body>

</html>