<?php
// API REST para gestión de usuarios
include_once __DIR__ . '/config.php';
include_once __DIR__ . '/../model/UsuarioDAO.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            obtenerUsuario($_GET['id']);
        } else {
            obtenerUsuarios();
        }
        break;
    case 'POST':
        crearUsuario();
        break;
    case 'PUT':
        actualizarUsuario();
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            eliminarUsuario($_GET['id']);
        } else {
            respuestaJSON('Fallido', null, 'ID de usuario requerido', 400);
        }
        break;
    default:
        respuestaJSON('Fallido', null, 'Método no permitido', 405);
}

// Obtener todos los usuarios
function obtenerUsuarios() {
    $usuarios = UsuarioDAO::getUsuarios();
    $resultado = [];
    
    foreach ($usuarios as $usuario) {
        $resultado[] = [
            'id_usuario' => $usuario->getId_usuario(),
            'nombre' => $usuario->getNombre(),
            'email' => $usuario->getEmail(),
            'direccion' => $usuario->getDireccion(),
            'telefono' => $usuario->getTelefono(),
            'rol' => $usuario->getRol()
        ];
    }
    
    respuestaJSON('Exito', $resultado);
}

// Obtener un usuario específico
function obtenerUsuario($id) {
    $usuario = UsuarioDAO::getUsuarioById($id);
    
    if ($usuario) {
        $resultado = [
            'id_usuario' => $usuario->getId_usuario(),
            'nombre' => $usuario->getNombre(),
            'email' => $usuario->getEmail(),
            'direccion' => $usuario->getDireccion(),
            'telefono' => $usuario->getTelefono(),
            'rol' => $usuario->getRol()
        ];
        respuestaJSON('Exito', $resultado);
    } else {
        respuestaJSON('Fallido', null, 'Usuario no encontrado', 404);
    }
}

// Crear un nuevo usuario
function crearUsuario() {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['nombre']) || !isset($data['email']) || !isset($data['password'])) {
        respuestaJSON('Fallido', null, 'Datos incompletos: nombre, email y contraseña son requeridos', 400);
        return;
    }
    
    $nombre = $data['nombre'];
    $email = $data['email'];
    $password = $data['password'];
    $direccion = isset($data['direccion']) ? $data['direccion'] : null;
    $telefono = isset($data['telefono']) ? $data['telefono'] : null;
    $rol = isset($data['rol']) ? $data['rol'] : 'user';
    
    $resultado = UsuarioDAO::registrarusuarios($nombre, $email, $password, $direccion, $telefono, $rol);
    
    if ($resultado) {
        respuestaJSON('Exito', null, 'Usuario creado correctamente', 201);
    } else {
        respuestaJSON('Fallido', null, 'El email ya está registrado', 400);
    }
}

// Actualizar usuario
function actualizarUsuario() {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['id_usuario'])) {
        respuestaJSON('Fallido', null, 'ID de usuario requerido', 400);
        return;
    }
    
    $id_usuario = intval($data['id_usuario']);
    $nombre = isset($data['nombre']) ? $data['nombre'] : null;
    $email = isset($data['email']) ? $data['email'] : null;
    $direccion = isset($data['direccion']) ? $data['direccion'] : null;
    $telefono = isset($data['telefono']) ? $data['telefono'] : null;
    $rol = isset($data['rol']) ? $data['rol'] : null;
    
    $resultado = UsuarioDAO::actualizarUsuario($id_usuario, $nombre, $email, $direccion, $telefono, $rol);
    
    if ($resultado) {
        respuestaJSON('Exito', null, 'Usuario actualizado correctamente');
    } else {
        respuestaJSON('Fallido', null, 'Error al actualizar el usuario', 500);
    }
}

// Eliminar usuario
function eliminarUsuario($id) {
    $id_usuario = intval($id);
    
    // Obtener info del usuario antes de eliminarlo para el log
    $usuario = UsuarioDAO::getUsuarioById($id_usuario);
    $emailUsuario = $usuario ? $usuario->getEmail() : "ID {$id_usuario}";
    
    $resultado = UsuarioDAO::eliminarUsuario($id_usuario);
    
    if ($resultado) {
        respuestaJSON('Exito', null, 'Usuario eliminado correctamente');
    } else {
        respuestaJSON('Fallido', null, 'Error al eliminar el usuario', 500);
    }
}
