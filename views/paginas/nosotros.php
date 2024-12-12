<?php include_once 'header.php'; ?>

<main class="contenedor contenido-principal">
    <h2><span>Conoce Más</span> Sobre Nosotros</h2>
    <div class="contenido-nosotros">
        <div class="imagen">
            <picture>
                <source
                srcset="build/img/nosotros02.webp"
                type="image/webp">
                <source
                srcset="build/img/nosotros02.avif"
                type="image/avif">
                <source
                srcset="build/img/nosotros02.jpg"
                type="image/jpg">
                <img src="build/img/nosotros02.jpg" alt="imagen-nosotros">
            </picture>
        </div>
        <div class="texto">
            <p>En nuestras cafeterías encontrarás un sabor auténtico,
                elaborado con ingredientes de la más alta calidad en un ambiente acogedor y agradable.
                Y es que en CaféMadrid sabemos que no hay nada como disfrutar de los pequeños momentos del día,
                y para poder saborearlos lo ideal es ofrecerlos recién horneados y al momento durante todo el día.</p>
            <blockquote> Y además..... </blockquote>
            <p>Ofrecemos un servicio amable, ágil y rápido donde lo más importante de nuestras recetas es la calidad de los ingredientes,
                para que lo único que tenga de rápida nuestra comida sea la velocidad a la que se prepara.</p>
        </div>
    </div>
</main>

<?php include_once 'footer.php'; ?>