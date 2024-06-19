<?php 
include_once __DIR__."/../../includes/funciones.php";
incluirTemplate('header');
?>


<div class="container-formulario-centrar">
    <div class="container-formulario-verde">
        <form action="<?= $_ENV['BASE_URL']?>recuperar/<?=$id?>" method="POST" class="formulario">
            <div class="contenido-formulario">
                <h3>Restablecer</h3>
                <h4>Introduzca la nueva contraseña para actualizarla</h4>
                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input type="password" name="data[password]" id="password">
                </div>
                <input type="submit" value="Restablecer">
            </div>
        </form>
    </div>
    <div class="acciones">
        <a href="<?= $_ENV['BASE_URL']?>login">¿Ya tienes una cuenta? Inicia sesion</a>
        <a href="<?= $_ENV['BASE_URL']?>registro">¿Aún no tienes una cuenta? Crear una</a>
    </div>
</div>
<?php 
incluirTemplate('footer');
?>