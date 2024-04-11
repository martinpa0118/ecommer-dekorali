<?php

namespace Model;

class Producto extends Activerecord
{
    protected static $tabla = 'productos';
    protected static $columnasDB = ['id', 'titulo', 'imagen', 'categoriaId', 'codigo', 'descripcion', 'precio', 'creado'];
    // protected $imagenesAuxiliares = [];

    public $id;
    public $titulo;
    public $imagen;
    public $categoriaId;
    public $codigo;
    public $descripcion;
    public $precio;
    public $creado;
    public $imagenesAuxiliares;
    public $videos;



    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->imagenesAuxiliares = $args['imagenes'] ?? [];
        $this->videos = $args['videos'] ?? [];
        $this->categoriaId = $args['categoriaId'] ?? '';
        $this->codigo = $args['codigo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->creado = date('Y/m/d');
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un nombre al producto";
        }
        if (!$this->imagen) {
            self::$errores[] = "Debes añadir una imagen al producto";
        }
        if (!$this->imagenesAuxiliares) {
            self::$errores[] = "Debes añadir imagenes auxiliares al producto";
        }
        if (!$this->videos) {
             self::$errores[] = "Debes añadir videos del producto";
        }
        if (!$this->categoriaId) {
            self::$errores[] = "Debes añadir una categoria al producto";
        }
        if (!$this->codigo) {
            self::$errores[] = "Debes añadir un codigo al producto";
        }

        if (!$this->descripcion) {
            self::$errores[] = "Debes añadir una descripcion al producto";
        }
        if (!$this->precio) {
            self::$errores[] = "Debes añadir un precio al producto";
        }


        return self::$errores;
    }




}
