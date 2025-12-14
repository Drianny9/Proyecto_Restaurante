<?php

class ProductoController{

    //Funcion para ver los productos
    public function verCarta(){
        $productos = ProductoDAO::getProductos();
        $view = 'view/producto/carta.php';
        include_once 'view/main.php';
    }
}

