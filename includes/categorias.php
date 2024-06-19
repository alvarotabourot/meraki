

<?php if(isset($categorias)): ?>
<div class="contenedor-categorias">
    <div class="contenedor-categorias-verde">
        <div class="categorias">
            <?php 
                foreach($categorias as $categoria):
            ?>
            <div class="categoria">
                <div class="imagenCategoria">
                    <img src="<?= $_ENV['BASE_URL']?>img/categorias/<?=$categoria->url?>" alt="fotocategoria">
                </div>
                <p><a href="<?= $_ENV['BASE_URL']?>categoria/tipo/<?=$categoria->id?>"><?= $categoria->nombre?></a></p>
                
                
            </div>
            <?php
                endforeach;
            ?>
        </div>
    </div>
</div>
<?php endif; ?>