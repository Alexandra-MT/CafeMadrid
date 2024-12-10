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
        <a href="galeria/crear" class="boton boton-naranja">Nueva Imagen +</a>
    </div>
    <ul class="galeria">
        <?php foreach($galeria as $imagenGaleria){ ?>
        <li>
            <p>ID: <span><?php echo $imagenGaleria->id; ?></span></p>
            <p>Titulo: <span><?php echo $imagenGaleria->titulo; ?></span></p>
            <p>Imagen: <img src="build/img/galeria/<?php echo $imagenGaleria->imagen; ?>" class="imagen-galeria"></p>
            <div class="acciones">
                <a href="/galeria/actualizar?id=<?php echo $imagenGaleria->id; ?>" class="boton boton-verde">Actualizar</a>
                <form method="POST" action="/galeria/eliminar">
                    <input type="hidden" name="id" value="<?php echo $imagenGaleria->id; ?>">
                    <input type="submit" class="boton boton-rojo-block" value="Eliminar">
                </form>
            </div>  
        </li> 
        <?php } ?>
    </ul>
</main>