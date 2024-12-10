<?php include_once __DIR__.'/../header.php'; ?>

<main class="contenedor contenido-principal">
    <h2 id="scroll"><span>Nuestros mejores</span> Contenidos</h2>
    <div class="contenido-blog" id="contenido-blog"></div>
    <div class="botones">
		<!-- Botón para ir a la página anterior -->
		<button id="atras" >&laquo;</button>
		<!-- Información de la página actual -->
		<span id="informacion-pagina" ></span>
		<!-- Botón para ir a la página siguiente -->
		<button id="siguiente">&raquo;</button>
	</div>
</main>

<?php $script .= '<script src="build/js/blogjs.js"></script>'; ?>

<?php include_once __DIR__.'/../footer.php'; ?>