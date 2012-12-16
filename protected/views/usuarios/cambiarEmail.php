<?php
/* @var $this UsuariosController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'email-form',
			    'enableAjaxValidation'=>true,
			    'enableClientValidation'=>false,
			  /*  'clientOptions'=>array(
					'validateOnSubmit'=>true,),*/
			    ));
 ?>

<table cellspacing="5px">
	  <tr>
	    <td colspan="2" align="center"><span class="under">CAMBIAR EMAIL</span></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($model,'Email actual'); ?>:</td>
	    <td><?php echo $form->emailField($model,'antigua_email'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'antigua_email'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($model,'Nuevo email'); ?>:</td>
	    <td><?php echo $form->emailField($model,'nueva_email1'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'nueva_email1'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($model,'Repetir nuevo email'); ?>:</td>
	    <td><?php echo $form->emailField($model,'nueva_email2'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'nueva_email2'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2" align="center"><?php echo CHtml::submitButton('Cambiar email');?></td>
	  </tr>
	</table>
	<?php $this->endWidget(); ?>