<?php
// API REST para gestión de logs
include_once __DIR__ . '/config.php';
include_once __DIR__ . '/../model/LogDAO.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            obtenerLog($_GET['id']);
        } else {
            obtenerLogs();
        }
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            eliminarLog($_GET['id']);
        } else {
            respuestaJSON('Fallido', null, 'ID de log requerido', 400);
        }
        break;
    default:
        respuestaJSON('Fallido', null, 'Método no permitido', 405);
}

// Obtener todos los logs
function obtenerLogs() {
    $logs = LogDAO::getLogs();
    $resultado = [];
    
    foreach ($logs as $log) {
        $resultado[] = [
            'id_log' => $log->getId_log(),
            'accion' => $log->getAccion(),
            'fecha_hora' => $log->getFecha_hora()
        ];
    }
    
    respuestaJSON('Exito', $resultado);
}

// Obtener un log específico
function obtenerLog($id) {
    $log = LogDAO::getLogById($id);
    
    if ($log) {
        $resultado = [
            'id_log' => $log->getId_log(),
            'accion' => $log->getAccion(),
            'fecha_hora' => $log->getFecha_hora()
        ];
        respuestaJSON('Exito', $resultado);
    } else {
        respuestaJSON('Fallido', null, 'Log no encontrado', 404);
    }
}

// Eliminar log
function eliminarLog($id) {
    $id_log = intval($id);
    
    $resultado = LogDAO::eliminarLog($id_log);
    
    if ($resultado) {
        respuestaJSON('Exito', null, 'Log eliminado correctamente');
    } else {
        respuestaJSON('Fallido', null, 'Error al eliminar el log', 500);
    }
}
