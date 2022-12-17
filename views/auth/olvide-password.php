<h1 class="nobmre-pagina">Olvide el password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email a continuacion</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Tu email"/>
    </div>
    <input type="submit" class="boton" value="Enviar" readonly>
</form>

<div class="acciones">
    <a href="/">Regresar e Iniciar sesión</a>
    <a href="/olvide">Crear cuenta</a>
</div>