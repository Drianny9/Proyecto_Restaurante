<?php
include_once __DIR__ . '/Log.php';
include_once __DIR__ . '/../database/database.php';


class LogDAO{

    public static function getLogById($id_log){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `log` WHERE id_log = ?");
        $stmt->bind_param('i', $id_log);
        $stmt->execute();
        $results = $stmt->get_result();

        $log = $results->fetch_object('Log');
        $con->close();

        return $log;
    }

    public static function getLogs(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `log` ORDER BY fecha_hora DESC");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaLogs = [];
        while ($log = $results->fetch_object('Log')) {
            $listaLogs[] = $log;
        }

        $con->close();
        return $listaLogs;
    }

    public static function crearLog($accion) {
        $con = Database::connect();
        $fecha_hora = date('Y-m-d H:i:s');
        $stmt = $con->prepare("INSERT INTO `log` (accion, fecha_hora) VALUES (?, ?)");
        $stmt->bind_param('ss', $accion, $fecha_hora);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }

    public static function eliminarLog($id_log) {
        $con = Database::connect();
        $stmt = $con->prepare("DELETE FROM `log` WHERE id_log = ?");
        $stmt->bind_param('i', $id_log);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }
}