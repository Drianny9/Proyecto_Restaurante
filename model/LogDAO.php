<?php
include_once 'model/Log.php';
include_once 'database/database.php';


class Usuario{

    public static function getLogById($id_log){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `log` WHERE id_log = ?");
        $stmt->bind_param('i', $id_log); //La 'i' indica el tipo de dato (integer)
        $stmt->execute();
        $results = $stmt->get_result();

        $equipo = $results->fetch_object('Log');
        $con->close();

        return $equipo;
    }

    public static function getLogs(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `log`");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaLogs = [];
        while ($log = $results->fetch_object('Log')) {
            $listaUsuarios[] = $log;
        }

        $con->close();
        return $listaLogs;
    }

}