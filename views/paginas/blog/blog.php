<?php include_once __DIR__.'/../header.php'; ?>

<main class="contenedor contenido-principal">
    <h2><span>Nuestros mejores</span> Contenidos</h2>
    <div class="contenido-blog">
    <?php foreach($blog as $entrada): ?>
        <article class="entrada-blog">
            <div class="imagen">
                <img loading="lazy" src="/build/img/blog/<?php echo $entrada->imagen; ?>" alt="Texto Entrada Blog">
            </div>

            <div class="texto-entrada">
                <a href="/entrada?id=<?php echo $entrada->id; ?>"">
                    <h4><?php echo $entrada->titulo; ?></h4>
                    <p class="informacion-meta">Escrito el: <span><?php echo date("d/m/Y", strtotime($entrada->fecha)) ?></span> por: <span><?php echo $entrada->autor; ?></span> </p>
                </a>
            </div>
        </article>
    <?php endforeach; ?>
    </div>
    <ul class="paginacion">
        <!-- Si la página actual es mayor a uno, mostramos el botón para ir una página atrás -->
        <?php if ($pagina > 1) { ?>
            <li>
                <a href="blog?pagina=<?php echo $pagina - 1 ?>">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>

        <!-- Mostramos enlaces para ir a todas las páginas. Es un simple ciclo for-->
        <?php for ($x = 1; $x <= $paginas; $x++) { ?>
            <li class="<?php if ($x == $pagina) echo "active" ?>">
                <a href="/blog?pagina=<?php echo $x ?>">
                    <?php echo $x ?></a>
            </li>
        <?php } ?>
        <!-- Si la página actual es menor al total de páginas, mostramos un botón para ir una página adelante -->
        <?php if ($pagina < $paginas) { ?>
            <li>
                <a href="/blog?pagina=<?php echo $pagina + 1 ?>">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php } ?>
    </ul>
</main>

<?php include_once __DIR__.'/../footer.php'; ?>