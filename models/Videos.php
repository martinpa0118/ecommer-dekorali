<?php 

namespace Model;

class Videos extends Activerecord{
    protected static $tabla = 'videos';
    protected static $columnasDB = ['id', 'productoId', 'video'];

    public $id;
    public $productoId;
    public $video;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->productoId = $args['productoId'] ?? '';
        $this->video = $args['video'] ?? '';

    }

}