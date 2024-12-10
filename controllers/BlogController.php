<?php

namespace Controllers;

use Model\Blog;
use MVC\Router;

class BlogController{
    public static function index(Router $router){
        //Proteger ruta
        isAuth();
        //Mostrar todas las entradas de blog
        $blog = Blog::all();
        //Mostrar alertas
        $resultado = $_GET['exito'] ?? null;
        //Vista
        $router->render('blog/index',[
            'titulo' => 'Blog',
            'blog' => $blog,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router){
        //Proteger ruta
        isAuth();
        //Nueva instancia Blog
        $blog = new Blog();
        //Alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Nueva instancia con los datos del POST
            $blog = new Blog($_POST);
            //Imagen
            $imagen = $_FILES['imagen'];
            //Asociar nombre imagen
            $blog->imagen = $imagen['name']; //array
            //Validar Blog
            $alertas = $blog->validarBlog();
            //Si no hay alertas
            if(empty($alertas)){
                //Subida de archivos
                //Crear la carpeta que contiene las fotos
                $carpetaImagenes = $_SERVER['DOCUMENT_ROOT'].'/build/img/blog/';
                //Verificamos si existe la carpeta, evitamos duplicados
                if(!is_dir($carpetaImagenes)){
                    mkdir($carpetaImagenes);
                }
                //Asignar un nombre de imagen aleatorio
                $nombreImagen = md5(uniqid(rand(), true)).".jpg";
                //Subir la imagen a la carpeta creada
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);
                $blog->imagen = $nombreImagen;
                //Guardar en la BBDD
                $resultado = $blog->guardar();
                //Redireccionar alerta
                if($resultado){
                    //Galeria::setAlerta('exito', 'Imagen subida correctamente');
                    
                    //header("refresh: 5; /admin");

                    header('Location:/blog-mostrar?exito=1');
                }
            }
        }
        //Vista
        $router->render('blog/crear',[
            'titulo' => 'Añadir entrada de blog',
            'blog' => $blog,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        //Proteger ruta
        isAuth();
        //Recibir el id mediante $_GET
        $id = $_GET['id'];
        //Validar $id
        $id = filter_var($id, FILTER_VALIDATE_INT);
        //Redireccionar si el $id no existe
        if(!$id){
            header('Location: /blog-mostrar');
        }
        //Buscar Blog por $id en la BBDD
        $blog = Blog::find($id);
        //Mostrar alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Sincronizar los datos que recibimos del POST
            $blog->sincronizar($_POST);
            //Validar Blog
            $alertas = $blog->validarBlog();
            //Si no hay alertas
            if(empty($alertas)){
                //Subida de archivos
                $carpetaImagenes = $_SERVER['DOCUMENT_ROOT'].'/build/img/blog/';
                //Crear carpeta
                if(!is_dir($carpetaImagenes)){
                    mkdir($carpetaImagenes);
                }
                //Comprobar si el usuario subio otra imagen
                $imagen = $_FILES['imagen'];
                $nombreImagen = $blog->imagen; // para que no borre la anterior si no subimos otra imagen
                
                if($imagen['name']){
                    //Eliminar imagen previa
                    unlink($carpetaImagenes.$nombreImagen);

                    //Nombre imagen
                    $nombreNuevaImagen = md5(uniqid(rand(), true)).".jpg";
                    //Subir la imagen
                    move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreNuevaImagen); 
                    $blog->imagen = $nombreNuevaImagen; 
                }
                //Guardar en la BBDD
                $resultado = $blog->guardar();
                //Redireccionar, alerta
                if($resultado){
                    //Galeria::setAlerta('exito', 'Imagen subida correctamente');
                    
                    //header("refresh: 5; /admin");

                    header('Location:/blog-mostrar?exito=2');
                }
            }
        }
        //Vista
        $router->render('blog/actualizar',[
            'titulo' => 'Actualizar Entrada Blog',
            'blog' => $blog,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        //Protegemos ruta
        isAuth();
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Recibir el $id mediante POST
            $id = $_POST['id']; //viene como string
            //Convertir valor $id a integer
            $id = intval($id); //numero
            //$id = filter_var($id,FILTER_VALIDATE_INT);
            //Redireccionar si no hay $id
            if(!$id){
                header('Location: /blog-mostrar');
            }
            //Buscar $id en la BBDD
            $blog = Blog::find($id);
            //Eliminar imagen
            $carpetaImagenes = $_SERVER['DOCUMENT_ROOT'].'/build/img/blog/';
            $nombreImagen = $blog->imagen;
            unlink($carpetaImagenes.$nombreImagen);
            //Eliminar entrada
            $resultado = $blog->eliminar();
            //Redireccionar, alerta exito
            if($resultado){
                header('Location:/blog-mostrar?exito=3');
            }
        }    
    }
}