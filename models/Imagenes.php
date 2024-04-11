<?php

namespace Model;

class Imagenes extends Activerecord{
    protected static $tabla = 'imagenes';
    protected static $columnasDB = ['id', 'productoId', 'imagen'];

    public $id;
    public $productoId;
    public $imagen;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->productoId = $args['productoId'] ?? '';
        $this->imagen = $args['imagen'] ?? '';

    }

    
}