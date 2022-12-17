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

function esUltimo($actual, $proximo): bool {

    if($actual !== $proximo){
        return true;

    }
    return false;
}


// Funcion que revisa que el usuario este autenticado
function isAuth() : void{ //no retorna nada
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }

}

function isAdmin() : void {
    if(!isset($_SESSION['admin'])){ // veroficamos que sea un admin
        header('Location: /');
    }
}