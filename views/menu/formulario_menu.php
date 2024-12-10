<fieldset>
    <legend>Información General</legend>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre Producto" value="<?php echo s($menu->nombre); ?>">
    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" placeholder="Precio Producto" min="0" step=".01" value="<?php echo s($menu->precio); ?>">
    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion"><?php echo s($menu->descripcion); ?></textarea>
</fieldset>