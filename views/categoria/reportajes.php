<?php 
    include_once __DIR__."/../../includes/funciones.php";
    incluirTemplate('header');
?>
<div class="tituloReportajes">
    <h2>Reportajes</h2>
    
</div>


<?php if(is_array($reportajes)): ?>
    <div class="centrar-reportajes">
        <?php  foreach($reportajes as $reportaje): ?>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="<?= $_ENV['BASE_URL']?>img/reportajes/<?= $reportaje->url?>" alt="foto reportaje">
                    </div>

                    <div class="flip-card-back">
                        <a href="<?= $_ENV['BASE_URL']?>reportaje/contenido/<?= strval($reportaje->id) ?>"><h2><?= $reportaje->nombre?></h2></a>
                        <p><?= $reportaje->fecha?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if( isset($_SESSION['fotografo']) ): ?>
        <div class="añadirReportaje">
            <a href="<?= $_ENV['BASE_URL']?>reportaje/registrar/<?= $_SESSION['categoriaId']?>">Añadir Reportaje</a>
        </div>
    <?php endif; ?>
    
<?php endif; ?>
<?php   
    incluirTemplate('footer');
?>