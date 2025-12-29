<?php

class Pedido{
    //Atributos de la clase
    private $id_pedido;
    private $fecha;
    private $estado;
    private $importe_total;
    private $id_usuario;

    //GETTERS
    public function getId_pedido(){
        return $this->id_pedido;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getImporte_total(){
        return $this->importe_total;
    }

    public function getId_usuario(){
        return $this->id_usuario;
    }

    //SETTERS
    public function setId_pedido($id_pedido){
        $this->id_pedido = $id_pedido;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function setImporte_total($importe_total){
        $this->importe_total = $importe_total;
    }

     public function setId_usuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }
}