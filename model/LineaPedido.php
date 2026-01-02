<?php

class LineaPedido{
    //Atributos de la clase
    private $id_linea;
    private $precio_unidad;
    private $cantidad;
    private $id_producto;
    private $id_pedido;
    private $id_oferta;

    public function __construct() {}

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

    public function getId_producto(){
        return $this->id_producto;
    }
    public function getId_pedido(){
        return $this->id_pedido;
    }

    public function getId_oferta() {
        return $this->id_oferta;
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
    public function setId_producto($id_producto){
        $this->id_producto = $id_producto;
    }
    public function setId_pedido($id_pedido){
        $this->id_pedido = $id_pedido;
    }

     public function setId_oferta($id_oferta) {
        $this->id_oferta = $id_oferta;
    }
}