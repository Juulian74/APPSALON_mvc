<?php 
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // llamar a las variables de entorno para mejor seguridad
$dotenv->safeLoad(); // si el archivo de env no existe no marcara un error

require 'funciones.php';
require 'database.php';



// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);