<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\ServicioControllers;

$router = new Router();

// Inciar sesion
$router->get('/', [LoginController::class , 'login']);
$router->post('/', [LoginController::class , 'login']);
$router->get('/logout', [LoginController::class , 'logout']);

// Recuperar Password
$router->get('/olvide', [LoginController::class , 'olvide']);
$router->post('/olvide', [LoginController::class , 'olvide']); // mediante un formulario, validamos que esa ceunta exista y tenga ese mail, envia instrucciones para recuperar la cuenta
$router->get('/recuperar', [LoginController::class , 'recuperar']); // nuevo formulario para escribir la nueva  contraseña
$router->post('/recuperar', [LoginController::class , 'recuperar']); // reescribe la contraseña

// Crear cuenta
$router->get('/crear-cuenta', [LoginController::class , 'crear']);
$router->post('/crear-cuenta', [LoginController::class , 'crear']);

// Confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

//** AREA PRIVADA**
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);


// API de citas
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);

// CRUD de Serivicos
$router->get('/servicios', [ServicioControllers::class, 'index']);
$router->get('/servicios/crear', [ServicioControllers::class, 'crear']);
$router->post('/servicios/crear', [ServicioControllers::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioControllers::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioControllers::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioControllers::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();