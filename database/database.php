<?php

    class Database{
        // ANTES (local):
        private static $host = 'localhost';
        private static $user = 'root';
        private static $pass = '';
        private static $db = 'cupra_eats';

        // DESPUÉS (InfinityFree):
        // private static $host = 'sql211.infinityfree.com';
        // private static $user = 'if0_40834807';           
        // private static $pass = 'Dribat19802002';       
        // private static $db   = 'if0_40834807_cupra_eats';  

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