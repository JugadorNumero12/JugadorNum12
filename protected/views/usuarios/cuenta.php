<?php
/* @var ejemplo de variable dada por el controlador */
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
			<a href="<?php echo Yii::app()->createUrl('/usuarios/cambiarClave', array());?>">
	    		<input type = "button" name = "clave" value = "Cambiar Clave">
	    	</a>	    
	    </td>
	    
	    <td colspan="2">
	    	<a href="<?php echo Yii::app()->createUrl('/usuarios/cambiarEmail', array());?>">
	    		<input type = "button" name = "email" value = "Cambiar Email">
	    	</a>
	    </td>
	  </tr>

	  <tr></tr>
	 
</table>