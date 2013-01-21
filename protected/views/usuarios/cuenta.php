<?php
/* @var $this UsuariosController */
/* @var $model LoginForm */
/* @var $form CActiveForm */
?>
<div class="envoltorio-cuenta">
<table class="tabla-cuenta">
	  <tr>
	    <h1><?php echo 'Cuenta del usuario'?></h1>
	  </tr>
	  
	  <tr>
	  	<th><?php echo 'Nick : '?></th>
	  	<td><?php echo $modelo['nick'] ?></td>
	  </tr>

	  <tr>
	  	<th><?php echo 'eMail : '?></th>
	  	<td><?php echo $modelo['email'] ?></td>
	  </tr>

	  <tr>
	    <td>
	    	<?php echo CHtml::submitButton('Cambiar contraseña', array('submit' => array('cambiarClave'),'class'=>"button small black"));?>
	    </td>
	    <td>
	    	<?php echo CHtml::submitButton('Cambiar email', array('submit' => array('cambiarEmail'),'class'=>"button small black"));?>
	    </td>
	  </tr>
	 
</table>
</div>