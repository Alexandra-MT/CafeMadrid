<?php include_once __DIR__.'/../header.php'; ?>

<main class="contenedor contenido-principal">
    <h2><span></span></h2>
    <div class="contenido-entrada">
        <h3><?php echo $entrada->titulo; ?></h3>
        <div class="introduccion-entrada">
            <p><?php echo $entrada->introduccion; ?></p>
        </div>
        <img src="/build/img/blog/<?php echo $entrada->imagen; ?>" alt="imagen del blog">
        <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span><?php echo $entrada->autor; ?></span></p>
    </div>
    <div class="contenido-entrada">
            <p><?php echo $entrada->contenido; ?></p>
    </div>
    <a href="/blog" class="boton-secundario">Descubre más</a>
</main>

    <?php include_once __DIR__.'/../footer.php'; ?>