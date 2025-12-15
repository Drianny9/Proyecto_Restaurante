<?php
include_once 'model/Producto.php';
include_once 'database/database.php';


class ProductoDAO{

    public static function getProductoById($id_producto){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `producto` WHERE id_producto = ?");
        $stmt->bind_param('i', $id_producto); // La 'i' indica el tipo de dato (integer)
        $stmt->execute();
        $results = $stmt->get_result();

        $producto = $results->fetch_object('Producto');
        $con->close();

        return $producto;
    }

    public static function getProductos(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `producto`");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaProductos = [];
        while ($producto = $results->fetch_object('Producto')) {
            $listaProductos[] = $producto;
        }

        $con->close();
        return $listaProductos;
    }

    public static function crearProducto($nombre, $descripcion, $id_categoria, $precio_base, $imagen) {
        $con = Database::connect();
        $stmt = $con->prepare("INSERT INTO producto (nombre, descripcion, id_categoria, precio_base, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssids', $nombre, $descripcion, $id_categoria, $precio_base, $imagen);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

    public static function actualizarProducto($id, $nombre, $descripcion, $id_categoria, $precio_base, $imagen) {
        $con = Database::connect();
        $stmt = $con->prepare("UPDATE producto SET nombre=?, descripcion=?, id_categoria=?, precio_base=?, imagen=? WHERE id_producto=?");
        $stmt->bind_param('ssidsi', $nombre, $descripcion, $id_categoria, $precio_base, $imagen, $id);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

    public static function eliminarProducto($id) {
        $con = Database::connect();
        $stmt = $con->prepare("DELETE FROM producto WHERE id_producto=?");
        $stmt->bind_param('i', $id);
        $resultado = $stmt->execute();
        $con->close();
        return $resultado;
    }

}