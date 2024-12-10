<?php

namespace Model;

class Blog extends ActiveRecord{
    protected static $db;
    protected static $tabla = 'blog';
    protected static $columnasDB = ['id', 'titulo', 'imagen', 'fecha', 'autor', 'introduccion', 'contenido'];

    public $id;
    public $titulo;
    public $imagen;
    public $fecha;
    public $autor;
    public $introduccion;
    public $contenido;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->fecha = date('Y/m/d'); //fecha actual
        $this->autor = $args['autor'] ?? '';
        $this->introduccion = $args['introduccion'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
    }

    public function validarBlog(){
        if(!$this->titulo || strlen($this->titulo) > 60){
            self::setAlerta('error', 'El titulo es obligatorio y no puede contener más de 60 caracteres');
        }
        if(!$this->imagen){
            self::setAlerta('error', 'La imagen es obligatoria');
        }
        if(!$this->autor){
            self::setAlerta('error', 'Selecciona el autor');
            }
        if(!$this->introduccion){
            self::setAlerta('error', 'La introducción es obligatoria');
        }
        if(!$this->contenido){
            self::setAlerta('error', 'El contenido es obligatoria');
        }

        return self::getAlertas();
    }
}