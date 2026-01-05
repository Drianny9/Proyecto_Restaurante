<?php

    class Database{
        // Configuración para Docker o XAMPP local
        // Detecta automáticamente si está en Docker (host='db') o local (host='localhost')
        
        private static $host_docker = 'db';           // Nombre del servicio en docker-compose
        private static $host_local = 'localhost';     // XAMPP local
        private static $user_docker = 'cupra_user';
        private static $user_local = 'root';
        private static $pass_docker = 'cupra_password';
        private static $pass_local = '';
        private static $db = 'cupra_eats';

        // Método estatico para establecer la conexion a la base de datos
        public static function connect(){
            // Intentar conexión Docker primero, si falla usar local
            $con = @new mysqli(self::$host_docker, self::$user_docker, self::$pass_docker, self::$db);
            
            if ($con->connect_error) {
                // Si falla Docker, intentar conexión local (XAMPP)
                $con = new mysqli(self::$host_local, self::$user_local, self::$pass_local, self::$db);
                
                if ($con->connect_error) {
                    die("Conexion fallida: " . $con->connect_error);
                }
            }
            
            return $con; // Retornar la conexión si funciona bien
        }
    }
?>