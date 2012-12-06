<?php
/* @var $this PartidosController */
/* @var $model Partidos */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_partido'); ?>
		<?php echo $form->textField($model,'id_partido',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'equipos_id_equipo_1'); ?>
		<?php echo $form->textField($model,'equipos_id_equipo_1',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'equipos_id_equipo_2'); ?>
		<?php echo $form->textField($model,'equipos_id_equipo_2',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hora'); ?>
		<?php echo $form->textField($model,'hora',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cronica'); ?>
		<?php echo $form->textArea($model,'cronica',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->