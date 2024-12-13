<header class="header <?php echo (isset($headerClass)) ? $headerClass : ''; ?>">
    <div class="contenido-header contenedor">
        <div class="barra-mobile">
            <div class="logo">
                <a href="/" aria-label="Logo cafeteria">
                <img src="build/img/logo2.png" alt="logo cafeteria">
                </a>
            </div>
            <div class="menu">
                <img class="mobile-menu" src="build/img/mobile/menu.svg" alt="imagen-menu">
            </div>
        </div>
        <div class="barra">
            <div class="logo">
                <a href="/" aria-label="Logo cafeteria">
                <img src="build/img/logo2.png" alt="logo cafeteria">
                </a>
            </div>
            <nav class="nav-principal">
                <a class="<?php echo ($titulo === 'Inicio') ? 'activo' : ''; ?>" href="/" aria-label="Inicio">Inicio</a>
                <a class="<?php echo ($titulo === 'Nosotros') ? 'activo' : '';?>" href="/nosotros" aria-label="Nosotros">Nosotros</a>
                <a class="<?php echo ($titulo === 'Proceso') ? 'activo' : ''; ?>" href="/proceso" aria-label="Proceso">Proceso</a>
                <a class="<?php echo ($titulo === 'Menú') ? 'activo' : ''; ?>" href="/menu" aria-label="Menu">Menú</a>
                <a class="<?php echo ($titulo === 'Blog') ? 'activo' : ''; ?>" href="/blog" aria-label="Blog">Blog</a>
                <a class="<?php echo ($titulo === 'Reserva') ? 'activo' : ''; ?>" href="/reserva" aria-label="Reserva">Reserva</a>
            </nav>
        </div>
        <div class="texto-header"><h1><?php echo $textoHeader ? $textoHeader : ''; ?></h1></div>

    </div>
</header>
<?php 
$script = '<script src="build/js/app.js"></script>'; 
$script .= '<script src="build/js/mobile.js"></script>'; ?>