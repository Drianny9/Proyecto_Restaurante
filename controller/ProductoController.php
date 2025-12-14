<?php
include_once 'model/ProductoDAO.php';
include_once 'model/CategoriaDAO.php';

class ProductoController{

    // Funcion para ver la carta de productos con categorias para filtrar
    public function verCarta(){
        $productos = ProductoDAO::getProductos();
        $categorias = CategoriaDAO::getCategorias();
        $view = 'view/producto/carta.php';
        include_once 'view/main.php';
    }
}

