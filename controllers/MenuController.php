<?php

namespace Controllers;

use Model\Menu;
use MVC\Router;

class MenuController{
    //Menu
    public static function index(Router $router){
        //Proteger la ruta
        isAuth();
        //Mostrar Menu
        $menu = Menu::all();
        //Alerta exito
        $resultado = $_GET['exito'] ?? null;
        //Vista
        $router->render('menu/index',[
            'titulo' => 'Menú',
            'menu' => $menu,
            'resultado' => $resultado
        ]);
    }

    //Crear menu
    public static function crear(Router $router){
        //Proteger ruta
        isAuth();
        //Instancia Menu
        $menu = new Menu;
        //Alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Instancia Menu con datos POST
            $menu = new Menu($_POST);
            //Validar Menu
            $alertas = $menu->validarMenu();
            //Si no hay alertas
            if(empty($alertas)){
                //Guardar BBDD
                $resultado = $menu->guardar();
                //Redireccionar, exito
                if($resultado){
                    header('Location: /menu-mostrar?exito=1');
                }
            }
        }
        //Vista
        $router->render('menu/crear',[
            'titulo' => 'Crear Producto',
            'alertas' => $alertas,
            'menu' => $menu
        ]);
    }

    //Actualizar menu
    public static function actualizar(Router $router){
        //Proteger ruta
        isAuth();
        //Recibir $id mediante GET
        $id = $_GET['id'];
        //Validar $id 
        $id = filter_var($id, FILTER_VALIDATE_INT);
        //Redireccionar si el $id no existe
        if(!$id){
            header('Location: /menu-mostrar');
        }
        //Buscar Menu por $id en la BBDD
        $menu = Menu::find($id);
        //Mostrar alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Sincronizar los datos que recibimos del POST
            $menu->sincronizar($_POST);
            //Validar Menu
            $alertas = $menu->validarMenu();
            //Si no hay alertas
            if(empty($alertas)){
                //Guardar BBDD
                $resultado = $menu->guardar();
                //Redireccionar, alerta exito
                if($resultado){
                    header('Location: /menu-mostrar?exito=2');
                }
            }
        }
        //Vista
        $router->render('menu/actualizar', [
            'titulo' => 'Actualizar Producto',
            'alertas' => $alertas,
            'menu' => $menu
        ]);

    }

    //Eliminar menu
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
                header('Location: /menu-mostrar');
            }
            //Buscar $id en la BBDD
            $menu = Menu::find($id);
            //Eliminar
            $resultado = $menu->eliminar();
            //Redireccionar, alerta exito
            if($resultado){
                header('Location: /menu-mostrar?exito=3');
            }
        }
    }
}