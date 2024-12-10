<fieldset>
    <legend>Información General</legend>
    <label for="nombre">Nombre:</label>
    <input type="text" class="nombre" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?php echo s($reserva->nombre); ?>" autocomplete="off">
    <label for="email">Email:</label>
    <input type="email" class="email" id="email" name="email" placeholder="Tu Email" value="<?php echo s($reserva->email); ?>" autocomplete="off">
    <label for="personas">Número de personas:</label>
    <select name="personas" id="personas" >
        <option selected disabled value="">--Seleccione--</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="mas">+4</option>
    </select>
    <label for="fecha">Fecha:</label>
    <input type="date" class="fecha" id="fecha" name="fecha">   
    <label for="hora">Hora:</label>
    <input type="time" class="hora" id="hora" name="hora">              
</fieldset>