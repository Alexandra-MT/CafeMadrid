<?php

namespace Controllers;

use MVC\Router;
use Model\Reserva;
use PHPMailer\PHPMailer\PHPMailer;

class ReservaController{
    //Reservas
    public static function index(Router $router){
        //Proteger ruta
        isAuth();
        //Mostrar Reservas
        $reservas = Reserva::all();
        //Fecha hoy
        $fecha = date('Y-m-d');
        //Alertas
        $alertas = [];
        //Eliminar fechas anteriores al acceder a Reserva (opcional)
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

    //Crear reserva
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
                //Comprobar que no existan más de tres reservas para la misma hora y fecha
                $existeFecha = Reserva::belongsTo('fecha', $reserva->fecha);
                $existeHora = Reserva::belongsTo('hora', $reserva->hora);
                if(!((count($existeFecha) > 2) && (count($existeHora) > 2))){ // el array $reserva empieza en la posicion 0
                        //Guardar BBDD
                        $resultado = $reserva->guardar();
                        //Alerta exito
                        if($resultado){
                            header('Location: /reserva-mostrar?exito=1');

                            //Enviar email de confirmación reserva

                            //Crear instancia de PHPMailer
                            $mail = new PHPMailer();

                            //Configurar SMTP(Protocolo envio email)
                            $mail->isSMTP();
                            //Dominio
                            $mail->Host = $_ENV['EMAIL_HOST'];
                            //Autenticar
                            $mail->SMTPAuth = true;
                             //Puerto
                            $mail->Port = $_ENV['EMAIL_PORT'];
                            $mail->Username = $_ENV['EMAIL_USER'];
                            $mail->Password = $_ENV['EMAIL_PASS'];
                            //Protocolo de seguridad
                            $mail->SMTPSecure = "tls";
                           

                            //Configurar el contenido del email
                            //Quien envia el email
                            $mail->setFrom("alexandra11tutica@gmail.com", "CaféMadrid");
                            //Quien lo recibe
                            $mail->addAddress($reserva->email);
                            $mail->Subject = "Reserva confirmada";

                            //Habilitar HTML
                            $mail->isHTML(true);
                            $mail->CharSet = "UTF-8";

                            //Definir el contenido
                            $contenido = '<html>';
                            $contenido.= '<p>Hola '.$reserva->nombre.' !</p>';
                            $contenido.= '<p> Le confirmamos su reserva para el '.date("d/m/Y", strtotime($reserva->fecha)).' a las '.$reserva->hora.'h en nuestra
                            cafetería CaféMadrid.</p>';
                            $contenido.= '<p> Si no puede acudir o desea cambiar la reserva, por favor contacte con nosotros al numero de télefono: <a href="tel:+34948282828">948282828 </a>.</p>';
                            $contenido.= '<p> Le esperamos!';
                            $contenido.= '</html>';


                            $mail->Body = $contenido;
                            $mail->AltBody='Esto es texto alternativo sin HTML';
                            //Enviar el Email
                            $mail->send();
                        }
                }else{
                    $alertas = Reserva::setAlerta('error', 'Reserva no disponible, por favor seleccione otra fecha u hora');
                }
            }
        }
        $alertas = Reserva::getAlertas(); 
        //Vista
        $router->render('reserva/crear',[
            'titulo' => 'Crear Reserva',
            'alertas' => $alertas,
            'reserva' => $reserva
        ]);
    }

    //Actualizar reserva
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
                //Comprobar que no existan más de tres reservas para la misma hora y fecha
                $existeFecha = Reserva::belongsTo('fecha', $reserva->fecha);
                $existeHora = Reserva::belongsTo('hora', $reserva->hora);
                if(!((count($existeFecha) > 2) && (count($existeHora) > 2))){ // el array $reserva empieza en la posicion 0
                        //Guardar BBDD
                        $resultado = $reserva->guardar();
                        //Alerta exito
                        if($resultado){
                            header('Location: /reserva-mostrar?exito=2');

                            //Enviar email de confirmación reserva

                            //Crear instancia de PHPMailer
                            $mail = new PHPMailer();

                            //Configurar SMTP(Protocolo envio email)
                            $mail->isSMTP();
                            //Dominio
                            $mail->Host = $_ENV['EMAIL_HOST'];
                            //Autenticar
                            $mail->SMTPAuth = true;
                             //Puerto
                            $mail->Port = $_ENV['EMAIL_PORT'];
                            $mail->Username = $_ENV['EMAIL_USER'];
                            $mail->Password = $_ENV['EMAIL_PASS'];
                            //Protocolo de seguridad
                            $mail->SMTPSecure = "tls";
                           

                            //Configurar el contenido del email
                            //Quien envia el email
                            $mail->setFrom("alexandra11tutica@gmail.com", "CaféMadrid");
                            //Quien lo recibe
                            $mail->addAddress($reserva->email);
                            $mail->Subject = "Reserva confirmada";

                            //Habilitar HTML
                            $mail->isHTML(true);
                            $mail->CharSet = "UTF-8";

                            //Definir el contenido
                            $contenido = '<html>';
                            $contenido.= '<p>Hola '.$reserva->nombre.' !</p>';
                            $contenido.= '<p> Le confirmamos su reserva para el '.date("d/m/Y", strtotime($reserva->fecha)).' a las '.$reserva->hora.'h en nuestra
                            cafetería CaféMadrid.</p>';
                            $contenido.= '<p> Si no puede acudir o desea cambiar la reserva, por favor contacte con nosotros al numero de télefono: <a href="tel:+34948282828">948282828 </a>.</p>';
                            $contenido.= '<p> Le esperamos!';
                            $contenido.= '</html>';


                            $mail->Body = $contenido;
                            $mail->AltBody='Esto es texto alternativo sin HTML';
                            //Enviar el Email
                            $mail->send();
                        }
                }else{
                    $alertas = Reserva::setAlerta('error', 'Reserva no disponible, por favor seleccione otra fecha u hora');
                }
            }
        }
        $alertas = Reserva::getAlertas(); 
        //Vista
        $router->render('reserva/actualizar', [
            'titulo' => 'Actualizar Reserva',
            'alertas' => $alertas,
            'reserva' => $reserva
        ]);

    }

    //Eliminar reserva
    public static function eliminar(Router $router){
        //Proteger ruta
        isAuth();
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
             //Recibir el $id mediante POST
            $id = $_POST['id'];
            //Convertir valor $id a integer
            $id = intval($id); //numero
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