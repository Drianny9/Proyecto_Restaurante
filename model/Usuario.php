<?php

class Usuario{
    //Atributos de la clase
    private $id_usuario;
    private $nombre;
    private $email;
    private $contraseña;
    private $direccion;
    private $telefono;
    private $rol;

    public function __construct(){
        
    }

    //GETTERS
    public function getId_usuario(){
        return $this->id_usuario;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getContraseña(){
        return $this->contraseña;
    }

    public function getDireccion(){
        return $this->direccion;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function getRol(){
        return $this->rol;
    }

    //SETTERS
    public function setId_usuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setContraseña($contraseña){
        $this->contraseña = $contraseña;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function setRol($rol){
        $this->rol = $rol;
    }
}