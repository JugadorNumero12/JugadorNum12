<div class="encabezado"> <h1>Mis Notificaciones</h1> </div>

<?php 
 echo CHtml::button('BORRAR_TODAS', array('submit' => array('notificaciones/eliminarNotificaciones'),'class'=>"button small black"));
foreach ( $notificaciones as $notificacion ){ ?>
    
    <div class="lista-notificaciones"> 
    	<li>
    		<div class="imagen-notificaciones"> <img alt="imagen notificacion" src="<?php echo Yii::app()->BaseUrl ?>/<?php echo $notificacion['imagen']; ?>"
						     width="64" height="64"/> </div>
        	<div class="contenido-notificaciones">
        		<p><?php echo $notificacion['mensaje'];?> </p>
        		<div class="fecha-notificaciones"><?php echo Yii::app()->dateFormatter->formatDateTime($notificacion['fecha'], 'medium', 'short'); ?></div>
       	 		<div class="boton-notificaciones"><?php echo CHtml::button('Leer', array('submit' => array('notificaciones/leer', 'id'=>$notificacion['id_notificacion']),'class'=>"button small black"));?></div>
       	 	</div>
    	</li>
    </div>    
 <?php } ?>
