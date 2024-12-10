<main class="contenedor admin">
    <h1><?php echo $titulo; ?></h1>

    <?php  include_once __DIR__.'/../templates/alertas.php';?>

    <a href="/galeria-mostrar" class="boton boton-verde">Volver</a>
    <form class="formulario" method="POST" enctype="multipart/form-data"> 
        <?php include 'formulario_galeria.php'; ?>
        <input type="submit" value="Actualizar Galeria" class="boton boton-verde">
    </form>
</main>