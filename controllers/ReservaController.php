<?php

namespace Controllers;

use MVC\Router;
use Model\Reserva;

class ReservaController{
    public static function index(Router $router){
        //Proteger ruta
        isAuth();
        //Mostrar Reservas
        $reservas = Reserva::all();
        //Fecha hoy
        $fecha = date('Y-m-d');
        //Alertas
        $alertas = [];
        //Eliminar fechas anteriores al acceder a Reserva
        foreach($reservas as $reserva){
            if($reserva->fecha < $fecha){
                $reserva->eliminar();
            }     
        }
         //POST 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Nueva fecha buscador
            $nuevaFecha = $_POST['fecha'];
            //Filtrar ascendente por Hora
            $reservas = Reserva::filterAsc('fecha', $nuevaFecha, 'hora');
            //Mostrar en el buscador la fecha seleccionada
            $fecha = $nuevaFecha;
            //Alerta si no hay reservas
            if(!$reservas){
                $alertas = Reserva::setAlerta('error', 'No existen reservas para este día');
            }
        }
        //Mostrar Reservas
        $alertas = Reserva::getAlertas();
        //Alerta exito
        $resultado = $_GET['exito'] ?? null;
        //Vista
        $router->render('reserva/index',[
            'titulo' => 'Reservas',
            'reservas' => $reservas,
            'fecha' => $fecha,
            'alertas'=> $alertas,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router){
        //Proteger ruta
        isAuth();
        //Instancia Reserva
        $reserva = new Reserva;
        //Alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            ////Instancia Reserva con datos POST
            $reserva = new Reserva($_POST);
            //Validar Reserva
            $alertas = $reserva->validarReserva();
            //Si no hay alertas
            if(empty($alertas)){
                //Guardar BBDD
                $resultado = $reserva->guardar();
                //Redireccionar exito
                if($resultado){
                    header('Location: /reserva-mostrar?exito=1');
                }
            }
        }
        //Vista
        $router->render('reserva/crear',[
            'titulo' => 'Crear Reserva',
            'alertas' => $alertas,
            'reserva' => $reserva
        ]);
    }

    public static function actualizar(Router $router){
        //Proteger ruta
        isAuth();
        //Recibir $id mediante GET
        $id = $_GET['id'];
        //Validar $id 
        $id = filter_var($id, FILTER_VALIDATE_INT);
        //Redireccionar si el $id no existe
        if(!$id){
            header('Location: /reserva-mostrar');
        }
        //Buscar Reserva por $id en la BBDD
        $reserva = Reserva::find($id);
        //Alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Sincronizar los datos que recibimos del POST
            $reserva->sincronizar($_POST);
            //Validar Reserva
            $alertas = $reserva->validarReserva();
            //Si no hay alertas
            if(empty($alertas)){
                //Guardar BBDD
                $resultado = $reserva->guardar();
                //Redireccionar exito
                if($resultado){
                    header('Location: /reserva-mostrar?exito=2');
                }
            }
        }
        //Vista
        $router->render('reserva/actualizar', [
            'titulo' => 'Actualizar Reserva',
            'alertas' => $alertas,
            'reserva' => $reserva
        ]);

    }

    public static function eliminar(Router $router){
        //Proteger ruta
        isAuth();
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
             //Recibir el $id mediante POST
            $id = $_POST['id'];
            //Convertir valor $id a integer
            $id = intval($id); //numero
            //$id = filter_var($id,FILTER_VALIDATE_INT);
            //Redireccionar si no hay $id
            if(!$id){
                header('Location: /reserva-mostrar');
            }
            //Buscar $id en la BBDD
            $reserva = Reserva::find($id);
            //Eliminar
            $resultado = $reserva->eliminar();
            //Redireccionar exito
            if($resultado){
                header('Location: /reserva-mostrar?exito=3');
            }
        } 
    }
}