<?php if( isset ($_SESSION['admin']) === true): ?>

<?php 
    include_once __DIR__."/../../includes/funciones.php";
    incluirTemplate('header');
?>

<?php include_once __DIR__."/../../includes/alertas.php"; ?>

<div class="container-formulario-admi">

    <div class="container-formulario-verde-admi">
        <form action="<?= $_ENV['BASE_URL']?>categoria/registrar" method="POST" class="formulario" enctype="multipart/form-data">
            <div class="contenido-formulario-admi">
                <h3>Añadir categoria</h3>
                <div class="campo-admi">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="data[nombre]" id="nombre">
                </div>
                <div class="campo-admi">
                    <label for="imagen">Foto</label>
                    <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">
                </div>
                <input type="submit" value="Añadir">
            </div>
        </form>
    </div> 

    <div class="container-formulario-verde-admi">
        <form action="<?= $_ENV['BASE_URL']?>fotografo/buscar" method="POST" class="formulario">
            <div class="contenido-formulario-admi">
                <h3>Buscar fotografo</h3>
                <div class="campo-admi">
                    <input type="text" name="data[nombre]" placeholder="Nombre del fotografo">
                </div>
                <input type="submit" value="Buscar">
            </div>
        </form>
    </div> 

    <div class="container-formulario-verde-admi">
        <form action="<?= $_ENV['BASE_URL']?>fotografo/eliminar" method="POST" class="formulario">
            <div class="contenido-formulario-admi">
                <h3>Eliminar fotografo</h3>
                <div class="campo-admi">
                    <input type="text" name="data[nombre]" placeholder="Nombre del fotografo">
                </div>
                <input type="submit" value="Eliminar">
            </div>
        </form>
    </div>
</div>



    <?php 
    incluirTemplate('footer');
    ?>

<?php endif; ?>

<?php if( !isset($_SESSION['login']) && !isset ($_SESSION['admin'])): ?>
<?php 
    include_once __DIR__."/../../includes/funciones.php";
    incluirTemplate('header');
?>
<div class="no-admin">
    <p>Hola, parece que está intentando acceder a una zona restringida.</p>

    <p>Si usted no es el administrador de la página porfavor abandone la pagina donde se encuentra.</p>

    <p>En Meraki nos tomamos muy enserio la seguridad de nuestra web y de nuestros fotografos.</p>

    
</div>

<?php 
    incluirTemplate('footer');
?>

<?php  endif; ?>