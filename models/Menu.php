<?php

namespace Model;

class Menu extends ActiveRecord{
    protected static $db;
    protected static $tabla = 'menu';
    protected static $columnasDB = ['id', 'nombre', 'precio', 'descripcion'];

    public $id;
    public $nombre;
    public $precio;
    public $descripcion;

    public function __construct( $args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
    }
    
    public function validarMenu(){
        if(!$this->nombre){
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if(!$this->precio){
            self::setAlerta('error', 'El precio es obligatorio');
        }
        if(strlen($this->descripcion) < 5){
            self::setAlerta('error', 'La descripción es obligatoria y debe tener al menos 10 caracteres');
        }
        return self::getAlertas();
    }
        
    
}