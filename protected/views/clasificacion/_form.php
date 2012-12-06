<?php
/* @var $this ClasificacionController */
/* @var $model Clasificacion */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clasificacion-form',
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
		<?php echo $form->labelEx($model,'posicion'); ?>
		<?php echo $form->textField($model,'posicion',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'posicion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puntos'); ?>
		<?php echo $form->textField($model,'puntos',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'puntos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ganados'); ?>
		<?php echo $form->textField($model,'ganados',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'ganados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'empatados'); ?>
		<?php echo $form->textField($model,'empatados',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'empatados'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'perdidos'); ?>
		<?php echo $form->textField($model,'perdidos',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'perdidos'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->