<?php 
include_once __DIR__."/../../includes/funciones.php";
incluirTemplate('header');
?>

<?php include_once __DIR__."/../../includes/alertas.php"; ?>

<div class="container-formulario-centrar">
    <div class="container-formulario-verde">
        <form action="<?= $_ENV['BASE_URL']?>login" method="POST" class="formulario">
            <div class="contenido-formulario">
                <h3>Iniciar sesion</h3>
                <div class="campo">
                    <label for="email">Correo</label>
                    <input type="email" name="data[email]" id="email">
                </div>
                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input type="password" name="data[password]" id="password">
                </div>
                <input type="submit" value="Iniciar Sesion">
            </div>
        </form>
    </div>
    <div class="acciones">
        <a href="<?= $_ENV['BASE_URL']?>olvide">¿Has olvidado tu contraseña? Resetear </a>
        <a href="<?= $_ENV['BASE_URL']?>registro">¿Aún no tienes una cuenta? Crear una</a>
    </div>  
</div>

<?php 
incluirTemplate('footer');
?>
