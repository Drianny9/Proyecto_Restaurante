<?php
include_once 'model/Equipo.php';
include_once 'database/database.php';


class Usuario{

    public static function getUsuarioById($id_usuario){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param('i', $id_usuario); //La 'i' indica el tipo de dato (integer)
        $stmt->execute();
        $results = $stmt->get_result();

        $equipo = $results->fetch_object('Usuario');
        $con->close();

        return $equipo;
    }

    public static function getUsuarios(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaUsuarios = [];
        while ($usuario = $results->fetch_object('Usuario')) {
            $listaUsuarios[] = $usuario;
        }

        $con->close();
        return $listaUsuarios;
    }

}