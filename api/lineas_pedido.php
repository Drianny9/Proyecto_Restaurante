<?php
include_once 'config.php';
include_once '../model/LineaPedidoDAO.php';

// Para saber qué acción quiere hacer el cliente (GET, POST, PUT o DELETE)
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        // Obtener línea por ID, líneas por pedido, o todas las líneas
        if (isset($_GET['id'])) {
            $linea = LineaPedidoDAO::getLineaPedidoById($_GET['id']);
            if ($linea) {
                respuestaJSON('Exito', $linea);
            } else {
                respuestaJSON('Fallido', null, 'Línea de pedido no encontrada', 404);
            }
        } elseif (isset($_GET['id_pedido'])) {
            // Obtener todas las líneas de un pedido específico
            $lineas = LineaPedidoDAO::getLineasByPedido($_GET['id_pedido']);
            respuestaJSON('Exito', $lineas);
        } else {
            // Si no tenemos ID devolvemos todas las líneas
            $lineas = LineaPedidoDAO::getLineasPedido();
            respuestaJSON('Exito', $lineas);
        }
        break;

    case 'POST':
        // Crear nueva línea de pedido
        $data = json_decode(file_get_contents("php://input"), true);

        // Validaciones de campos obligatorios
        if (isset($data['id_pedido']) && isset($data['id_producto']) && isset($data['precio_unidad']) && isset($data['cantidad'])) {
            // Preparamos los datos
            $id_pedido = $data['id_pedido'];
            $id_producto = $data['id_producto'];
            $precio_unidad = $data['precio_unidad'];
            $cantidad = $data['cantidad'];
            $id_oferta = isset($data['id_oferta']) ? $data['id_oferta'] : null;

            // Llamamos al DAO para crear línea
            $resultado = LineaPedidoDAO::crearLineaPedido($id_pedido, $id_producto, $precio_unidad, $cantidad, $id_oferta);

            if ($resultado) {
                respuestaJSON('Exito', null, 'Línea de pedido creada correctamente', 201);
            } else {
                respuestaJSON('Fallido', null, 'Error al crear línea de pedido', 500);
            }
        } else {
            respuestaJSON('Fallido', null, 'Datos incompletos', 400);
        }
        break;

    case 'PUT':
        // Actualizar línea de pedido existente
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['id'])) {
            // Preparar datos
            $id = $data['id'];
            $id_pedido = $data['id_pedido'];
            $id_producto = $data['id_producto'];
            $precio_unidad = $data['precio_unidad'];
            $cantidad = $data['cantidad'];
            $id_oferta = isset($data['id_oferta']) ? $data['id_oferta'] : null;

            // Actualizar en la BD
            $resultado = LineaPedidoDAO::actualizarLineaPedido($id, $id_pedido, $id_producto, $precio_unidad, $cantidad, $id_oferta);

            if ($resultado) {
                respuestaJSON('Exito', null, 'Línea de pedido actualizada correctamente');
            } else {
                respuestaJSON('Fallido', null, 'Error al actualizar línea de pedido', 500);
            }
        } else {
            respuestaJSON('Fallido', null, 'ID no proporcionado', 400);
        }
        break;

    case 'DELETE':
        // Eliminar línea de pedido
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['id'])) {
            $resultado = LineaPedidoDAO::eliminarLineaPedido($data['id']);

            if ($resultado) {
                respuestaJSON('Exito', null, 'Línea de pedido eliminada correctamente');
            } else {
                respuestaJSON('Fallido', null, 'Error al eliminar línea de pedido', 500);
            }
        } else {
            respuestaJSON('Fallido', null, 'ID no proporcionado', 400);
        }
        break;
    
    // Método no permitido
    default:
        respuestaJSON('Fallido', null, 'Método no permitido', 405);
        break;
}
