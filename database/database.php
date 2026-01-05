<?php

    class Database{
        // Configuración para XAMPP local
        private static $host = 'localhost';
        private static $user = 'root';
        private static $pass = '';
        private static $db = 'cupra_eats';

        // Método estatico para establecer la conexion a la base de datos
        public static function connect(){
            //Con self le decimos a php que use la variable que tenemos creada arriba
            $con = new mysqli(self::$host, self::$user, self::$pass, self::$db);
            
            if ($con->connect_error) {
                die("Conexion fallida: " . $con->connect_error);
            }
            
            return $con; // Retornar la conexión si funciona bien
        }
    }
?>