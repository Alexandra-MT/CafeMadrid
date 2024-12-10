<?php

namespace Controllers;

use Model\Blog;

class APIController{
    public static function blog(){

        $blog = Blog::all();
        echo json_encode($blog);   
    }
}