<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuarios-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'equipos_id_equipo'); ?>
		<?php echo $form->textField($model,'equipos_id_equipo',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'equipos_id_equipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nick'); ?>
		<?php echo $form->textField($model,'nick',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nick'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pass'); ?>
		<?php echo $form->passwordField($model,'pass',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pass'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'personaje'); ?>
		<?php echo $form->textField($model,'personaje'); ?>
		<?php echo $form->error($model,'personaje'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nivel'); ?>
		<?php echo $form->textField($model,'nivel',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'nivel'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->