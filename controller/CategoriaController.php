<?php
include_once 'model/CategoriaDAO.php';

class CategoriaController {
    public function show(){
        $view = 'view/categoria/show.php';
        $idCategoria = $_GET['id'];
        $categoria = CategoriaDAO::getCategoriaById($idCategoria);
        
    }

    public function index(){
        $view = 'view/categoria/index.php'; // LLamamos a la vista
        $listaCategorias = CategoriaDAO::getCategorias(); //llamamos al DAO
        include_once 'view/main/main.php'; //Conectamos con el main
    }
}