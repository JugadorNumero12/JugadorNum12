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
	  	<td align="left"><input type = 'radio' name ='pers' value= 'animadora'
	  		<?PHP print $animadora_status; ?> >Animadora
	  	</td>
	  	<td align="center"><input type = 'radio' name ='pers' value= 'empresario'
	  		<?PHP print $empresario_status; ?> >Empresario
	  	</td>
	  	<td align="right"><input type = 'radio' name ='pers' value= 'ultra' 
	  		<?PHP print $ultra_status; ?> >Ultra
	  	</td>
	  </tr>

	  <tr>
	   	<td align="left"><span>Equipos disponibles</span></td>
	  	<td>
	  		<select name='ocup'>
	  		<option>Elige un equipo</option>
	  		<?php foreach ( $equipos as $equipo ): ?>
    				<option value= <?php echo $equipo['id_equipo']; ?>><li><?php echo $equipo['nombre']; ?></li></option>
			<?php endforeach; ?>
	  	</td></select>
	  </tr>

	  <tr><?php if($str!=0): ?>
	   	<td colspan="2" align="left"><span style="color:red">¡Debe escoger un personaje y un equipo!</span></td>
	  <?php endif; ?></tr>

	  <tr>
	    <td align="left"><input type = "submit" name = "registro" value = "REGISTRAR"></td>
	    <td align="center"><input type = "reset" name = "reiniciar" value = "REINICIAR"></td>
	    <td align="right">
	    	<a href="<?php echo Yii::app()->createUrl('/site/login', array());?>">
	    		<input type = "button" name = "cancelar" value = "CANCELAR">
	    	</a>
	    </td>
	  </tr>

	</table>

	<?php $this->endWidget(); ?>
