<?php

class LineaPedido{
    //Atributos de la clase
    private $id_linea;
    private $precio_unidad;
    private $cantidad;

    //GETTERS
    public function getId_linea(){
        return $this->id_linea;
    }

    public function getPrecio_unidad(){
        return $this->precio_unidad;
    }

    public function getCantidad(){
        return $this->cantidad;
    }

    //SETTERS
    public function setId_linea($id_linea){
        $this->id_linea = $id_linea;
    }

    public function setPrecio_unidad($precio_unidad){
        $this->precio_unidad = $precio_unidad;
    }

    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
}