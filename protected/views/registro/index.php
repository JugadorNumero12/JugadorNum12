<?php
/* @var $this RegistroController */
/* @var $modelo LoginForm */
/* @var $form CActiveForm  */
/* @var $animadora (radio checked/unchecked)*/
/* @var $empresario (radio checked/unchecked)*/
/* @var $ultra (radio checked/unchecked) */
/* @var $error (personaje checked && equipo selected)*/
/* @var $seleccionado (equipo selected)*/
/* @var $equipos (array con los equipos de la DB) */

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
	    <td align="left"><?php echo $form->labelEx($modelo,'Correo Electr&oacute;nico'); ?>:</td>
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
	   	<td colspan="2" align="center"><span>Personajes disponibles</span></td>
	  </tr>

	  <tr>
	  	<td align="left">
	  		<?php echo $form->labelEx($modelo,'Animadora'); ?>
	  		<?php echo CHtml::radioButton('pers', $animadora_status,array('value'=>'animadora','uncheckValue'=>null)); ?>
	  	</td>
	  	<td align="center">
	  		<?php echo $form->labelEx($modelo,'Empresario'); ?>
	  		<?php echo CHtml::radioButton('pers', $empresario_status,array('value'=>'empresario','uncheckValue'=>null)); ?>
	  	</td>
	  	<td align="right">
	  		<?php echo $form->labelEx($modelo,'Ultra'); ?>
	  		<?php echo CHtml::radioButton('pers', $ultra_status,array('value'=>'ultra','uncheckValue'=>null)); ?>
	  	</td>
	  </tr>

	  <tr>
	   	<td align="left"><span>Equipos disponibles</span></td>
	   	<td colspan="2" align="center">
	   		<?php echo CHtml::dropDownList('ocup', $seleccionado, $equipos); ?>
	   	</td>
	  </tr>

	  <tr><?php if($error): ?>
	   	<td colspan="2" align="left"><span style="color:red">¡Debe escoger un personaje y un equipo!</span></td>
	  <?php endif; ?></tr>

	  <tr>
	    <td align="left">
	    	<?php echo CHtml::submitButton('REGISTRAR');?>
	    </td>
	    <td colspan="2" align="center">
	    	<?php echo CHtml::resetButton('REINICIAR');?>
	    </td>
	  </tr>

	</table>

	<?php $this->endWidget(); ?>
