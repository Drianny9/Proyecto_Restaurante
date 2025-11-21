<?php
include_once 'model/Pedido.php';
include_once 'database/database.php';


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
        $stmt = $con->prepare("SELECT * FROM `pedido`");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaPedidos = [];
        while ($pedido = $results->fetch_object('Pedido')) {
            $listaPedidos[] = $pedido;
        }

        $con->close();
        return $listaPedidos;
    }

}
