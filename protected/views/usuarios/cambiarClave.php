<?php
/* @var $this UsuariosController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'clave-form',
			    'enableAjaxValidation'=>true,
			    'enableClientValidation'=>false,
			  /*  'clientOptions'=>array(
					'validateOnSubmit'=>true,),*/
			    ));
 ?>

<table cellspacing="5px">
	  <tr>
	    <td colspan="2" align="center"><span class="under">CAMBIAR CONTRASE&Ntilde;A</span></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($model,'Contraseña actual'); ?>:</td>
	    <td><?php echo $form->passwordField($model,'antigua_clave'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'antigua_clave'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($model,'Nueva Contraseña'); ?>:</td>
	    <td><?php echo $form->passwordField($model,'nueva_clave1'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'nueva_clave1'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo $form->labelEx($model,'Repetir nueva contraseña'); ?>:</td>
	    <td><?php echo $form->passwordField($model,'nueva_clave2'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'nueva_clave2'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2" align="center"><?php echo CHtml::submitButton('Cambiar contraseña');?></td>
	  </tr>
	</table>
	<?php $this->endWidget(); ?>
