<?php
/* @var $this HabilidadesController */
/* @var $data Habilidades */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_habilidad')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_habilidad), array('view', 'id'=>$data->id_habilidad)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::encode($data->codigo); ?>
	<br />


</div>