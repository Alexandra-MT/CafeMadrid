<?php

namespace Controllers;

use Model\Blog;
use Model\Menu;
use MVC\Router;
use Model\Galeria;
use Model\Reserva;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{
    //INDEX
    public static function index(Router $router){
        //Galeria
        $galeria = Galeria::all();
        $menuCafe = Menu::get(7);
        $menuPostre = Menu::getFrom(7, 7);
        //Vista
        $router->render('paginas/home/index',[
            'titulo' => 'Inicio',
            'textoHeader' => 'El café es un idioma en sí mismo',
            'galeria' => $galeria,
            'menuCafe' => $menuCafe,
            'menuPostre' => $menuPostre
        ]);  
    }

    //NOSOTROS
    public static function nosotros(Router $router){
        //Vista
        $router->render('paginas/nosotros',[
            'titulo' => 'Nosotros',
            'textoHeader' => '¿Cuántas historias Empiezan con un café?',
        ]);  
    }

    //PROCESO
    public static function proceso(Router $router){
        //Vista
        $router->render('paginas/proceso',[
            'titulo' => 'Proceso',
            'textoHeader' => '¿Cómo hacemos nuestro café?',
        ]);  
    }

    //MENU
    public static function menu(Router $router){
        $menuCafe = Menu::get(7);
        $menuPostre = Menu::getFrom(7,7);
        $menuPrimerosMeses = Menu::getFrom(7,14);
        $menuUltimosMeses = Menu::getFrom(7,21);
        //Vista
        $router->render('paginas/menu/menu',[
            'titulo' => 'Menú',
            'textoHeader' => 'Disfruta nuestro delicioso menú',
            'menuCafe' => $menuCafe,
            'menuPostre' => $menuPostre,
            'menuPrimerosMeses' => $menuPrimerosMeses,
            'menuUltimosMeses' => $menuUltimosMeses
        ]);  
    }

    //BLOG
    public static function blog(Router $router){
        //Vista
        $router->render('paginas/blog/blogjs',[
            'titulo' => 'Blog',
            'textoHeader' => 'Un café para leer',
        ]);  
    }
    
    //ENTRADA
    public static function entrada(Router $router){
        //Obtener el $id mediante $_GET
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        //Redireccionar si no existe el id
        if(!$id){
            header('Location: /blog');
        }
        //Obtener entrada
        $entrada = Blog::find($id);
        $tituloEntrada = $entrada->titulo;
        $headerClass = 'header-blog';
        //Vista
        $router->render('paginas/blog/entrada',[
            'titulo' => 'Blog',
            'textoHeader' => $tituloEntrada,
            'entrada' => $entrada,
            'headerClass' => $headerClass,
        ]);
    }

    //RESERVA
    public static function reserva(Router $router){
        //Instancia Reserva
        $reserva = new Reserva;
        //Alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Instancia Reserva con datos POST
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
                            $alertas = Reserva::setAlerta('exito', 'Reserva confirmada');

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
        $router->render('paginas/reserva',[
            'titulo' => 'Reserva',
            'textoHeader' => 'Te esperamos',
            'reserva' => $reserva,
            'alertas' => $alertas
        ]);  
    }
}