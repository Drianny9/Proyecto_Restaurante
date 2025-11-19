<?php

class Log{
    //Atributos
    private $id_log;
    private $accion;
    private $fecha_hora;


    public function __construct(){

    }

    //GETTERS
    public function getId_log(){
        return $this->id_log;
    }

    public function getAccion(){
        return $this->accion;
    }

    public function getFecha_hora(){
        return $this->fecha_hora;
    }

    //SETTERS
    public function setId_log($id_log){
        $this->id_log = $id_log;
    }

    public function setAccion($accion){
        $this->accion = $accion;
    }

    public function setFecha_hora($fecha_hora){
        $this->fecha_hora = $fecha_hora;
    }
}