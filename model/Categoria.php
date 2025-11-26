<?php

class Categoria{
    //Atributos de la clase
    private $id_categoria;
    private $nombre;

    //GETTERS
    public function getIdCategoria(){
        return $this->id_categoria;
    }

    public function getNombre(){
        return $this->nombre;
    }

    //SETTERS
    public function setIdCategoria($id_categoria){
        $this->id_categoria = $id_categoria;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
}