<section class="menu-principal">
    <h2 class="heading-blanco"><span>Nuestro Delicioso</span> Menú</h2>
    <div class="contenedor grid-menu">
    <section class="menu cafe">
        <h3>Café</h3>
        <ul>
            <?php foreach($menuCafe as $cafe){ ?>
                <li class="listado-menu">
                    <p><?php echo $cafe->nombre; ?><span><?php echo $cafe->descripcion; ?></span></p>
                    <p class="precio"><?php echo $cafe->precio; ?>€</p>
                </li>   
            <?php } ?>
        </ul>
    </section>
    <section class="menu postre">
        <h3>Postre</h3>
        <ul>
            <?php foreach($menuPostre as $postre){ ?>
                <li class="listado-menu">
                    <p><?php echo $postre->nombre; ?><span><?php echo $postre->descripcion; ?></span></p>
                    <p class="precio"><?php echo $postre->precio; ?>€</p>
                </li>   
            <?php } ?>
        </ul>
    </section>
    <?php $titulo === 'Menú' ? include_once __DIR__.'/../menu/menuTemporada.php' : ''; ?>
    </div>
</section>