<?php
/* @var $this AccionesGrupalesController */
/* @var $data AccionesGrupales */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_accion_grupal')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_accion_grupal), array('view', 'id'=>$data->id_accion_grupal)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuarios_id_usuario')); ?>:</b>
	<?php echo CHtml::encode($data->usuarios_id_usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('habilidades_id_habilidad')); ?>:</b>
	<?php echo CHtml::encode($data->habilidades_id_habilidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipos_id_equipo')); ?>:</b>
	<?php echo CHtml::encode($data->equipos_id_equipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('influencias_acc')); ?>:</b>
	<?php echo CHtml::encode($data->influencias_acc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('animo_acc')); ?>:</b>
	<?php echo CHtml::encode($data->animo_acc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dinero_acc')); ?>:</b>
	<?php echo CHtml::encode($data->dinero_acc); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('jugadores_acc')); ?>:</b>
	<?php echo CHtml::encode($data->jugadores_acc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finalizacion')); ?>:</b>
	<?php echo CHtml::encode($data->finalizacion); ?>
	<br />

	*/ ?>

</div>