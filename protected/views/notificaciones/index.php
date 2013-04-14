<div class="envoltorio">
<div class="encabezado"> <h1>Mis Notificaciones</h1> </div>

<?php 
foreach ( $notificaciones as $notificacion ){ ?>
    
    <div class="descripcion-accion"> 
        <?php echo $notificacion['notificacion']['mensaje'];?> 
        <?php echo Yii::app()->dateFormatter->formatDateTime($notificacion['notificacion']['fecha'], 'medium', 'short'); ?>
        <?php if($notificacion['leido'] == 1) echo "LEIDO"; else echo "NO LEIDO";?>
        <?php echo CHtml::button('Leer', array('submit' => array('notificaciones/leer', 'id'=>$notificacion['notificacion']['id_notificacion'], 'url'=>$notificacion['notificacion']['url']),'class'=>"button small black"));?>
    </div>    
 <?php } ?>
</div>