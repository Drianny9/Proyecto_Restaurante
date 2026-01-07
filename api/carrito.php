<?php
//Para finalizar pedido necesitamos hacer la API para guardarlo en la base de datos
include_once __DIR__ . '/../model/Usuario.php'; // Necesario para deserializar el objeto de sesión
session_start();
include_once __DIR__ . '/config.php';
include_once __DIR__ . '/../model/PedidoDAO.php';
include_once __DIR__ . '/../model/LineaPedidoDAO.php';
include_once __DIR__ . '/../model/ProductoDAO.php';

// Endpoint de API para finalizar el proceso de compra.
// Está orientado a un caso de uso ("procesar pedido") y no a un CRUD genérico.
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
    
    //Validamos que el carrito contiene productos
    $productos = isset($data['productos']) ? $data['productos'] : []; //Si no hay productos array vacio
    $total = isset($data['total']) ? floatval($data['total']) : 0; //Si no hay total es 0
    
    if (empty($productos)) {
        respuestaJSON('Fallido', null, 'El carrito está vacío', 400);
        return;
    }
    
    // Obtener id_usuario del objeto Usuario en la sesión para asociar el pedido al usuario
    $usuario = $_SESSION['usuario'];
    $id_usuario = $usuario->getId_usuario();
    
    // Crear el pedido
    $id_pedido = PedidoDAO::crearPedido($id_usuario, $total);
    
    if ($id_pedido) {
        // Crear las líneas del pedido
        foreach ($productos as $item) {
            $id_producto = intval($item['id_producto']);
            $cantidad = intval($item['cantidad']);
            
            // Usar precio con oferta si existe, sino el precio normal
            $precio_unidad = isset($item['precio_con_oferta']) ? floatval($item['precio_con_oferta']) : floatval($item['precio']);
            
            // Obtener id_oferta si existe
            $id_oferta = null;
            if (isset($item['oferta']) && isset($item['oferta']['id_oferta'])) {
                $id_oferta = intval($item['oferta']['id_oferta']);
            }
            
            LineaPedidoDAO::crearLineaPedido($id_pedido, $id_producto, $precio_unidad, $cantidad, $id_oferta);
        }
        
        respuestaJSON('Exito', ['id_pedido' => $id_pedido], 'Pedido creado correctamente', 201);
    } else {
        respuestaJSON('Fallido', null, 'Error al crear el pedido', 500);
    }
}