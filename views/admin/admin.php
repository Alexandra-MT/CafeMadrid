<div class="panel">
<main class="contenedor admin">
    <h1><?php echo $titulo; ?></h1>

    <h2>Panel de Administración</h2>

    <div class="acciones">
        <a href="/galeria-mostrar" class="boton boton-verde-block">Galería</a>
        <a href="/menu-mostrar" class="boton boton-verde-block">Menú</a>
        <a href="/blog-mostrar" class="boton boton-verde-block">Blog</a>
        <a href="/reserva-mostrar" class="boton boton-verde-block">Reserva</a>
    </div>
    <div class="cerrar-sesion">
        <?php if(isset($auth)): ?>
            <a href="/logout" class="boton boton-rojo">Cerrar Sesión</a>
        <?php endif; ?>
    </div>
</main>
</div>