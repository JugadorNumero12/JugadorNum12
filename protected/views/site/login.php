<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?> 	
	<table cellspacing="5px">
	  <tr>
	    
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($model,'Usuario'); ?>:</td>
	    <td><?php echo $form->textField($model,'username'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'username'); ?></td>
	  </tr>
	  <tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($model,'Clave'); ?>:</td>
	    <td><?php echo $form->passwordField($model,'password'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'password'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2" align="center"><?php echo CHtml::submitButton('Entrar',array('class'=>"boton-negro"));?></td>
	  </tr>
	</table>
	<?php $this->endWidget(); ?>