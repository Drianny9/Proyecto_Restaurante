<?php
include_once 'model/Oferta.php';
include_once 'database/database.php';


class OfertaDAO{

    public static function getOfertaById($id_oferta){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `oferta` WHERE id_oferta = ?");
        $stmt->bind_param('i', $id_oferta); // La 'i' indica el tipo de dato (integer)
        $stmt->execute();
        $results = $stmt->get_result();

        $oferta = $results->fetch_object('Oferta');
        $con->close();

        return $oferta;
    }

    public static function getOfertas(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `oferta`");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaOfertas = [];
        while ($oferta = $results->fetch_object('Oferta')) {
            $listaOfertas[] = $oferta;
        }

        $con->close();
        return $listaOfertas;
    }

}