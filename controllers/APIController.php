<?php

namespace Controllers;

use Model\Blog;

class APIController{
    //API entradas
    public static function blog(){
        //Todas las entradas
        $blog = Blog::all();
        echo json_encode($blog);   
    }
}