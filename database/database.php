<?php

    class Database{
        public static function connect($host='localhost', $user='root', $pass='', $db='cupra_eats'){
            $con = new mysqli($host, $user, $pass, $db);
            if ($con->connect_error) {
                die("Conexion fallida: " .$con->connect_error);
            }
            return $con;
        }
    }

?>