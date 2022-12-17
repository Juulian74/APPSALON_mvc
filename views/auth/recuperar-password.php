<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Restablece tu Contraseña a continuacion</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>


<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Ingresa la nueva contraseña"/>
    </div>

    <input type="submit" class="boton" value="Guardar nuevo Password" readonly>
</form>

<div class="acciones">
    <a href="/">Regresar e Iniciar sesión</a>
    <a href="/crear-cuenta">Crear cuenta</a>
</div>
