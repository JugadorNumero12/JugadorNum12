<?php
/* @var $this PartidosController */
/* @var $model Partidos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'partidos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'equipos_id_equipo_1'); ?>
		<?php echo $form->textField($model,'equipos_id_equipo_1',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'equipos_id_equipo_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equipos_id_equipo_2'); ?>
		<?php echo $form->textField($model,'equipos_id_equipo_2',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'equipos_id_equipo_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora'); ?>
		<?php echo $form->textField($model,'hora',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'hora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cronica'); ?>
		<?php echo $form->textArea($model,'cronica',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cronica'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->