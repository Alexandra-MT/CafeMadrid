<?php

namespace Controllers;

use MVC\Router;
use Model\Galeria;

class GaleriaController{
    //Galeria
    public static function index(Router $router){
        //Proteger ruta
        isAuth();
        //Mostrar galeria
        $galeria = Galeria::all();
        //Alerta exito
        $resultado = $_GET['exito'] ?? null;
        //Vista
        $router->render('galeria/index',[
            'titulo' => 'Galería',
            'galeria' => $galeria,
            'resultado' => $resultado
        ]);
    }

    //Crear galeria
    public static function crear(Router $router){
        //Proteger ruta
        isAuth();
        //Instancia Galeria
        $galeria = new Galeria;
        //Alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            //Instancia Galeria con datos POST
            $galeria = new Galeria($_POST);
            //Imagen
            $imagen = $_FILES['imagen'];
            $galeria->imagen = $imagen['name'];
            //Validar Galeria
            $alertas = $galeria->validarGaleria();
            //Si no hay alertas
            if(empty($alertas)){
                //Subida de archivos
                //Crear la carpeta que contiene las fotos
                $carpetaImagenes = $_SERVER['DOCUMENT_ROOT'].'/build/img/galeria/';
                //Verificamos si existe la carpeta, evitamos duplicados
                if(!is_dir($carpetaImagenes)){
                    mkdir($carpetaImagenes);
                }
                //Asignar un nombre de imagen aleatorio
                $nombreImagen = md5(uniqid(rand(), true)).".jpg";
                //Subir la imagen a la carpeta creada
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);
                $galeria->imagen = $nombreImagen;
                //Guardar BBDD
                $resultado = $galeria->guardar();
                //Redireccionar exito
                if($resultado){
                    header('Location:/galeria-mostrar?exito=1');
                }
            }
        }
        //Vista
        $router->render('galeria/crear',[
            'titulo' => 'Cambiar Imagen',
            'galeria' => $galeria,
            'alertas' => $alertas
        ]);
    }

    //Actualizar galeria
    public static function actualizar(Router $router){
        //Proteger ruta
        isAuth();
        //Recibir $id mediante GET
        $id = $_GET['id'];
        //Validar que el id sea un numero
        $id = filter_var($id, FILTER_VALIDATE_INT);
        //Redireccionar si el $id no existe
        if(!$id){
            header('Location: /galeria-mostrar');
        }
        //Buscar Galeria por $id en la BBDD
        $galeria = Galeria::find($id);
        //Alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Sincronizar los datos que recibimos del POST
            $galeria->sincronizar($_POST);
            //Validar Galeria
            $alertas = $galeria->validarGaleria();
            //Si no hay alertas
            if(empty($alertas)){
                //Subida de archivos
                $carpetaImagenes = $_SERVER['DOCUMENT_ROOT'].'/build/img/galeria/';
                //Crear carpeta
                if(!is_dir($carpetaImagenes)){
                    mkdir($carpetaImagenes);
                }
                //Comprobar si el usuario subio otra imagen
                $imagen = $_FILES['imagen'];
                debuguear($imagen);
                $nombreImagen = $galeria->imagen; // para que no borre la anterior si no subimos otra imagen

                if($imagen['name']){
                    //Eliminar imagen previa
                    unlink($carpetaImagenes.$nombreImagen);

                    //Nombre imagen
                    $nombreNuevaImagen = md5(uniqid(rand(), true)).".jpg";
                    //Subir la imagen
                    move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreNuevaImagen); 
                    $galeria->imagen = $nombreNuevaImagen; 
                }
                //Guardar en la BBDD
                $resultado = $galeria->guardar();
                //Redireccionar exito
                if($resultado){
                    header('Location:/galeria-mostrar?exito=2');
                }
            }
        }
        //Vista
        $router->render('galeria/actualizar',[
            'titulo' => 'Actualizar Galería',
            'galeria' => $galeria,
            'alertas' => $alertas
        ]);
    }

    //Eliminar galeria
    public static function eliminar(){
        //Proteger ruta
        isAuth();
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Recibir el $id mediante POST
            $id = $_POST['id']; //viene como string
            //Convertir valor $id a integer
            $id = intval($id); //numero
             //Redireccionar si no hay $id
            if(!$id){
                header('Location: /galeria-mostrar');
            }
            //Buscar $id en la BBDD
            $galeria = Galeria::find($id);
            //Eliminar la imagen
            $carpetaImagenes = $_SERVER['DOCUMENT_ROOT'].'/build/img/galeria/';
            $nombreImagen = $galeria->imagen;
            unlink($carpetaImagenes.$nombreImagen);
            //Eliminar Galeria
            $resultado = $galeria->eliminar();
            //Redireccionar exito
            if($resultado){
                header('Location:/galeria-mostrar?exito=3');
            }
        }    
    }
}