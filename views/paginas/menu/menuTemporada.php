<section class="menu temporada">
<h3>Enero-Mayo</h3>
        <ul>
            <?php foreach($menuPrimerosMeses as $temporada){ ?>
                <li class="listado-menu">
                    <p><?php echo $temporada->nombre; ?><span><?php echo $temporada->descripcion; ?></span></p>
                    <p class="precio"><?php echo $temporada->precio; ?>€</p>
                </li>   
            <?php } ?>
        </ul>
    </section>
    <section class="menu temporada">
    <h3>Noviembre-Diciembre</h3>
        <ul>
            <?php foreach($menuUltimosMeses as $temporada){ ?>
                <li class="listado-menu">
                    <p><?php echo $temporada->nombre; ?><span><?php echo $temporada->descripcion; ?></span></p>
                    <p class="precio"><?php echo $temporada->precio; ?>€</p>
                </li>   
            <?php } ?>
        </ul>
    </section>

