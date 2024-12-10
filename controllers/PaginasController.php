<?php

namespace Controllers;

use Model\Blog;
use Model\Menu;
use MVC\Router;
use Model\Galeria;
use Model\Reserva;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{

    public static function index(Router $router){
        $galeria = Galeria::all();
        $menuCafe = Menu::get(7);
        $menuPostre = Menu::getFrom(7, 7);
        $router->render('paginas/home/index',[
            'titulo' => 'Inicio',
            'textoHeader' => 'El café es un idioma en sí mismo',
            'galeria' => $galeria,
            'menuCafe' => $menuCafe,
            'menuPostre' => $menuPostre
        ]);  
    }

    public static function nosotros(Router $router){

        $router->render('paginas/nosotros',[
            'titulo' => 'Nosotros',
            'textoHeader' => '¿Cuántas historias Empiezan con un café?',
        ]);  
    }

    public static function proceso(Router $router){

        $router->render('paginas/proceso',[
            'titulo' => 'Proceso',
            'textoHeader' => '¿Cómo hacemos nuestro café?',
        ]);  
    }

    public static function menu(Router $router){
        $menuCafe = Menu::get(7);
        $menuPostre = Menu::getFrom(7,7);
        $menuPrimerosMeses = Menu::getFrom(7,14);
        $menuUltimosMeses = Menu::getFrom(7,21);
        $router->render('paginas/menu/menu',[
            'titulo' => 'Menú',
            'textoHeader' => 'Disfruta nuestro delicioso menú',
            'menuCafe' => $menuCafe,
            'menuPostre' => $menuPostre,
            'menuPrimerosMeses' => $menuPrimerosMeses,
            'menuUltimosMeses' => $menuUltimosMeses
        ]);  
    }

    public static function blog(Router $router){
        /*$pagina = 1;
        if (isset($_GET["pagina"])) {
            $pagina = $_GET["pagina"];
        }
        $blogTotal = Blog::all();
        //mostrar entradas por página
        $total = count($blogTotal);
        $productosPorPagina = 9;
        $paginas = ceil($total / $productosPorPagina);
        $offset = ($pagina-1) * $productosPorPagina;
        $blog = Blog::getFrom($productosPorPagina,$offset);*/
        $router->render('paginas/blog/blogjs',[
            'titulo' => 'Blog',
            'textoHeader' => 'Un café para leer',
            //'blog' => $blog,
            //'paginas' => $paginas,
            //'pagina' => $pagina,
        ]);  
    }
    
    public static function entrada(Router $router){
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /blog');
        }
        $entrada = Blog::find($id);
        $tituloEntrada = $entrada->titulo;
        $headerClass = 'header-blog';
        $router->render('paginas/blog/entrada',[
            'titulo' => 'Blog',
            'textoHeader' => $tituloEntrada,
            'entrada' => $entrada,
            'headerClass' => $headerClass,
        ]);
    }

    public static function reserva(Router $router){
        $reserva = new Reserva;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $reserva = new Reserva($_POST);
            $alertas = $reserva->validarReserva();
            if(empty($alertas)){
                $existeFecha = Reserva::belongsTo('fecha', $reserva->fecha);
                $existeHora = Reserva::belongsTo('hora', $reserva->hora);
                if(!((count($existeFecha) > 2) && (count($existeHora) > 2))){ // el array $reserva empieza en la posicion 0
                        $resultado = $reserva->guardar();
                        if($resultado){
                            $alertas = Reserva::setAlerta('exito', 'Reserva confirmada');

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

        $router->render('paginas/reserva',[
            'titulo' => 'Reserva',
            'textoHeader' => 'Te esperamos',
            'reserva' => $reserva,
            'alertas' => $alertas
        ]);  
    }
}