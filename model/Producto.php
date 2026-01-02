<?php

class Producto implements JsonSerializable {

    //Atributos de la clase
    private $id_producto;
    private $nombre;
    private $descripcion;
    private $id_categoria;
    private $precio_base;
    private $imagen;

    public function __construct() {}

    //Metodo para serializar a JSON
    public function jsonSerialize(): mixed {
        return [
            'id_producto' => $this->id_producto,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'id_categoria' => $this->id_categoria,
            'precio_base' => $this->precio_base,
            'imagen' => $this->imagen
        ];
    }

    //GETTERS
    public function getId_producto(){
        return $this->id_producto;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getId_categoria(){
        return $this->id_categoria;
    }

    public function getPrecio_base(){
        return $this->precio_base;
    }

    public function getImagen(){
        return $this->imagen;
    }

    //SETTERS
    public function setId_producto($id_producto){
        $this->id_producto = $id_producto;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function setId_categoria($id_categoria){
        $this->id_categoria = $id_categoria;
    }

    public function setPrecio_base($precio_base){
        $this->precio_base = $precio_base;
    }

    public function setImagen($imagen){
        $this->imagen = $imagen;
    }
}