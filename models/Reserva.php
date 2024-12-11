<?php

namespace Model;

class Reserva extends ActiveRecord{
    //Conexión a la BBDD
    protected static $db;
    //Tabla
    protected static $tabla = 'reserva';
    //Columnas BBDD
    protected static $columnasDB = ['id', 'nombre', 'email', 'personas', 'hora', 'fecha'];

    //Atributos
    public $id;
    public $nombre;
    public $email;
    public $personas;
    public $hora;
    public $fecha;

    //Constructor
    public function __construct( $args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->personas = $args['personas'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
    }

    //Validar campos formulario
    public function validarReserva(){
        if(!$this->nombre){
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if(!$this->email){
            self::setAlerta('error', 'El email es obligatorio');
        }

        if(!$this->personas){
            self::setAlerta('error', 'Por favor, seleccione el número de personas');
        }
        if(!$this->fecha){
            self::setAlerta('error', 'La fecha es obligatoria');
        }
        if(!$this->hora){
            self::setAlerta('error', 'La hora es obligatoria');
        }
        return self::getAlertas();
    }
}