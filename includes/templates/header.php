<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meraki</title>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL']?>/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gluten:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.zoom').hover(function() {
                $(this).addClass('transition');
            }, function() {
                $(this).removeClass('transition');
            });
        });

    </script>
</head>
<body>
    <div class="container">
        <div class="content">
            <header class="header <?php echo $inicio ? 'inicio' : '' ?>">
                <div class="contenedor contenido-header">
                    <div class="barra">
                        <a href="<?= $_ENV['BASE_URL']?>"><h1>MERAKI</h1></a>
                        <div class="derecha">
                            <nav class="navegacion">
                                <?php if( empty($_SESSION['login']) ): ?>
                                    <a href="<?= $_ENV['BASE_URL']?>login">Inicio sesion</a>

                                    <?php else : ?>
                                        <a href="<?= $_ENV['BASE_URL']?>logout">Cerrar sesion</a>
                                    
                                <?php endif; ?>

                                <?php if( isset($_SESSION['admin']) ): ?>
                                    <a href="<?= $_ENV['BASE_URL']?>admi/panel">Panel admi</a> 
                                <?php endif; ?>

                                <?php if( isset($_SESSION['fotografo']) ): ?>
                                    <a href="<?= $_ENV['BASE_URL']?>fotografo/perfil/<?= $_SESSION['id']?>">Mi perfil</a> 
                                <?php endif; ?>

                                <a href="<?= $_ENV['BASE_URL']?>nosotros">Sobre nosotros</a>
                                <a href="#contacto">Contacto</a>
                            </nav>
                        </div>
                    </div>
                    <div class="pieheader">
                        <p>La esencia de ti mismo, reflejado en lo que haces</p>
                    </div>
                </div>
            </header>
    
