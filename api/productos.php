<?php
include_once 'config.php';
include_once '../model/ProductoDAO.php';

//Para saber que acción quiere hacer el cliente (GET, POST, PUT o DELETE)
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        //Obtener todos los productos o uno por ID
        if (isset($_GET['id'])) {
            $producto = ProductoDAO::getProductoById($_GET['id']);
            if ($producto) {
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

        //Validaciones de campos obligatorios
        if (isset($data['nombre']) && isset($data['precio_base']) && isset($data['id_categoria'])) {
            //Preparamos los datos
            $nombre = $data['nombre'];
            $descripcion = isset($data['descripcion']) ? $data['descripcion'] : null;
            $id_categoria = $data['id_categoria'];
            $precio_base = $data['precio_base'];
            $imagen = isset($data['imagen']) ? $data['imagen'] : null;

            //Llamamos al DAO para crear producto
            $resultado = ProductoDAO::crearProducto($nombre, $descripcion, $id_categoria, $precio_base, $imagen); //Llamada al metodo estatico del DAO

            if ($resultado) {
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

        if (isset($data['id'])) {
            // Preparar datos
            $id = $data['id'];
            $nombre = $data['nombre'];
            $descripcion = isset($data['descripcion']) ? $data['descripcion'] : null;
            $id_categoria = $data['id_categoria'];
            $precio_base = $data['precio_base'];
            $imagen = isset($data['imagen']) ? $data['imagen'] : null;

            // Actualizar en la BD
            $resultado = ProductoDAO::actualizarProducto($id, $nombre, $descripcion, $id_categoria, $precio_base, $imagen);

            if ($resultado) {
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

        if (isset($data['id'])) {
            $id = $data['id'];
            
            // Obtener info del producto antes de eliminarlo para el log
            $producto = ProductoDAO::getProductoById($id);
            $nombreProducto = $producto ? $producto->getNombre() : "ID {$id}";
            
            $resultado = ProductoDAO::eliminarProducto($id);

            if ($resultado) {
                respuestaJSON('Exito', null, 'Producto eliminado correctamente');
            } else {
                respuestaJSON('Fallido', null, 'Error al eliminar producto', 500);
            }
        } else {
            respuestaJSON('Fallido', null, 'ID no proporcionado', 400);
        }
        break;
    
    //Metodo no permitido
    default:
        respuestaJSON('Fallido', null, 'Metodo no permitido', 405);
        break;
}
