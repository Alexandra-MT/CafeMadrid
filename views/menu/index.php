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
        <a href="menu/crear" class="boton boton-naranja">Nuevo Producto +</a>
    </div>

    <ul class="menu">
        <?php foreach($menu as $producto){ ?>
        <li>
            <p>ID: <span><?php echo $producto->id; ?></span></p>
            <p>Nombre: <span><?php echo $producto->nombre; ?></span></p>
            <p>Precio: <span> € <?php echo $producto->precio; ?></span></p>
            <p>Descripcion: <span><?php echo $producto->descripcion; ?></span></p>
            <div class="acciones">
                <a href="/menu/actualizar?id=<?php echo $producto->id; ?>" class="boton boton-verde">Actualizar</a>
                <form method="POST" action="/menu/eliminar">
                    <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
                    <input type="submit" class="boton boton-rojo" value="Eliminar">
                </form>
            </div>
        </li>     
    <?php } ?>
    </ul>
</main>