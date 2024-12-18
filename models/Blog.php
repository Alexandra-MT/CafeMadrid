<?php

namespace Model;

class Blog extends ActiveRecord{
    //Conexión a la BBDD
    protected static $db;
    //Tabla
    protected static $tabla = 'blog';
    //Columnas BBDD
    protected static $columnasDB = ['id', 'titulo', 'imagen', 'fecha', 'autor', 'introduccion', 'contenido'];

     //Atributos
    public $id;
    public $titulo;
    public $imagen;
    public $fecha;
    public $autor;
    public $introduccion;
    public $contenido;

    //Constructor
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->fecha = date('Y/m/d'); //fecha actual
        $this->autor = $args['autor'] ?? '';
        $this->introduccion = $args['introduccion'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
    }

    //Validar campos formulario
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