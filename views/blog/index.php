<main class="contenedor admin">
    <h1><?php echo $titulo; ?></h1>

    <?php if($resultado){  // ?? o isset para evitar errores en /admin
        $mensaje = mostrarNotificacion( intval( $resultado) );
            if($mensaje) { ?>
                <p class="alerta exito"><?php echo s($mensaje); ?></p>
            <?php } ?>
        <?php } ?>
    <div class="acciones principales">
        <a href="admin" class="boton boton-verde">Admin</a>
        <a href="blog/crear" class="boton boton-naranja">Nueva Entrada +</a>
    </div>
    <ul class="blog">
        <?php foreach($blog as $entrada){ ?>
        <li>
            <p>ID: <span><?php echo $entrada->id; ?></span></p>
            <p>Titulo: <span><?php echo $entrada->titulo; ?></span></p>
            <p>Imagen: <img src="build/img/blog/<?php echo $entrada->imagen; ?>" class="imagen-entrada"></p>
            <p>Fecha: <span><?php echo $entrada->fecha; ?></span> Hora: <span><?php echo $entrada->autor; ?></span></p>
            <p>Introduccion: <span><?php echo $entrada->introduccion; ?></span></p>
            <p>Contenido: <span><?php echo $entrada->contenido; ?></span></p>
            <div class="acciones">
                <a href="/blog/actualizar?id=<?php echo $entrada->id; ?>" class="boton boton-verde">Actualizar</a>
                <form method="POST" action="/blog/eliminar">
                    <input type="hidden" name="id" value="<?php echo $entrada->id; ?>">
                    <input type="submit" class=" boton boton-rojo" value="Eliminar">
                </form>    
            </div>
        </li>
        <?php } ?>
    </ul>
</main>