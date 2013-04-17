<div class="envoltorio">
<div class="encabezado"> <h1>Mis Notificaciones</h1> </div>

<?php 
foreach ( $notificaciones as $notificacion ){ ?>
    
    <div class="descripcion-accion"> 
        <?php echo $notificacion['mensaje'];?> 
        <?php echo Yii::app()->dateFormatter->formatDateTime($notificacion['fecha'], 'medium', 'short'); ?>
        <?php echo CHtml::button('Leer', array('submit' => array('notificaciones/leer', 'id'=>$notificacion['id_notificacion'], 'url'=>$notificacion['url']),'class'=>"button small black"));?>
    </div>    
 <?php } ?>
</div>