<?php 
include_once __DIR__."/../../includes/funciones.php";
incluirTemplate('header');
?>

<?php include_once __DIR__."/../../includes/alertas.php"; ?>

<div class="container-formulario-centrar">
    <div class="container-formulario-verde">
        <form action="<?= $_ENV['BASE_URL']?>reportaje/registrar/<?= $idCategoria?>" method="POST" class="formulario" enctype="multipart/form-data">
            <div class="contenido-formulario">
                <h3>Registrar reportaje</h3>
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="data[nombre]" id="email">
                </div>
                <div class="campo">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="data[fecha]" id="fecha">
                </div>
                <div class="campo">
                    <label for="descripcion">Descripcion</label>
                    <textarea type="tel" name="data[descripcion]" id="telefono" maxlength="255"></textarea>
                </div>
                <div class="campo">
                    <label for="imagen">Imagen</label>
                    <input type="file" name="imagen" id="imagen">
                </div>
            </div>
                
            <input type="submit" value="Registrar">
        </form>
    </div>
</div>




<?php 
incluirTemplate('footer');
?>
