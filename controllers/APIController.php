<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios); // se manda  el codigo en formato json
    }

    public static function guardar() { 
        
        // Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado ['id'];


        // Almacena los servicios con el ID de la cita
        $idServicios = explode(",", $_POST['servicios']); // pasamos el separador y los datos

        foreach($idServicios as $idServicio) { // no requiere el id porque va a ser un id nuevo
            $args = [
                'citaid' => $id,
                'servicioid' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]); // se manda el resultado al js para que se muestre la alerta
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){// asegurarnos de que se ejecute solo con un metodo post
            $id=$_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']); // nos manda al url del cual venimos
        }
    }
}
