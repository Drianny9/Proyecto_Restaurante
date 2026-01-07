<?php

    class Database{
        // ====USO LOCAL====:
        // private static $host = 'localhost';
        // private static $user = 'root';
        // private static $pass = '';
        // private static $db = 'cupra_eats';
        // private static $port = 3306;

        //====USO(InfinityFree)====:
        // private static $host = 'sql211.infinityfree.com';
        // private static $user = 'if0_40834807';           
        // private static $pass = 'Dribat19802002';       
        // private static $db   = 'if0_40834807_cupra_eats'; 
        
        //====USO DOCKER====
        private static $host = "127.0.0.1";
        private static $user = "root";
        private static $pass = "root";
        private static $db   = "cupra_eats";
        private static $port = 3307; //Puerto del docker

        // Método estatico para establecer la conexion a la base de datos
        public static function connect(){
            //Con self le decimos a php que use la variable que tenemos creada arriba
            $con = new mysqli(self::$host, self::$user, self::$pass, self::$db, self::$port);
            
            if ($con->connect_error) {
                die("Conexion fallida: " . $con->connect_error);
            }
            
            // Establecer charset UTF-8 para manejar correctamente los caracteres especiales
            $con->set_charset("utf8mb4");
            
            return $con; // Retornar la conexión si funciona bien
        }
    }
?>