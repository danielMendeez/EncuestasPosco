<?php
session_start();

include("../conexion/conexion.php");
require_once("../procesos/operaciones.php");

if ($_SESSION['loggedin'] != TRUE ) {

    header('Location: login.html');
}elseif($_SESSION['permiso'] != 2){

    header('Location: index.php');

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/text.css">
    <title>consulta</title>
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
                        Consulta
                    </div>
                    <div class="card-body">
                        <form action="mostrar.php" method="post">
                            <div class="mb-3">

                                <label class="form-label">Encuesta</label>
                                <?php
                                // creamos la sentencia SQL y la ejecutamos
                                $perfil =  $_SESSION['perfil'];
                                $ssql = "SELECT * FROM encuesta Where perfil = '$perfil'";
                                $result = $conexion->query($ssql);
                                ?>
                                <select class="form-select" aria-label="Default select example" id="encuesta" name="encuesta">
                                    <?php
                                    while ($row = $result->fetch_array()) {
                                        echo "<option value = " . $row['id_encuesta'] . ">" . $row['id_encuesta'] . ". - " . $row['nombre'] . "</option>";
                                        //echo '<option>' . $row["nombre"] . '</option>';
                                    }

                                    ?>
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha de incio</label>
                                <input type="date" class="form-control" id="date1" name="date1" placeholder="Introduce tu contraseña" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha de cierre</label>
                                <input type="date" class="form-control" id="date2" name="date2" placeholder="Introduce tu contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">consulta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Obtener la fecha actual
        const hoy = new Date();
        // Formatear la fecha en formato YYYY-MM-DD
  

        var primerDia = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        var ultimoDia = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);

        const fechaFormateada1 = primerDia.toISOString().split('T')[0];
        const fechaFormateada2 = ultimoDia.toISOString().split('T')[0];
        // Asignar la fecha formateada al input
        document.getElementById('date1').value = fechaFormateada1;
        document.getElementById('date2').value = fechaFormateada2;
    </script>


</body>

</html>