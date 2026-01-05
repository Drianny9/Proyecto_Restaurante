<?php
include_once __DIR__ . '/Pedido.php';
include_once __DIR__ . '/../database/database.php';


class PedidoDAO{

    public static function getPedidoById($id_pedido){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `pedido` WHERE id_pedido = ?");
        $stmt->bind_param('i', $id_pedido); // La 'i' indica el tipo de dato (integer)
        $stmt->execute();
        $results = $stmt->get_result();

        $pedido = $results->fetch_object('Pedido');
        $con->close();

        return $pedido;
    }

    public static function getPedidos(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `pedido` ORDER BY fecha DESC");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaPedidos = [];
        while ($pedido = $results->fetch_object('Pedido')) {
            $listaPedidos[] = $pedido;
        }

        $con->close();
        return $listaPedidos;
    }

    public static function getPedidosByUsuario(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `pedido` WHERE id_usuario = ? ORDER BY fecha DESC"); // el ? es un placeholder que pasamos con bind_param
        $stmt-> bind_param('i', $id_usuario);
        $stmt->execute();
        $results = $stmt->get_result();
        $listaPedidos = [];
        while ($pedido = $results->fetch_object('Pedido')) {
            $listaPedidos[] = $pedido;
        }

        $con->close();
        return $listaPedidos;
    }

    public static function crearPedido($id_usuario, $importe_total) { //Pasamos los atributos que pueden cambiar
        $con = Database::connect();
        $fecha = date('Y-m-d H:i:s');
        $estado = 'pendiente';
        $stmt = $con->prepare("INSERT INTO pedido (fecha, estado, importe_total, id_usuario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssdi', $fecha, $estado, $importe_total, $id_usuario);
        $stmt->execute();
        $id_pedido = $con->insert_id;
        $con->close();
        return $id_pedido;
    }

    public static function actualizarEstado(){
        $con = Database::connect();
        $stmt = $con->prepare("UPDATE `pedido` SET estado = ? WHERE id_pedido = ?");
        $stmt->bind_param('si', $estado, $id_pedido);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }

    public static function actualizarEstadoPedido($id_pedido, $estado) {
        $con = Database::connect();
        $stmt = $con->prepare("UPDATE `pedido` SET estado = ? WHERE id_pedido = ?");
        $stmt->bind_param('si', $estado, $id_pedido);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }

    public static function eliminarPedido($id_pedido) {
        $con = Database::connect();
        $stmt = $con->prepare("DELETE FROM `pedido` WHERE id_pedido = ?");
        $stmt->bind_param('i', $id_pedido);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }

}
