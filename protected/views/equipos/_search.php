<?php
/* @var $this EquiposController */
/* @var $model Equipos */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_equipo'); ?>
		<?php echo $form->textField($model,'id_equipo',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'categoria'); ?>
		<?php echo $form->textField($model,'categoria',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aforo_max'); ?>
		<?php echo $form->textField($model,'aforo_max',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aforo_base'); ?>
		<?php echo $form->textField($model,'aforo_base',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nivel_equipo'); ?>
		<?php echo $form->textField($model,'nivel_equipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'factor_ofensivo'); ?>
		<?php echo $form->textField($model,'factor_ofensivo',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'factor_defensivo'); ?>
		<?php echo $form->textField($model,'factor_defensivo',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->