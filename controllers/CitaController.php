<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index( Router $router) {
        
        if(!isset($_SESSION)){  // si no esta inicializado en la secion el nombre se inici
            session_start();
          }

        isAuth(); // ejecuta esta funcion antes de mostrar la vista(verifica si est atuenticado)

        $router->render('cita/index',[
            'nombre' => $_SESSION['nombre'],
            "id" => $_SESSION["id"]
        ]);
    }
}

if(!isset($_SESSION)){
    session_start();
}