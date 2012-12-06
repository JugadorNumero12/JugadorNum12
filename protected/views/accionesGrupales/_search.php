<?php
/* @var $this AccionesGrupalesController */
/* @var $model AccionesGrupales */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_accion_grupal'); ?>
		<?php echo $form->textField($model,'id_accion_grupal',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuarios_id_usuario'); ?>
		<?php echo $form->textField($model,'usuarios_id_usuario',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'habilidades_id_habilidad'); ?>
		<?php echo $form->textField($model,'habilidades_id_habilidad',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'equipos_id_equipo'); ?>
		<?php echo $form->textField($model,'equipos_id_equipo',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'influencias_acc'); ?>
		<?php echo $form->textField($model,'influencias_acc',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'animo_acc'); ?>
		<?php echo $form->textField($model,'animo_acc',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dinero_acc'); ?>
		<?php echo $form->textField($model,'dinero_acc',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jugadores_acc'); ?>
		<?php echo $form->textField($model,'jugadores_acc',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'finalizacion'); ?>
		<?php echo $form->textField($model,'finalizacion',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->