<?php

class Oferta{

    //Atributos de la clase
    private $id_oferta;
    private $nombre;
    private $descripcion;
    private $descuento_porcentaje;
    private $fecha_inicio;
    private $fecha_fin;
    private $activa;

    public function __construct() {}

    //GETTERS
    public function getId_oferta(){
        return $this->id_oferta;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getDescuento_porcentaje(){
        return $this->descuento_porcentaje;
    }

    public function getFecha_inicio(){
        return $this->fecha_inicio;
    }

    public function getFecha_fin(){
        return $this->fecha_fin;
    }

    public function getActiva(){
        return $this->activa;
    }

    //SETTERS
    public function setId_oferta($id_oferta){
        $this->id_oferta = $id_oferta;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function setDescuento_porcentaje($descuento_porcentaje){
        $this->descuento_porcentaje = $descuento_porcentaje;
    }

    public function setFecha_inicio($fecha_inicio){
        $this->fecha_inicio = $fecha_inicio;
    }

    public function setFecha_fin($fecha_fin){
        $this->fecha_fin = $fecha_fin;
    }

    public function setActiva($activa){
        $this->activa = $activa;
    }
}
