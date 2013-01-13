<?php
/* @var $this UsuariosController */
/* @var $model LoginForm */
/* @var $form CActiveForm */
?>
<table cellspacing="5px">
	<tr></tr>
	
	  <tr>
	    <td colspan="2" align="center"><span class="under">DATOS DE USUARIO</span></td>
	  </tr>
	  <tr></tr>
	  <tr>
	  	<th>Nick : </th>
	  	<td><?php echo $modelo['nick'] ?></td>
	  </tr>
	  <tr>
	  	<th>eMail : </th>
	  	<td><?php echo $modelo['email'] ?></td>
	  </tr>

	  <tr>
	    <td colspan="2">
	    	<?php echo CHtml::submitButton('Cambiar contraseña', array('submit' => array('cambiarClave')));?>
	    </td>
	    
	    <td colspan="2">
	    	<?php echo CHtml::submitButton('Cambiar email', array('submit' => array('cambiarEmail')));?>
	    </td>
	  </tr>

	  <tr></tr>
	 
</table>