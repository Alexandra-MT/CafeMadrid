
    <fieldset>
        <legend>Información General</legend>
        <label for="titulo">Titulo:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Titulo Imagen" value="<?php echo s($galeria->titulo); ?>">
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

        <?php if($galeria->imagen):?>
            <img src="/build/img/galeria/<?php echo $galeria->imagen;?>" class="imagen-small">
        <?php endif; ?>
    </fieldset>
