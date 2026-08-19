<?php
//TODO funcion para generar formulario de encuesta
function generarForm($conexion, $perfil)
{
    //? Consulta para obtener el nombre de la encuesta
    $sql = "SELECT * FROM encuesta WHERE id_encuesta = $perfil";
    $result2 = $conexion->query($sql);

    //? Inicio de la etiqueta div card-header
    echo '<div class="card-header">';


    foreach ($result2 as $row) {
        echo ' <h4>
        <img src="img/posco.png" alt="posco logo" width="30%">
        Encuesta: ' . $row['nombre'] . ' 
            </h4>

</div>';
    }
    echo '
                    <div class="card-body">
                        <p>!Bienvenido!<br> Este es un encuesta de las mejoras que puedas aportar.</p>

    ';

    //?Sintaxis para la seleccion de pregunta
    $sql = "SELECT id_pregunta,pregunta, Tipo_pregunta FROM preguntas WHERE id_encuesta = $perfil";

    //*verifiacion de consulta
    if ($result = $conexion->query($sql)) {


        if (!empty($result)) {

            //? incio  de etiqueta form
            echo '<form action="procesos/envios.php" method = "post">';

            //*impresion de label y cuadros de texto
            foreach ($result as $row) {

                    if ($row['Tipo_pregunta'] === "text") {

                        echo ' <div class="mb-3">';
                        echo '<label  class="form-label">' . $row['pregunta'] . '</label>';
                        echo '<textarea class="form-control" id="pregunta_' . $row['id_pregunta'] . '" name = "pregunta_' . $row['id_pregunta'] . '" " required></textarea>
                        </div>';
                    }
					 if ($row['Tipo_pregunta'] === "check") {

                        echo ' <div class="mb-3">';
                        echo '<label  class="form-label">' . $row['pregunta'] . '</label>';
                        echo '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike"><label for="vehicle1"> Opcion</label><br>
                        </div>';
                    }
					if ($row['Tipo_pregunta'] === "input") {

                        echo ' <div class="mb-3">';
                        echo '<label  class="form-label">' . $row['pregunta'] . '</label>';
                        echo '<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike"><label for="vehicle1"> Opcion</label><br>
                        </div>';
                    }
					if ($row['Tipo_pregunta'] === "fecha") {

                        echo ' <div class="mb-3">';
                        echo '<label  class="form-label">' . $row['pregunta'] . '</label>';
                        echo '<input type="date" id="vehicle1" name="vehicle1" ><label for="vehicle1"> fecha</label><br>
                        </div>';
                    }
                }
            }
            //? input para el id de la encuesta2
            echo '<input type="hidden" name="id_encuesta" id="id_encuesta" value="'. $perfil .'">';
            echo '<input type="hidden" name="almacen" id="id_encuesta" value="ALMACEN">';
            echo '<input type="hidden" name="puebla" id="id_encuesta" value="PUEBLA">';

            //?Button
            echo '<div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit"  class="btn btn-primary" id="submitButton">Enviar</button>
            </div>
                </form> 
                </div>
                ';
        }

        /* liberar el conjunto de resultados */
        $result->close();


    return;
}

//?Funcion para crear las opciones en base al perfil
function opciones($conexion, $permiso)
{

    $sql_opc = "SELECT opciones,ruta FROM permisos WHERE nivel = $permiso ";
    $consulopc = $conexion->query($sql_opc);

    if(!empty($consulopc)){

        foreach($consulopc as $row){
            /*echo '
            <div class="card" style="width: 18rem;">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick exam.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
            ';*/
            echo '<div class="d-grid gap-2 col-6 mx-auto">
            <a class="btn btn-primary" href="'. $row['ruta'].'">' . $row['opciones'] . '</a>
        </div> <br> <br>';
        }
    }
}

function crNavbar($conexion, $permiso)
{

    $sql_nav = "SELECT opciones,ruta FROM permisos WHERE nivel = $permiso ";
    $navopc = $conexion->query($sql_nav);

    if(!empty($navopc)){

        //* Inicio del div navbar
        echo '
        <div class="navbar">
        <div class="logo"><a href="Index.php">POSCO MPPC</a></div>
        <ul class="links">';

    //? Generacion de botones para el navbar
    foreach ($navopc as $row) {
        echo '<li><a href="' . $row['ruta']. '">' . $row['opciones'] . '</a></li>';
    }
    echo '<a href="../procesos/logout.php" class="action_btn">Cerrar sesion</a>';

    }else{
        die('No existen datos');
    }


}
