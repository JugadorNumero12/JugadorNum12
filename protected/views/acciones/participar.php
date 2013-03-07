<?php
// @var $habilidad
// @var $datosAccion

// codigo PHP

?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'acciones-grupales-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
				'validateOnSubmit'=>true,),
			    ));
?>

<div class="encabezado-participar"> <h1>Participar en: <?php echo $habilidad['nombre']; ?> </h1> </div>
<table cellspacing="5px">
	  <tr>
	    <td ><b><?php echo $form->labelEx($participacion,'Dinero'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'dinero_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($participacion,'dinero_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td ><b><?php echo $form->labelEx($participacion,'Animo'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'animo_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td ><?php echo $form->error($participacion,'animo_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td ><b><?php echo $form->labelEx($participacion,'Influencia'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'influencia_nueva'); ?></td>
	  </tr>
	  <tr>
	    <td ><?php echo $form->error($participacion,'influencia_nueva'); ?></td>
	  </tr>
</table>
	<td><?php echo CHtml::submitButton('Participar',array('class'=>"button large black")); ?></td>
	<td><?php echo CHtml::button('Volver', array('class'=>"button large black", 'onclick' => "history.go(-1);return false")); ?></td>

<?php $this->endWidget(); ?>
