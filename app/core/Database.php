<?php

namespace App\Core;

use mysqli;

class Database
{
    private static ?mysqli $connection = null;

    public static function getConnection(): mysqli
    {
        if (self::$connection === null) {
            $host = Env::get('DB_HOST', 'localhost');
            $user = Env::get('DB_USER', 'root');
            $pass = Env::get('DB_PASS', '');
            $name = Env::get('DB_NAME', 'poscoform');

            $conn = new mysqli($host, $user, $pass, $name);

            if ($conn->connect_error) {
                die('Conexión fallida: ' . $conn->connect_error);
            }

            if (!$conn->set_charset('utf8')) {
                die('Error al cargar el conjunto de caracteres utf8: ' . $conn->error);
            }

            self::$connection = $conn;
        }

        return self::$connection;
    }
}
