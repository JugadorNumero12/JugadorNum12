<?php
/* @var $this EquiposController */
/* @var $data Equipos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_equipo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_equipo), array('view', 'id'=>$data->id_equipo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('categoria')); ?>:</b>
	<?php echo CHtml::encode($data->categoria); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aforo_max')); ?>:</b>
	<?php echo CHtml::encode($data->aforo_max); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aforo_base')); ?>:</b>
	<?php echo CHtml::encode($data->aforo_base); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nivel_equipo')); ?>:</b>
	<?php echo CHtml::encode($data->nivel_equipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('factor_ofensivo')); ?>:</b>
	<?php echo CHtml::encode($data->factor_ofensivo); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('factor_defensivo')); ?>:</b>
	<?php echo CHtml::encode($data->factor_defensivo); ?>
	<br />

	*/ ?>

</div>