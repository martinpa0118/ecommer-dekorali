<?php

namespace Model;

class Categorias extends Activerecord{
    protected static $tabla = 'categorias';
    protected static $columnasDB = ['id', 'prefijo', 'nombre'];

    public $id;
    public $prefijo;
    public $nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->prefijo = $args['prefijo'] ?? '';
        $this->nombre = $args['nombre'] ?? '';

    }
    public function validar()
    {
        if (!$this->prefijo) {
            self::$errores[] = "Debes añadir un prefijo a la categoria";
        }
        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un nombre a la categoria";
        }
        // if (!$preg_match('/[0-9]{10}/',$this->telefono)) {
        //     self::$errores[] = "Formato no valido";
        // }
        return self::$errores;
    }
}