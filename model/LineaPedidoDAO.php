<?php
include_once 'model/LineaPedido.php';
include_once 'database/database.php';


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

}