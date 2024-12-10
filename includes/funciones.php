<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION)) {
        session_start();
    }
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

//muestra los mensajes
function mostrarNotificacion($codigo){
    $mensaje='';
    switch($codigo){
        case 1:
            $mensaje='Creado Correctamente';
            break;
        case 2:
            $mensaje='Actualizado Correctamente';
            break;
        case 3:
            $mensaje='Eliminado Correctamente';
            break;
        default:
            $mensaje=false;
            break;
    }
    return $mensaje;
}