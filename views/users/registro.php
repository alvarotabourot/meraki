<?php 
include_once __DIR__."/../../includes/funciones.php";
incluirTemplate('header');
?>

<?php include_once __DIR__."/../../includes/alertas.php"; ?>

<div class="container-formulario-centrar">
    <div class="container-formulario-verde">
        <form action="<?= $_ENV['BASE_URL']?>registro" method="POST" class="formulario">
            <div class="contenido-formulario">
                <h3>Registrarse</h3>
                <div class="campo">
                    <label for="email">Correo</label>
                    <input type="email" name="data[email]" id="email">
                </div>
                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input type="password" name="data[password]" id="password">
                </div>
                <div class="campo">
                    <label for="telefono">Telefono</label>
                    <input type="tel" name="data[telefono]" id="telefono">
                </div>
                <div class="campo">
                    <label for="nombreUsuario">Nombre de usuario</label>
                    <input type="text" name="data[nombreUsuario]" id="nombreUsuario">
                </div>
                <div class="campo">
                    <fieldset>
                        <legend>¿Eres fotografo?</legend>
                        <label for="fotografo">Si</label>
                        <input type="checkbox" id="fotografo" name="data[fotografo]" value="si">
                        <label for="fotografo">No</label>
                        <input type="checkbox" id="fotografo" name="data[fotografo]" value="no">
                    </fieldset>
                </div>
            </div>
                
            <input type="submit" value="Guardar">
        </form>
    </div>
    <div class="acciones">
        <a href="<?= $_ENV['BASE_URL']?>login">¿Ya tienes una cuenta? Inicia sesion</a>
    </div>
</div>




<?php 
incluirTemplate('footer');
?>
