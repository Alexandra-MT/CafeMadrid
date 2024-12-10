<?php include_once 'header.php'; ?>

<main class="contenedor contenido-principal">
    <h2 class="scroll"><span> Reserva tu</span> Mesa</h2>

    <div class="contenido-reserva">
        <div class="alertas">
            <?php include_once __DIR__.'/../templates/alertas.php'; ?>
        </div>
        <form class="formulario" action="/reserva" method="POST">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" class="nombre" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?php echo s($reserva->nombre); ?>" autocomplete="off">
            </div>
            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" class="email" id="email" name="email" placeholder="Tu Email" value="<?php echo s($reserva->email); ?>" autocomplete="off">
            </div>
            <div class="campo">
                <label for="personas">Número de personas:</label>
                <select name="personas" id="personas" >
                    <option selected disabled value="">--Seleccione--</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="mas">+4</option>
                </select>
            </div>
            <div class="campo">
                <label for="fecha">Fecha:</label>
                <input type="date" class="fecha" id="fecha" name="fecha">
            </div>
            <div class="campo">
                <label for="hora">Hora:</label>
                <input type="time" class="hora" id="hora" name="hora" >
            </div>
            <div class="campo">
                <input type="submit" value="Enviar">
            </div>
        </form>
    </div>
</main>

<?php $script .= '<script src="build/js/reservajs.js"></script>'; ?>
<?php $script .= '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; ?>

<?php include_once 'footer.php'; ?>