<main class="contenedor seccion contenido-centrado">
    <h1 data-cy="heading-login">Iniciar Sesión</h1>
    <?php foreach($errores as $error): ?>
        <div data-cy="alerta-login" class="alerta error"><?php echo $error;?></div>
    <?php endforeach;?>
    <form data-cy="formulario-login" method="POST" class="formulario" action="/login">
        <fieldset>
            <legend>E-mail y Password</legend>

            <label for="email">E-mail</label>
            <input data-cy="formulario-email" ="email" name="email" placeholder="Tu Email" id="email">

            <label for="password">Tu Password</label>
            <input data-cy="formulario-password" type="password" name="password" placeholder="Tu Password" id="password">

            <input type="submit" value="Iniciar Sesión" class="boton-verde">
        </fieldset>
    </form>
</main>
