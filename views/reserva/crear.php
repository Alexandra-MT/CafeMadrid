<main class="contenedor admin">
<h1><?php echo $titulo; ?></h1>

<?php  include_once __DIR__.'/../templates/alertas.php';?>

<a href="/reserva-mostrar" class="boton boton-verde"">Volver</a>

<form class="formulario" method="POST">
    
    <?php include 'formulario_reserva.php'; ?>
    <input type="submit" value="Crear Reserva" class="boton boton-verde">
   
</form>
</main>