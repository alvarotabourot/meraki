
<?php if(isset($alertas)): ?>

    <?php 
        foreach($alertas as $key => $mensajes):
            foreach ($mensajes as $mensaje):
    ?>
        <div class="alerta <?= $key ?>">
            <?= $mensaje ?>
        </div>
    <?php
            endforeach;
        endforeach;
    ?>
<?php endif; ?>