<?php
// API REST para gestión de pedidos
session_start();
include_once __DIR__ . '/config.php';
include_once __DIR__ . '/../model/PedidoDAO.php';
include_once __DIR__ . '/../model/LineaPedidoDAO.php';
include_once __DIR__ . '/../model/UsuarioDAO.php';
include_once __DIR__ . '/../model/ProductoDAO.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            obtenerPedido($_GET['id']);
        } else {
            obtenerPedidos();
        }
        break;
    case 'PUT':
        actualizarEstadoPedido();
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            eliminarPedido($_GET['id']);
        } else {
            respuestaJSON('Fallido', null, 'ID de pedido requerido', 400);
        }
        break;
    default:
        respuestaJSON('Fallido', null, 'Método no permitido', 405);
}

// Obtener todos los pedidos con información del usuario
function obtenerPedidos() {
    $pedidos = PedidoDAO::getPedidos();
    $resultado = [];
    
    foreach ($pedidos as $pedido) {
        // Obtener información del usuario
        $usuario = UsuarioDAO::getUsuarioById($pedido->getId_usuario());
        $nombreUsuario = $usuario ? $usuario->getNombre() : 'Usuario eliminado';
        
        // Obtener líneas del pedido
        $lineas = LineaPedidoDAO::getLineasByPedido($pedido->getId_pedido());
        $lineasInfo = [];
        
        foreach ($lineas as $linea) {
            $producto = ProductoDAO::getProductoById($linea->getId_producto());
            $lineasInfo[] = [
                'id_linea' => $linea->getId_linea(),
                'id_producto' => $linea->getId_producto(),
                'nombre_producto' => $producto ? $producto->getNombre() : 'Producto eliminado',
                'cantidad' => $linea->getCantidad(),
                'precio_unidad' => $linea->getPrecio_unidad()
            ];
        }
        
        $resultado[] = [
            'id_pedido' => $pedido->getId_pedido(),
            'fecha' => $pedido->getFecha(),
            'estado' => $pedido->getEstado(),
            'importe_total' => $pedido->getImporte_total(),
            'id_usuario' => $pedido->getId_usuario(),
            'nombre_usuario' => $nombreUsuario,
            'lineas' => $lineasInfo
        ];
    }
    
    respuestaJSON('Exito', $resultado);
}

// Obtener un pedido específico
function obtenerPedido($id) {
    $pedido = PedidoDAO::getPedidoById($id);
    
    if ($pedido) {
        $usuario = UsuarioDAO::getUsuarioById($pedido->getId_usuario());
        $lineas = LineaPedidoDAO::getLineasByPedido($pedido->getId_pedido());
        $lineasInfo = [];
        
        foreach ($lineas as $linea) {
            $producto = ProductoDAO::getProductoById($linea->getId_producto());
            $lineasInfo[] = [
                'id_linea' => $linea->getId_linea(),
                'id_producto' => $linea->getId_producto(),
                'nombre_producto' => $producto ? $producto->getNombre() : 'Producto eliminado',
                'cantidad' => $linea->getCantidad(),
                'precio_unidad' => $linea->getPrecio_unidad()
            ];
        }
        
        $resultado = [
            'id_pedido' => $pedido->getId_pedido(),
            'fecha' => $pedido->getFecha(),
            'estado' => $pedido->getEstado(),
            'importe_total' => $pedido->getImporte_total(),
            'id_usuario' => $pedido->getId_usuario(),
            'nombre_usuario' => $usuario ? $usuario->getNombre() : 'Usuario eliminado',
            'lineas' => $lineasInfo
        ];
        
        respuestaJSON('Exito', $resultado);
    } else {
        respuestaJSON('Fallido', null, 'Pedido no encontrado', 404);
    }
}

// Actualizar estado del pedido
function actualizarEstadoPedido() {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['id_pedido']) || !isset($data['estado'])) {
        respuestaJSON('Fallido', null, 'Datos incompletos', 400);
        return;
    }
    
    $id_pedido = intval($data['id_pedido']);
    $estado = $data['estado'];
    
    // Validar estados permitidos
    $estadosPermitidos = ['pendiente', 'preparando', 'listo', 'entregado', 'cancelado'];
    if (!in_array($estado, $estadosPermitidos)) {
        respuestaJSON('Fallido', null, 'Estado no válido', 400);
        return;
    }
    
    $resultado = PedidoDAO::actualizarEstadoPedido($id_pedido, $estado);
    
    if ($resultado) {
        respuestaJSON('Exito', null, 'Estado actualizado correctamente');
    } else {
        respuestaJSON('Fallido', null, 'Error al actualizar el estado', 500);
    }
}

// Eliminar pedido
function eliminarPedido($id) {
    $id_pedido = intval($id);
    
    // Primero eliminar las líneas del pedido
    $lineas = LineaPedidoDAO::getLineasByPedido($id_pedido);
    foreach ($lineas as $linea) {
        LineaPedidoDAO::eliminarLineaPedido($linea->getId_linea());
    }
    
    // Luego eliminar el pedido
    $resultado = PedidoDAO::eliminarPedido($id_pedido);
    
    if ($resultado) {
        respuestaJSON('Exito', null, 'Pedido eliminado correctamente');
    } else {
        respuestaJSON('Fallido', null, 'Error al eliminar el pedido', 500);
    }
}
