<?php 
if( isset ($_SESSION['fotografo']) === true): ?>

<?php 
    include_once __DIR__."/../../includes/funciones.php";
    incluirTemplate('header');
?>

<?php include_once __DIR__."/../../includes/alertas.php"; ?>

<div class="container-formulario-centrar">
    <div class="container-formulario-verde">
        <form action="<?= $_ENV['BASE_URL']?>fotografo/nuevo-perfil" method="POST" class="formulario" enctype="multipart/form-data">
            <div class="contenido-formulario">
                <h3>Añadir informacion</h3>
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="data[nombre]" id="nombre" placeholder="Nombre completo">
                </div>
                <div class="campo">
                    <label for="url">Foto</label>
                    <input type="file" name="url" id="password">
                </div>
                <div class="campo">
                    <label for="descripcion">Descripcion</label>
                    <textarea name="data[descripcion]" id="descripcion" placeholder="Escriba una breve descripcion de usted"></textarea>
                </div>
            </div>
            <input type="submit" value="Añadir">
        </form>
    </div>
</div>

<?php 
    incluirTemplate('footer');
?>

<?php endif; ?>
