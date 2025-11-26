<?php

    class Database{
        // Método estatico para establecer la conexion a la base de datos
        public static function connect($host='localhost', $user='root', $pass='', $db='cupra_eats'){
            $con = new mysqli($host, $user, $pass, $db);// Crear una nueva conexion utilizando mysqli
            if ($con->connect_error) {
                die("Conexion fallida: " .$con->connect_error);
            }
            return $con; // Retornar la conexión si funciona bien
        }
    }
?>