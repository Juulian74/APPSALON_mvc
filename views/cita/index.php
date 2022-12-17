<h1 class="nombre-pagina">Crear Nueva cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos </p>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button"  data-paso="1">Servicios</button> <!---(data-) Sirve para crear tus propios atributos, en este caso nos sirve para que se muestren difernetes secciones dependiendo a que boton clickemos, en el id se muestra el paso que corresponde a cada boton-->
        <button type="button" data-paso="2">Informacion Cita</button> 
        <button type="button" data-paso="3">Resumen</button> 
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita </p>
        <div id="servicios" class="listado-servicios"></div>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Tu nombre</label>
                <input id="nombre" type="text" placeholder="Tu nombre" value="<?php echo $nombre;?>" disabled/>
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input id="fecha" type="date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"> <!-- min sirve para establecer La minima fecha, strtotime('+1 day') te impie seleccionar el dia actual-->
            </div>

            

            <div class="campo">
                <label for="hora">Hora</label>
                <input id="hora" type="time">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>" >
        </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button> <!-- (&laquo;) añade flechas-->
        <button id="siguiente" class="boton"> Siguiente &raquo;</button>
    </div>

</div>

<?php // insertar scripts
    $script = "
    <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/app.js'></script>
    ";

?>