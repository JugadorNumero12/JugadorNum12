<?php
/* @var $this RegistroController */
?>


<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'usuarios-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>

<table cellspacing="5px">
	  <tr>
	    <td colspan="2" align="center"><span class="under">REGISTRO</span></td>
	  </tr>

	  <tr>
	    <td align="left"><?php echo $form->labelEx($modelo,'Nickname'); ?>:</td>
	    <td><?php echo $form->textField($modelo,'nuevo_nick'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($modelo,'nuevo_nick'); ?></td>
	  </tr>

	  <tr>
	    <td align="left"><?php echo $form->labelEx($modelo,'Correo Electrónico'); ?>:</td>
	    <td><?php echo $form->emailField($modelo,'nueva_email1'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($modelo,'nueva_email1'); ?></td>
	  </tr>

	  <tr>
	    <td align="left"><?php echo $form->labelEx($modelo,'Contrase&ntilde;a'); ?>:</td>
	    <td><?php echo $form->passwordField($modelo,'nueva_clave1'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($modelo,'nueva_clave1'); ?></td>
	  </tr>

	  <tr>
	    <td align="left"><?php echo $form->labelEx($modelo,'Repetir contrase&ntilde;a'); ?>:</td>
	    <td><?php echo $form->passwordField($modelo,'nueva_clave2'); ?></td>
	  </tr>
	  <tr>
	    <td colspan="2"><?php echo $form->error($modelo,'nueva_clave2'); ?></td>
	  </tr>

	  <tr>
	    <td align="left"><input type="radio" name="pers" value="anim">Animadora</td>
	    <td align="center"><input type="radio" name="pers" value="empres">Empresario</td>
	    <td align="right"><input type="radio" name="pers" value="ultra">Ultra</td>
	  </tr>

	  <tr>
	  	<td colspan="2" align="center"><select name="equipo" onchange="window.open(formulario1.destinos1.value);">
	  		<option>Elige un equipo</option>
	  		<?php foreach ( $equipos as $equipo ): ?>
    				<option><li><?php echo $equipo['nombre']; ?></li></option>
			<?php endforeach; ?>
	  	</td></select>
	  </tr>

	  <tr>
	    <td colspan="2" align="center"><?php echo CHtml::submitButton('REGISTRAR');?></td>
	  </tr>
	</table>

	<?php $this->endWidget(); ?>
