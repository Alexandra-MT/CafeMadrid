<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class AdminController{
    public static function crear(Router $router){
        //Crear usuario unico
        //Instancia admin
        $admin = new Admin();
        //Alertas
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Sincronizar los datos que recibimos por POST
            $admin->sincronizar($_POST);// $key=$value;
            //Validar datos
            $alertas = $admin->validarAdmin();
            //Si no hay alertas
            if(empty($alertas)){
                //Hashear Password
                $admin->hashPassword();
                
                //Guardar en la DDBB
                $resultado = $admin->guardar();
                if($resultado){
                    //Alerta exito
                    $alertas = Admin::setAlerta('exito','Usuario creado correctamente');
                    //Redireccionar Login
                    header("refresh: 5; /login");
                }
            }
            $alertas = Admin::getAlertas();                
        }
        //Vista
        $router->render('/auth/crear',[
            'titulo' => 'Crear usuario',
            'alertas' => $alertas
        ]);
    }
    public static function login(Router $router){
        //Crear instancia
        $auth = new Admin();
        //Alertas 
        $alertas = [];
        //POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Nueva instancia Admin con los datos recibidos por POST
            $auth = new Admin($_POST);
            //Validar campos formulario login
            $alertas = $auth->validarAdmin();
            //Si no existen alertas
            if(empty($alertas)){
                //Verificar si el usuario existe
                $resultado = Admin::where('email', $auth->email);
                //Usuario no existe, $resultado devuelve null
                if(!$resultado){
                    //Alerta error
                    $alertas = Admin::setAlerta('error', 'El usuario no existe');
                }else{
                //Usuario existe, $resultado devuelve el objeto
                    //Verificar el password
                    $autenticado = $auth->verificarPassword($resultado);
                    //Password incorrecto
                    if(!$autenticado){
                        $alertas = Admin::setAlerta('error', 'El Password es incorrecto');
                    }else{
                        //Password correcto
                        //Autenticar al usuario
                           $auth->autenticar();
                    }   
                }   
            }
        $alertas = Admin::getAlertas();
        }
        //Vista
        $router->render('auth/login',[
        'titulo' => 'Iniciar Sesión',
        'alertas' => $alertas,
        ]);
    }
    public static function logout(Router $router){
         session_start();
         $_SESSION = [];  
         header('Location: /');
    }
    public static function index(Router $router){
        //Verificamos si hay sesión y si el valor de login es true
        isAuth();
        //Crear una variable para mostrar el boton de cerrar sesión
        $auth = $_SESSION['login'];
        //Vista
        $router->render('admin/admin',[
            'titulo' => 'CaféMadrid',
            'auth' => $auth
        ]);
    }

    
}