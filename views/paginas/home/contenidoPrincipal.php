<main class="contenedor contenido-principal text-center">
    <section class="conoce">
        <h2><span>Conoce Más</span> Sobre Nosotros</h2>

        <p>SOMOS UN GRUPO DE ENTUSIASTAS DEL BUEN CAFÉ Y DEL TÉ<p>
        <p>Nos une un criterio gastronómico común cuyo eje principal es el de ofrecer a cada cliente un producto de calidad
        y según su gusto personal. Sabemos de dónde viene cada grano de café, cada ingrediente de nuestros deliciosos postres,<br> que hacen que tu día sea INMEJORABLE. 
        
   </section>
    <section class="iconos">
        <ul class="listado-iconos">
            <li>
                <img src="build/img/icono_cafe.svg" alt="icono-cafe">
                <p>Café</p>
            </li>
            <li>
                <img src="build/img/icono_postre.svg" alt="icono-postre">
                <p>Postre</p>
            </li>
            <li>
                <img src="build/img/icono_te.svg" alt="icono-te">
                <p>Té</p>
            </li>
        </ul>
    </section>
    <section class="experiencia">
        <h2><span>Vive la</span> Experiencia</h2>
        <div class="galeria_imagenes">
        <?php foreach ($galeria as $imagen) {  ?>
            <div class="imagen_galeria">
                <img src="/build/img/galeria/<?php echo $imagen->imagen;?>" alt="foto_galeria">
            </div>
        <?php } ?>
        </div>
    </section>
</main>

<?php include_once 'menu.php'; ?>

<section class="nuestros-testimoniales contenedor bg-white margin-negativo-10">
    <h2><span>Lo que dicen</span> Nuetros Clientes</h2>
    <div class="testimoniales-grid">
        <div class="testimonial first">
            <p>“La única cafetería en Madrid que cumple con las condiciones de la tercera ola de café (‘third wave of coffee’):
                alta calidad de espresso, buena espuma de leche,
                gran variedad de granos bien tostados…, por no hablar de la fantástica hospitalidad.”</p>
            <p class="autor">Alexandra Tutica - Coffee❤️ </p>
        </div>
        <div class="testimonial">
            <p>“Ayer tuve la ocasión de pasar por primera vez por esta deliciosa cafetería, donde se da importancia
                al producto y al servicio y donde puedes sentirte especial simplemente tomando un gran café. Gracias por ofrecernos lugares con personalidad.”</p>
            <p class="autor">Ariana Alvarez - Coffee❤️ </p>
        </div>
        <div class="testimonial">
            <p>“Creo que es el primer establecimiento de este tipo en Madrid. 
                Cafés que no tienen nada que ver con los de las cafeterías normales.
                Se centra en producto de calidad excepcional a precios competitivos. Sin duda, se ha convertido en mi favorito.”</p>
            <p class="autor">Juan Goméz - Coffee❤️ </p>
        </div>
        <div class="testimonial last">
            <p>“Ha superado todas mis expectativas. Es algo distinto para lo que estamos acostumbrados en Madrid.
                El trato es excelente y la sonrisa de la gente que trabaja allí te motiva a volver otra vez.”</p>
            <p class="autor">Marco Fuentes - Coffee❤️ </p>
        </div>
    </div>
</section>
