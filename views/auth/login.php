<h1 class="nombre-pagina">login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";  // Para que aparezcan  las alertas hay que incluirlas
?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email" value="<?php echo s($auth->email); ?>" />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu password" name="password" value="<?php echo s($auth->password); ?>" />
    </div>
    <input type="submit" class="boton" value="Inicar Sesión" readonly> 
</form>

<div class="acciones">
    <a href="/crear-cuenta">Crea una Cuenta</a>
    <a href="/olvide">Olvide mi password</a>
</div>