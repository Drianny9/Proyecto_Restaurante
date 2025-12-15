<?php
include_once 'config.php';
include_once 'model/ProductoDAO.php';

//Para saber que acción quiere hacer el cliente (GET, POST, PUT o DELETE)
$metodo = $_SERVER['REQUEST_METHOD'];

switch($metodo){
    case 'GET':
        //Obtener todos los productos o uno por ID
        if(isset($_GET['id'])){
            $producto = ProductoDAO::getProductoById($_GET['id']);
            if($producto){
                respuestaJSON('Exito', $producto);
            } else {
                respuestaJSON('Fallido', null, 'Producto no encontrado', 404);
            }
        } else {
            //Si no tenemos ID devolvemos todos los productos
            $productos = ProductoDAO::getProductos();
            respuestaJSON('Exito', $productos);
        }
        break;

    case 'POST':
        //Crear nuevo producto
        //json_decode convierte de json a array asociativo de php
        $data = json_decode(file_get_contents("php://input"), true); //file_get_contents obtiene el json que envia el cliente
        
        if(isset($data['nombre']) && isset($data['precio_base']) && isset($data['id_categoria'])){
            $resultado = ProductoDAO::crearProducto(
                $data['nombre'],
                $data['descripcion'] ?? null,
                $data['id_categoria'],
                $data['precio_base'],
                $data['imagen'] ?? null
            );
            
            if($resultado){
                respuestaJSON('Exito', null, 'Producto creado correctamente', 201);
            } else {
                respuestaJSON('Fallido', null, 'Error al crear producto', 500);
            }
        } else {
            respuestaJSON('Fallido', null, 'Datos incompletos', 400);
        }
        break;

    case 'PUT':
        //Actualizar producto existente
        $data = json_decode(file_get_contents("php://input"), true);
        
        if(isset($data['id'])){
            $resultado = ProductoDAO::actualizarProducto(
                $data['id'],
                $data['nombre'],
                $data['descripcion'] ?? null,
                $data['id_categoria'],
                $data['precio_base'],
                $data['imagen'] ?? null
            );
            
            if($resultado){
                respuestaJSON('Exito', null, 'Producto actualizado correctamente');
            } else {
                respuestaJSON('Fallido', null, 'Error al actualizar producto', 500);
            }
        } else {
            respuestaJSON('Fallido', null, 'ID no proporcionado', 400);
        }
        break;

    case 'DELETE':
        //Eliminar producto
        $data = json_decode(file_get_contents("php://input"), true);
        
        if(isset($data['id'])){
            $resultado = ProductoDAO::eliminarProducto($data['id']);
            
            if($resultado){
                respuestaJSON('Exito', null, 'Producto eliminado correctamente');
            } else {
                respuestaJSON('Fallido', null, 'Error al eliminar producto', 500);
            }
        } else {
            respuestaJSON('Fallido', null, 'ID no proporcionado', 400);
        }
        break;

    default:
        respuestaJSON('Fallido', null, 'Metodo no permitido', 405);
        break;
}