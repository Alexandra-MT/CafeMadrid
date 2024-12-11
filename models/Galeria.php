<?php

namespace Model;

class Galeria extends ActiveRecord{
    //Conexión a la BBDD
    protected static $db;
    //Tabla
    protected static $tabla = 'galeria';
    //Columnas BBDD
    protected static $columnasDB = ['id','titulo','imagen'];

    //Atributos
    public $id;
    public $titulo;
    public $imagen;

    //Constructor
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    //Validar campos formulario
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