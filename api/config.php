<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Configuración comun en todas las APIs
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Función para respuestas en JSON
function respuestaJSON($estado, $data = null, $mensaje = null, $codigo = 200, $requiere_login = false) { //200 codigo HTTP de OK
    http_response_code($codigo);
    $respuesta = ['estado' => $estado]; //Creamos array asociativo con el estado
    if($data !== null) {$respuesta['data'] = $data;} //Añadimos 'data' al array $respuesta y le asignamos valor
    if($mensaje !== null) {$respuesta['mensaje'] = $mensaje;}
    if($requiere_login) {$respuesta['requiere_login'] = true;}
    echo json_encode($respuesta); //Convertimos el array a json
    exit;
}

//Función para verificar que el usuario es admin
function verificarAdmin() {
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getRol() !== 'admin') {
        respuestaJSON('Fallido', null, 'Acceso denegado. Se requieren permisos de administrador.', 403);
    }
}