<?php
// Iniciar sesión si no está iniciada para saber si el usuario esta logueado y tambien controlar permisos
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Configuración comun en todas las APIs
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Función para respuestas en JSON
function respuestaJSON($estado, $data = null, $mensaje = null, $codigo = 200, $requiere_login = false) {
    http_response_code($codigo); //Establecemos el codigo HTTP
    $respuesta = ['estado' => $estado];
    if($data !== null) {$respuesta['data'] = $data;}
    if($mensaje !== null) {$respuesta['mensaje'] = $mensaje;}
    if($requiere_login) {$respuesta['requiere_login'] = true;}
    
    //Convertimos el array a json con json_encode()
    // Usar JSON_INVALID_UTF8_SUBSTITUTE para manejar caracteres mal codificados
    // JSON_UNESCAPED_UNICODE para que deje las tildes y las ñ
    $json = json_encode($respuesta, JSON_INVALID_UTF8_SUBSTITUTE | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        http_response_code(500);
        //json_last... obtiene el mensaje de error de la ultima operacion JSON
        echo json_encode(['estado' => 'Fallido', 'mensaje' => 'Error al codificar JSON: ' . json_last_error_msg()]);
    } else {
        echo $json;
    }
    exit;
}

//Función para verificar que el usuario es admin
function verificarAdmin() {
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getRol() !== 'admin') {
        respuestaJSON('Fallido', null, 'Acceso denegado. Se requieren permisos de administrador.', 403);
    }
}