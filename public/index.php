<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIController;
use Controllers\BlogController;
use Controllers\MenuController;
use Controllers\AdminController;
use Controllers\GaleriaController;
use Controllers\PaginasController;
use Controllers\ReservaController;

$router = new Router();


//CREAR USUARIO UNICO
$router->get('/crear', [AdminController::class,'crear']);
$router->post('/crear', [AdminController::class,'crear']);
//LOGIN, LOGOUT, 
$router->get('/login',[AdminController::class,'login']);
$router->post('/login',[AdminController::class,'login']);
$router->get('/logout',[AdminController::class,'logout']);

//PANEL DE ADMINISTRACIÓN
$router->get('/admin',[AdminController::class,'index']);

//MENU
$router->get('/menu-mostrar',[MenuController::class,'index']);
$router->get('/menu/crear',[MenuController::class,'crear']);
$router->post('/menu/crear',[MenuController::class,'crear']);
$router->get('/menu/actualizar',[MenuController::class,'actualizar']);
$router->post('/menu/actualizar',[MenuController::class,'actualizar']);
$router->post('/menu/eliminar',[MenuController::class,'eliminar']);

//GALERIA
$router->get('/galeria-mostrar',[GaleriaController::class,'index']);
$router->get('/galeria/crear',[GaleriaController::class,'crear']);
$router->post('/galeria/crear',[GaleriaController::class,'crear']);
$router->get('/galeria/actualizar',[GaleriaController::class,'actualizar']);
$router->post('/galeria/actualizar',[GaleriaController::class,'actualizar']);
$router->post('/galeria/eliminar',[GaleriaController::class,'eliminar']);

//BLOG
$router->get('/blog-mostrar',[BlogController::class,'index']);
$router->get('/blog/crear',[BlogController::class,'crear']);
$router->post('/blog/crear',[BlogController::class,'crear']);
$router->get('/blog/actualizar',[BlogController::class,'actualizar']);
$router->post('/blog/actualizar',[BlogController::class,'actualizar']);
$router->post('/blog/eliminar',[BlogController::class,'eliminar']);

//RESERVA
$router->get('/reserva-mostrar',[ReservaController::class,'index']);
$router->post('/reserva-mostrar',[ReservaController::class,'index']);
$router->get('/reserva/crear',[ReservaController::class,'crear']);
$router->post('/reserva/crear',[ReservaController::class,'crear']);
$router->get('/reserva/actualizar',[ReservaController::class,'actualizar']);
$router->post('/reserva/actualizar',[ReservaController::class,'actualizar']);
$router->post('/reserva/eliminar',[ReservaController::class,'eliminar']);

//PAGINAS- ZONA PUBLICA
$router->get('/',[PaginasController::class,'index']);
$router->get('/nosotros',[PaginasController::class,'nosotros']);
$router->get('/proceso',[PaginasController::class,'proceso']);
$router->get('/menu',[PaginasController::class,'menu']);
$router->get('/blog',[PaginasController::class,'blog']);
$router->get('/entrada',[PaginasController::class,'entrada']);
$router->get('/reserva',[PaginasController::class,'reserva']);
$router->post('/reserva',[PaginasController::class,'reserva']);


//API DE BLOG
$router->get('/api/blog', [APIController::class, 'blog']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();