<?php 
include_once __DIR__."/../../includes/funciones.php";
incluirTemplate('header');
?>


<div class="container-formulario-centrar">
    <div class="container-formulario-verde">
        <form action="<?= $_ENV['BASE_URL']?>olvide" method="POST" class="formulario">
            <div class="contenido-formulario">
                <h3>Reestablecer contraseña</h3>

                <p>Por favor introduzca su correo.</p> 
                <p>Le enviaremos instrucciones para reestablecer su contraseña</p>
                <div class="campo">
                    <label for="email">Correo</label>
                    <input type="email" name="data[email]" id="email">
                </div>
            </div>
            <input type="submit" value="Enviar"> 
        </form>  
    </div>
</div>
    


<?php 
incluirTemplate('footer');
?>