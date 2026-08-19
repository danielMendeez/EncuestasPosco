<?php
include("config.php");

//*conexion a la db
$conexion = new mysqli($servername, $userdb, $password, $dbname);

//?Comporbacion de conexion
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
} else {

    /* 
    !     * Nota: Posible confusión con UTF-8
    TODO: * Debido a que los nombres de los conjuntos de caracteres no contienen guiones, 
    TODO: * la cadena "utf8" es válida en MySQL para establecer el conjunto de caracteres a UTF-8. 
    TODO: * La cadena "utf-8" no es válida para cambiar el conjunto de caracteres.
    */
    //?comprobacion de conjuntos conjunto de caracteres
    if (!$conexion->set_charset('utf8')) {
        die("Error al cargar el conjunto de caracteres utf8: \n" . $conexion->error);
    }
}
