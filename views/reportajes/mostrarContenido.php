<?php 
    include_once __DIR__."/../../includes/funciones.php";
    incluirTemplate('header');
?>

<div class="centrar-reportaje">
    <div class="contenido-texto-reportaje">
        <p><?= $reportaje->descripcion ?></p>
        <p>De parte de vuestro fotografo: <a href="<?= $_ENV['BASE_URL']?>fotografo/perfil/<?=$fotografo->userId?>"><?= $fotografo->nombre ?></a></p>
    </div>
</div>
<?php if(isset($_SESSION['login'])): ?>
    <?php if($_SESSION['id'] == $reportaje->usersId): ?>
        <div class="centrar-reportaje">
            <form action="<?= $_ENV['BASE_URL'] ?>reportaje/subirFoto/<?= strval($reportaje->id) ?>" enctype="multipart/form-data" method="POST" class="form-fotoReportaje">
                <label for="imagen">Añadir imagen al reportaje</label>
                <input type="file" name="imagen">
                <button type="submit">Subir imagen</button>
            </form>
        </div>
    <?php endif; ?>

<?php endif; ?>


<div class="centrar-reportaje">
    <div class="reportaje-verde">
        <div class="contenido-fotos-reportaje">
            <?php foreach($fotos as $foto): ?>
                <div class="imagen-reportaje">
                    <img src="<?= $_ENV['BASE_URL']?>img/fotosReportaje/<?= $foto->url?>" alt="foto" class="zoom">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php if(isset($_SESSION['login']) && isset($_SESSION['loginNormal'])): ?>
    <div class="botonFav">
        <button><a href="<?= $_ENV['BASE_URL']?>reportaje/favoritos">Añadir a favoritos</a></button>
    </div>
<?php endif; ?>


<?php   
    incluirTemplate('footer');
?>