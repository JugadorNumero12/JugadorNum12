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

<h1>Participar en la acción grupal: <?php echo $habilidad['nombre']; ?></h1>
<table cellspacing="5px">
	  <tr>
	    <td colspan="2" align="center"><span class="under">Aportar recursos</span></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($participacion,'Dinero'); ?>:</td>
	    <td><?php echo $form->textField($participacion,'dinero_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($participacion,'dinero_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($participacion,'Animo'); ?>:</td>
	    <td><?php echo $form->textField($participacion,'animo_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($participacion,'animo_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($participacion,'Influencia'); ?>:</td>
	    <td><?php echo $form->textField($participacion,'influencia_nueva'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($participacion,'influencia_nueva'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2" align="center"><?php echo CHtml::submitButton('Participar');?></td>
	  </tr>
	</table>

<?php $this->endWidget(); ?>
