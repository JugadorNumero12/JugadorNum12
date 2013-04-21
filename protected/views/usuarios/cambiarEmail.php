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
		    <td align="center"><span class="cambio">CAMBIO DE EMAIL</span></td>
		  </tr>
		  <tr>
		    <td align="center"><?php echo $form->emailField($model,'antigua_email', array('placeholder' => 'Email actual', 'size' => 50)); ?></td>
		  </tr>
		  <tr>
		    <td><?php echo $form->error($model,'antigua_email'); ?></td>
		  </tr>
		  <tr>
		    <td align="center"><?php echo $form->emailField($model,'nueva_email1', array('placeholder' => 'Nuevo email', 'size' => 50)); ?></td>
		  </tr>
		  <tr>
		    <td><?php echo $form->error($model,'nueva_email1'); ?></td>
		  </tr>
		  <tr>
		    <td align="center"><?php echo $form->emailField($model,'nueva_email2', array('placeholder' => 'Repita nuevo email', 'size' => 50)); ?></td>
		  </tr>
		  <tr>
		    <td><?php echo $form->error($model,'nueva_email2'); ?></td>
		  </tr>
		  <tr>
		    <td align="center"><?php echo CHtml::submitButton('Cambiar email');?></td>
		  </tr>
	</table>
</div>
<?php $this->endWidget(); ?>