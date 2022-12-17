<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];

        $auth = new Usuario; 

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            

            if(empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario){
                    // Verificar el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // Autenticarlo
                        session_start();

                        // Traigo todos los datos del usuario que crea necesarios, para despues autocompletar email nombre apellido, etc dentro de la pagina
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        
                        // Redireccionamiento
                        if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;   

                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }

                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encotnrado'); // setear una alerta sin hacer una variable
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);


    }

    public static function logout() {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }

    public static function olvide(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST' ){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) { // si se ingreso un mail
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1") { // si existe y esta confirmado
                    // Generar un toke de un solo us
                    $usuario->crearToken();
                    $usuario->guardar(); // guarda el token el base de datos, respecto al id

                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alertas
                    Usuario::setAlerta('exito', 'Revisa tu email');
                } else {
                    Usuario::setAlerta('error', 'El email no existe o no esta confirmado');
                    
                }
                $alertas = Usuario::getAlertas();
            }
        }
        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }



    public static function recuperar(Router $router) {
        $alertas=[];
        $error = false;

        $token = s($_GET['token']);

        // Buscar usuario por su token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }

            }
        }


        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas'=> $alertas,
            'error' => $error    
        ]);
    }



    public static function crear(Router $router) {

        $usuario = new Usuario;

        // Alarteas Vacias
        $alertas= [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);  // sicnroniza con los datos que se fueron pusiendo anteirormetne
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alerta este vacio (no haya errores)
            if(empty($alertas)) {
                // Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) { // trae el resultado de existeUsuario y verifica si ya existe o no
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Generar un Token unico
                    $usuario->crearToken();

                    // Enviar el email de verificacion

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();


                    // Crear el usuario
                    $resultado = $usuario->guardar(); // guardar evalua si hay un id actualiza los resultados y sino lo crea
                    if($resultado) {
                        header('Location: /mensaje');
                    }

                    //debuguear($usuario);
                }
            }


        }
        
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }


    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];

        $token = s($_GET['token']); // sanitizamos el token

        $usuario = Usuario::where('token', $token); // Busca en una columna, este caso la de token y un valor($token) el de la url

        if(empty($usuario) || $usuario->token === '' )  {
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido'); // se guarda en memoria una alerta
        } else {
            // Modificar a usuario correctamente

            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar(); // guarda en base de datos lo que se haya creado, o acutalizado
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        // Obtener alertas
        $alertas = Usuario::getAlertas(); // se pasa al valor las alertas guardadas antes de renderizar 

        // Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas'=>$alertas
        ]);
    }
}