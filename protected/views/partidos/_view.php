<?php
/* @var $this PartidosController */
/* @var $data Partidos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_partido')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_partido), array('view', 'id'=>$data->id_partido)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipos_id_equipo_1')); ?>:</b>
	<?php echo CHtml::encode($data->equipos_id_equipo_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipos_id_equipo_2')); ?>:</b>
	<?php echo CHtml::encode($data->equipos_id_equipo_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora')); ?>:</b>
	<?php echo CHtml::encode($data->hora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cronica')); ?>:</b>
	<?php echo CHtml::encode($data->cronica); ?>
	<br />


</div>