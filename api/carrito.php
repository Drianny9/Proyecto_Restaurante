<?php
//Para finalizar pedido necesitamos hacer la API para guardarlo en la base de datos
session_start();
include_once __DIR__ . '/config.php';
include_once __DIR__ . '/../model/PedidoDAO.php';
include_once __DIR__ . '/../model/LineaPedidoDAO.php';
include_once __DIR__ . '/../model/ProductoDAO.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $accion = isset($data['accion']) ? $data['accion'] : '';
    
    switch ($accion) {
        case 'procesar':
            procesarPedido($data);
            break;
        default:
            respuestaJSON('Fallido', null, 'Acción no válida', 400);
    }
} else {
    respuestaJSON('Fallido', null, 'Método no permitido', 405);
}

function procesarPedido($data) {
    // Verificar que el usuario esté logueado
    if (!isset($_SESSION['usuario'])) {
        respuestaJSON('Fallido', null, 'Debes iniciar sesión para realizar un pedido', 401, true);
        return;
    }
    
    $productos = isset($data['productos']) ? $data['productos'] : [];
    $total = isset($data['total']) ? floatval($data['total']) : 0;
    
    if (empty($productos)) {
        respuestaJSON('Fallido', null, 'El carrito está vacío', 400);
        return;
    }
    
    $id_usuario = $_SESSION['usuario']['id_usuario'];
    
    // Crear el pedido
    $id_pedido = PedidoDAO::crearPedido($id_usuario, $total);
    
    if ($id_pedido) {
        // Crear las líneas del pedido
        foreach ($productos as $item) {
            $id_producto = intval($item['id_producto']);
            $cantidad = intval($item['cantidad']);
            $precio_unidad = floatval($item['precio']);
            $id_oferta = null; // No hay oferta por defecto
            
            LineaPedidoDAO::crearLineaPedido($id_pedido, $id_producto, $precio_unidad, $cantidad, $id_oferta);
        }
        
        respuestaJSON('Exito', ['id_pedido' => $id_pedido], 'Pedido creado correctamente', 201);
    } else {
        respuestaJSON('Fallido', null, 'Error al crear el pedido', 500);
    }
}

// Función para respuesta JSON con campo requiere_login
function respuestaJSON($estado, $data = null, $mensaje = '', $codigo = 200, $requiere_login = false) {
    http_response_code($codigo);
    header('Content-Type: application/json');
    echo json_encode([
        'estado' => $estado,
        'data' => $data,
        'mensaje' => $mensaje,
        'requiere_login' => $requiere_login
    ]);
    exit;
}