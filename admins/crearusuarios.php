<?php
session_start();

include("../conexion/conexion.php");
require_once("../procesos/operaciones.php");

if ($_SESSION['loggedin'] != TRUE ) {

    header('Location: login.html');
}elseif($_SESSION['permiso'] != 2){

    header('Location: index.php');

}
$area = $_SESSION['perfil'];

echo $area;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/text.css">
    <title>Crear Usuario</title>
</head>

<body>
    <header>
        <?php
        crNavbar($conexion, $_SESSION['permiso']);
        ?>
    </header>
    <br>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Crear usuario
                    </div>

                    <?php if (! $_POST) {
                    ?>
                        <div class="card-body">
                            <form action="crearusuarios.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">numero de control</label>
                                    <input type="number" class="form-control" id="nc" name="nc" name="nc" placeholder="Introduce numero de control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="user" name="user" placeholder="Introduce nombre y apellido" required>
                                </div>
                                <?php
                                echo '<input type="hidden" name="area" id="area" value="'. $area .'">';
                                ?>

                                <input type="hidden" name="planta" id="planta" value="Puebla">
                                <button type="submit" class="btn btn-primary w-100">Registrar usuario</button>
                            </form>
                        </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="overflow-auto">
                    <?php
                        $sql_user = "SELECT * FROM usuarios WHERE departamento = '$area' ";
                        $consulta_user = $conexion->query($sql_user);
                        if (!empty($consulta_user)) {
                    ?>

                        <table class="table table-striped table-hover" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NC</th>
                                    <th>NOMBRE</th>
                                    <th>PLANTA</th>
                                    <th>DEPARTAMENTO</th>
                                </tr>
                            </thead>
                            <tbody class="overflow-scroll">
                                <?php
                                $i = 1;
                                foreach ($consulta_user as $data) {
                                    echo "<tr>";
                                    echo "<th>" . $i . "</th>";
                                    echo "<th>" . $data['n_control'] . "</th>";
                                    echo "<th>" . $data['usuario'] . "</th>";
                                    echo "<th>" . $data['planta'] . "</th>";
                                    echo "<th>" . $data['departamento'] . "</th>";
                                    echo "</tr>";
                                    $i = $i + 1;
                                }
                                ?>
                                </tr>
                            </tbody>
                        </table>
                    <?php
                        } else {
                        }
                    ?>
            </div>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<?php
                    } else {




                        $sql_user = "INSERT INTO usuarios (n_control, usuario, planta,departamento) VALUES (?, ?, ?,?)";
                        $stmt = $conexion->prepare($sql_user);
                        $stmt->bind_param("isss", $_POST['nc'], $_POST['user'], $_POST['planta'], $_POST['area']);


                        //?comprobacion de la actualizacion
                        if ($stmt->execute()) {
                            echo '<div class="card-body">
                    <div class="alert alert-success" role="alert">Usuario exitosamente registrado!!!!</div>';
                            echo ' <a href="crearusuarios.php" class="btn btn-primary w-100" >Registrar otro usario </a>
                    </div>';
                        } else {
                            if (($conexion->errno) == 1062) {
                                echo '<div class="card-body">
                                <div class="alert alert-danger" role="alert" style="text-align: center;">
                                        Error: ' . $conexion->errno . '<br>
                                        ¡ El usuario ya se encuentra registrado !
                                </div>
                                <a href="crearusuarios.php" class="btn btn-primary w-100" >Registrar otro usuaio</a>
                            </div>';
                            }
                        }
                    }


?>
</body>

</html>


</body>

</html>