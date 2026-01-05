<?php
include_once __DIR__ . '/LineaPedido.php';
include_once __DIR__ . '/../database/database.php';


class LineaPedidoDAO{

    public static function getLineaPedidoById($id_linea){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `linea_pedido` WHERE id_linea = ?");
        $stmt->bind_param('i', $id_linea); // La 'i' indica el tipo de dato (integer)
        $stmt->execute();
        $results = $stmt->get_result();

        $lineaPedido = $results->fetch_object('LineaPedido');
        $con->close();

        return $lineaPedido;
    }

    public static function getLineasPedido(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `linea_pedido`");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaLineasPedido = [];
        while ($lineaPedido = $results->fetch_object('LineaPedido')) {
            $listaLineasPedido[] = $lineaPedido;
        }

        $con->close();
        return $listaLineasPedido;
    }

     public static function crearLineaPedido($id_pedido, $id_producto, $precio_unidad, $cantidad, $id_oferta = null) {
        $con = Database::connect();
        
        // Si id_oferta es null, usamos una consulta sin ese campo
        if ($id_oferta === null) {
            $stmt = $con->prepare("INSERT INTO `linea_pedido` (id_pedido, id_producto, precio_unidad, cantidad) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('iidi', $id_pedido, $id_producto, $precio_unidad, $cantidad);
        } else {
            $stmt = $con->prepare("INSERT INTO `linea_pedido` (id_pedido, id_producto, precio_unidad, cantidad, id_oferta) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('iidii', $id_pedido, $id_producto, $precio_unidad, $cantidad, $id_oferta);
        }
        
        $results = $stmt->execute();
        $con->close();
        return $results;
    }

    // Obtener todas las líneas de un pedido
    public static function getLineasByPedido($id_pedido) {
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `linea_pedido` WHERE id_pedido = ?");
        $stmt->bind_param('i', $id_pedido);
        $stmt->execute();
        $results = $stmt->get_result();
        
        $listaLineas = [];
        while ($linea = $results->fetch_object('LineaPedido')) {
            $listaLineas[] = $linea;
        }
        
        $con->close();
        return $listaLineas;
    }

    // Actualizar línea de pedido
    public static function actualizarLineaPedido($id_linea, $id_pedido, $id_producto, $precio_unidad, $cantidad, $id_oferta) {
        $con = Database::connect();
        $stmt = $con->prepare("UPDATE `linea_pedido` SET id_pedido = ?, id_producto = ?, precio_unidad = ?, cantidad = ?, id_oferta = ? WHERE id_linea = ?");
        $stmt->bind_param('iidiii', $id_pedido, $id_producto, $precio_unidad, $cantidad, $id_oferta, $id_linea);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }

    // Eliminar línea de pedido
    public static function eliminarLineaPedido($id_linea) {
        $con = Database::connect();
        $stmt = $con->prepare("DELETE FROM `linea_pedido` WHERE id_linea = ?");
        $stmt->bind_param('i', $id_linea);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }

}