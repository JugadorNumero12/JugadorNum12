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
<div class="envoltorio-contenido-registro">
	<tr>
	    <td><h3>REGISTRO</h3></td>
	</tr>
<table>
	  <tr>
	    <td><?php echo $form->labelEx($modelo,'Nickname'); ?>:</td>
	    <td><?php echo $form->textField($modelo,'nuevo_nick'); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($modelo,'nuevo_nick'); ?></td>
	  </tr>

	  <tr>
	    <td><?php echo $form->labelEx($modelo,'Correo Electr&oacute;nico'); ?>:</td>
	    <td><?php echo $form->emailField($modelo,'nueva_email1'); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($modelo,'nueva_email1'); ?></td>
	  </tr>

	  <tr>
	    <td><?php echo $form->labelEx($modelo,'Contrase&ntilde;a'); ?>:</td>
	    <td><?php echo $form->passwordField($modelo,'nueva_clave1'); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($modelo,'nueva_clave1'); ?></td>
	  </tr>

	  <tr>
	    <td><?php echo $form->labelEx($modelo,'Repetir contrase&ntilde;a'); ?>:</td>
	    <td><?php echo $form->passwordField($modelo,'nueva_clave2'); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($modelo,'nueva_clave2'); ?></td>
	  </tr>

	 <!-- <tr>
	   	<td>Personajes disponibles</td>
	  </tr>

	  <tr>
	  	<td>
	  		<?php echo $form->labelEx($modelo,'Animadora'); ?>
	  			</td>
	  	<td>
	  		<?php echo $form->labelEx($modelo,'Empresario'); ?>
	  		</td>
	  	<td>
	  		<?php echo $form->labelEx($modelo,'Ultra'); ?>
	  		</td>
	  </tr>
	  <tr>
	  	<td>
	  		<?php echo CHtml::radioButton('pers', $animadora_status,array('value'=>'animadora','uncheckValue'=>null)); ?>
	  	</td>
	  	<td>
	  		<?php echo CHtml::radioButton('pers', $empresario_status,array('value'=>'empresario','uncheckValue'=>null)); ?>
	  	</td>
	  	<td>
	  		<?php echo CHtml::radioButton('pers', $ultra_status,array('value'=>'ultra','uncheckValue'=>null)); ?>
	  	</td>
	  </tr>

	  <tr>
	   	<td >Equipos disponibles</td>
	   	<td >
	   		<?php echo CHtml::dropDownList('ocup', $seleccionado, $equipos); ?>
	   	</td>
	  </tr>

	  <tr><?php if($error): ?>
	   	<td>¡Debe escoger un personaje y un equipo!</td>
	  <?php endif; ?></tr>-->

	  <tr>
	    <td >
	    	<?php echo CHtml::submitButton('Siguiente',array(/*'submit'=>array('/registro/equipo'),*/'class'=>"button large black"));?>
	    </td>
	    <td >
	    	<?php echo CHtml::resetButton('REINICIAR',array('class'=>"button large black"));?>
	    </td>
	  </tr>

	</table>
</div>

	<?php $this->endWidget(); ?>
