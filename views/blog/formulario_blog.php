<fieldset>
    <legend>Información General</legend>
    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Titulo Blog" value="<?php echo s($blog->titulo); ?>">
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

    <?php if($blog->imagen):?>
        <img src="/build/img/blog/<?php echo $blog->imagen;?>" class="imagen-small">
    <?php endif; ?>

    <label for="introduccion">Introduccion:</label>
    <!--no tiene value-->
    <textarea id="introduccion" name="introduccion" cols="30" rows="10"><?php echo s($blog->introduccion); ?></textarea>
    <label for="contenido">Contenido:</label>
    <textarea id="contenido" name="contenido" cols="30" rows="10"><?php echo s($blog->contenido); ?></textarea>

</fieldset>
<fieldset>
    <legend>Autor</legend>
    <label for="autor">Autor</label>
    <select id="autor" name="autor">
        <option disabled value="">-- Seleccione --</option>
        <option value="coffeeLover">CoffeeLover</option>
    </select>
</fieldset>