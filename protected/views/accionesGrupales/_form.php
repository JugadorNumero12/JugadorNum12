<?php
/* @var $this AccionesGrupalesController */
/* @var $model AccionesGrupales */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'acciones-grupales-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'usuarios_id_usuario'); ?>
		<?php echo $form->textField($model,'usuarios_id_usuario',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'usuarios_id_usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'habilidades_id_habilidad'); ?>
		<?php echo $form->textField($model,'habilidades_id_habilidad',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'habilidades_id_habilidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equipos_id_equipo'); ?>
		<?php echo $form->textField($model,'equipos_id_equipo',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'equipos_id_equipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'influencias_acc'); ?>
		<?php echo $form->textField($model,'influencias_acc',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'influencias_acc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'animo_acc'); ?>
		<?php echo $form->textField($model,'animo_acc',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'animo_acc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dinero_acc'); ?>
		<?php echo $form->textField($model,'dinero_acc',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'dinero_acc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jugadores_acc'); ?>
		<?php echo $form->textField($model,'jugadores_acc',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'jugadores_acc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'finalizacion'); ?>
		<?php echo $form->textField($model,'finalizacion',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'finalizacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->