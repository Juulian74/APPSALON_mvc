<?php

namespace Model;

class Usuario extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token']; //normaliza los datos, los trae de la db

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';

    }

    // Mensajes de validadion para la crearcion de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El telefono es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Su contraseña es vulnerable, ingrese una contraseña mayor a 6 digitos';
        }
        return self:: $alertas;
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'Tienes que ingresar un email';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'Tienes que ingresar una contraseña';
        }

        return self::$alertas;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }



    // Revisa si el usuario existe
    public function existeUsuario() {
        $query = " SELECT * FROM " .self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1"; // selecciona todo los sobre la tabla para comprobar que el email enviado exista (this trae el post con lo escrito por el usuario), limit de 1 para que detenga la busqueda al encontrar 1 email igual

        $resultado = self::$db->query($query);

        if($resultado->num_rows) { // sentaxis de flecha porque es un objeto(aparece al debugar $resultado como object)
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }

        return $resultado;  // retorna el resultado de la variable con la alertas cargada para enviarla al login controller
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();  // genera una cadena de numeros aleatorios
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password); // verifica el password que le paso el usuario, con el de la base de datos para ver si es correcto
       
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password incorrecto o tu cuenta no esta confirmada';
        } else {
            return true;
        }
    }

   
}