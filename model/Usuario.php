<?php

class Usuario{
    //Atributos de la clase
    private $id_usuario;
    private $nombre;
    private $email;
    private $password;
    private $direccion;
    private $telefono;
    private $rol;

    public function __construct() {}

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

    public function getPassword(){
        return $this->password;
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

    public function setPassword($password){
        $this->password = $password;
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