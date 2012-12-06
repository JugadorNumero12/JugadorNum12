<?php
/* @var $this EquiposController */
/* @var $model Equipos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'categoria'); ?>
		<?php echo $form->textField($model,'categoria',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'categoria'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'aforo_max'); ?>
		<?php echo $form->textField($model,'aforo_max',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'aforo_max'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'aforo_base'); ?>
		<?php echo $form->textField($model,'aforo_base',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'aforo_base'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nivel_equipo'); ?>
		<?php echo $form->textField($model,'nivel_equipo'); ?>
		<?php echo $form->error($model,'nivel_equipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'factor_ofensivo'); ?>
		<?php echo $form->textField($model,'factor_ofensivo',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'factor_ofensivo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'factor_defensivo'); ?>
		<?php echo $form->textField($model,'factor_defensivo',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'factor_defensivo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->