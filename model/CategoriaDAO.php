<?php
include_once 'model/Categoria.php';
include_once 'database/database.php';


class CategoriaDAO{

    public static function getCategoriaById($idCategoria){
        $con = Database::connect();
        //Preparamos consulta para evitar inyecciones SQL
        $stmt = $con->prepare("SELECT * FROM `categoria` WHERE id_categoria = ?");
        $stmt->bind_param('i', $idCategoria); // La 'i' indica el tipo de dato (integer)
        $stmt->execute();
        $results = $stmt->get_result();

        $categoria = $results->fetch_object('Categoria'); //Convertimos el resultado a un objeto Categoria
        $con->close();

        return $categoria;
    }

    public static function getCategorias(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `categoria`");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaCategorias = [];
        while ($categoria = $results->fetch_object('Categoria')) {
            $listaCategorias[] = $categoria;
        }

        $con->close();
        return $listaCategorias;
    }

}