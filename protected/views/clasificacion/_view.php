<?php
/* @var $this ClasificacionController */
/* @var $data Clasificacion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipos_id_equipo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->equipos_id_equipo), array('view', 'id'=>$data->equipos_id_equipo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posicion')); ?>:</b>
	<?php echo CHtml::encode($data->posicion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('puntos')); ?>:</b>
	<?php echo CHtml::encode($data->puntos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ganados')); ?>:</b>
	<?php echo CHtml::encode($data->ganados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empatados')); ?>:</b>
	<?php echo CHtml::encode($data->empatados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('perdidos')); ?>:</b>
	<?php echo CHtml::encode($data->perdidos); ?>
	<br />


</div>