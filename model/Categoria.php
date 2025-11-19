<?php

class Categoria{
    //Atributos de la clase
    private $idCategoria;
    private $nombre;

    //GETTERS
    public function getIdCategoria(){
        return $this->idCategoria;
    }

    public function getNombre(){
        return $this->nombre;
    }

    //SETTERS
    public function setIdCategoria($idCategoria){
        $this->idCategoria = $idCategoria;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
}