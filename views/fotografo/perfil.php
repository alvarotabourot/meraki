<?php 
    include_once __DIR__."/../../includes/funciones.php";
    incluirTemplate('header');
?>

<?php if(isset($perfil)): ?>
<div class="contenedor-centrar-infoPerfil">
    <div class="textoPerfil">
        <h2>CONOCEME</h2>
        <p>¡Hola! Soy <?= $perfil->nombre ?></p>
        <p><?= $perfil->descripcion ?></p>
    </div>
    <div class="imagenPerfil">
        <img src="<?= $_ENV['BASE_URL']?>img/perfiles/<?= $perfil->url ?>" alt="">
    </div>
</div>

<?php endif; ?>


<?php if(isset($_SESSION['reportajes'])): ?>

<p class="trabajos-perfil">Aquí os presento algunos de mis trabajos </p>
    <div class="contenedor-perfil-verde">
        <?php foreach($_SESSION['reportajes'] as $reportaje): ?>
                <div class="contenedor-reportaje">
                    <a href="<?= $_ENV['BASE_URL']?>reportaje/contenido/<?= strval($reportaje->id) ?>"><img src="<?= $_ENV['BASE_URL']?>img/reportajes/<?= $reportaje->url ?>" alt="foto reportaje"></a>
                </div>
        <?php  endforeach; ?>
    </div>

<?php endif; ?>



<div class="trabajos-perfil">
    <h2>CONTACTO</h2>
    <p>Si quereis que forme parte de vuestros momentos, no dudeis en dejarme vuestros datos y os contactaré. Estaré encantando de ayudaros</p>
</div>

<div class="contenedor-centrar-formulario">
    <div class="contenedor-formulario-perfil">
        <form action="<?= $_ENV['BASE_URL']?>contacto/<?= $perfil->userId?>" method="post">
            <div class="campo-form-perfil">
                <label for="nombre">Nombre</label>
                <input type="text" name="data[nombre]">
            </div>
            <div class="campo-form-perfil">
                <label for="email">Correo</label>
                <input type="email" name="data[email]">
            </div>
            <div class="campo-form-perfil">
                <label for="telefono">Telefono</label>
                <input type="text" name="data[telefono]">
            </div>
            <input type="submit" value="Enviar datos">
        </form>
    </div>
</div>

<?php 
    incluirTemplate('footer');
?>