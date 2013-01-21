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
	    <td align="center"><b><?php echo $form->labelEx($participacion,'Dinero'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'dinero_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($participacion,'dinero_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><b><?php echo $form->labelEx($participacion,'Animo'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'animo_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($participacion,'animo_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><b><?php echo $form->labelEx($participacion,'Influencia'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'influencia_nueva'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($participacion,'influencia_nueva'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2" align="center"><?php echo CHtml::submitButton('Participar'); ?></td>
	  </tr>
</table>

<?php $this->endWidget(); ?>
