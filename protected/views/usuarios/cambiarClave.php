<?php
/* @var $this UsuariosController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'usuarios-form',
			    'enableAjaxValidation'=>true,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>
<div id="form-cambio">
	<table cellspacing="5px">
	  <tr>
	    <td align="center" colspan="2"><span class="cambio">CAMBIO DE CONTRASE&Ntilde;A</span></td>
	  </tr>
	  <tr>
	    <td align="center" colspan="2"><?php echo $form->passwordField($model,'antigua_clave', array('placeholder' => 'Clave actual', 'size' => 30)); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'antigua_clave'); ?></td>
	  </tr>
	  <tr>
	    <td align="center" colspan="2"><?php echo $form->passwordField($model,'nueva_clave1', array('placeholder' => 'Nueva clave', 'size' => 30)); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'nueva_clave1'); ?></td>
	  </tr>
	  <tr>
	    <td align="center" colspan="2"><?php echo $form->passwordField($model,'nueva_clave2', array('placeholder' => 'Repita nueva clave', 'size' => 30)); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($model,'nueva_clave2'); ?></td>
	  </tr>
	  <tr>
	    <td align="center"><?php echo CHtml::button('Volver',array('onclick' => 'js:document.location.href="'.$this->createUrl('usuarios/perfil').'"','class'=>"button large black"));?></td>
	    <td align="center"><?php echo CHtml::submitButton('Cambiar contraseña');?></td>
	  </tr>
	</table>
</div>

<?php $this->endWidget(); ?>