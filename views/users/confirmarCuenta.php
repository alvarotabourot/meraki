<?php 
include_once __DIR__."/../../includes/funciones.php";
incluirTemplate('header');
?>

<?php include_once __DIR__."/../../includes/alertas.php"; ?>


<div class="verificacion">
    <p>Hola <?= $usuario->nombreUsuario ?>. Su cuenta <?= $usuario->email ?> ha sido confirmada.</p>
    <p>Gracias por confirmar su cuenta.</p>
    <p>Para nosotros es importante asegurarnos de que nuestros usuarios son personales reales.</p>
    <p>Ya puede iniciar sesión sin problema pulsando aqui: <a href="<?= $_ENV['BASE_URL']?>login">Iniciar sesion</a></p>
</div>

<?php 

incluirTemplate('footer');
?>