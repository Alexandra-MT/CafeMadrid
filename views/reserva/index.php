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
        <a href="reserva/crear" class="boton boton-naranja">Nueva Reserva +</a>
    </div>
    <div class="busqueda">
        <form action="" class="formulario" method="POST">
            <div class="campo">
                <div class="fecha-reserva">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
                </div>
                <input type="submit" class="boton boton-primario" value="Enviar">
            </div>
        </form>
    </div>

    <ul class="reserva">

        <?php include_once __DIR__.'/../templates/alertas.php'; ?> 
        
        <?php foreach($reservas as $reserva){ ?>
        <li>
            <p>ID reserva: <span><?php echo $reserva->id; ?></span></p>
            <p>Nombre cliente: <span><?php echo $reserva->nombre; ?></span></p>
            <p>Email cliente: <span><?php echo $reserva->email; ?></span></p>
            <p>Reserva para: <span><?php echo $reserva->personas; ?></span> personas</p>
            <p>Hora reserva: <span><?php echo $reserva->hora; ?></span></p>
            <p>Fecha reserva: <span><?php echo date('d/m/Y',strtotime($reserva->fecha)); ?></span></p>
            <div class="acciones">
                <a href="/reserva/actualizar?id=<?php echo $reserva->id; ?>" class="boton boton-verde">Actualizar</a>
                <form method="POST" action="/reserva/eliminar">
                    <input type="hidden" name="id" value="<?php echo $reserva->id; ?>">
                    <input type="submit" class="boton boton-rojo" value="Eliminar">
                </form>
            </div>
        </li>
        <?php } ?>
    </ul>
</main>