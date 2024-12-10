<?php

namespace Model;

class Galeria extends ActiveRecord{
    protected static $db;
    protected static $tabla = 'galeria';
    protected static $columnasDB = ['id','titulo','imagen'];

    public $id;
    public $titulo;
    public $imagen;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validarGaleria(){
        if(!$this->titulo){
            self::setAlerta('error', 'El titulo es obligatorio');
        }
        if(!$this->imagen){
            self::setAlerta('error', 'La imagen es obligatoria');
        }
        return self::getAlertas();
    }
}