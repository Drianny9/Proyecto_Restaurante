<?php
include_once 'model/ProductoDAO.php';
include_once 'model/PedidoDAO.php';
include_once 'model/LineaPedidoDAO.php';

class CarritoController{
     
    //Mostrar carrito
    public function verCarrito(){
        $view = 'view/carrito/ver.php';
        include_once 'view/main.php';
    }
}
