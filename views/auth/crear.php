<div class="panel">
<main class="contenedor admin login">
    <h1><?php echo $titulo; ?></h1>


    <form action="/crear" method="POST" class="formulario">
        <fieldset>
        <?php include_once __DIR__.'/../templates/alertas.php'; ?>
            <legend>Introduce email y contraseña</legend>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Tu Email">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Tu Password">
            <input type="submit" value="Crear Usuario" class="boton boton-primario">
        </fieldset>
    </form>
</main>
</div>