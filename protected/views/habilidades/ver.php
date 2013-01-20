<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP

?>

<div class="envoltorio-todo">

	<h1>Habilidad: <?php echo $habilidad['nombre']; ?></h1>
	<div class = "tabla">
		<table>
			<tr>
				<td>Descripci&oacute;n: </td>
				<td><?php echo $habilidad['descripcion']; ?></td>
			</tr>
			<tr>
				<td>Tipo habilidad: </td>
				<td><?php switch ($habilidad['tipo']){
					case Habilidades::TIPO_INDIVIDUAL:
						echo 'Individual';
					  break;
					case Habilidades::TIPO_GRUPAL:
					  	echo 'Grupal';
					  break;
					case Habilidades::TIPO_PARTIDO:
					  	echo 'De Partido';
					  break;
					case Habilidades::TIPO_PASIVA:
					  	echo 'Pasiva';
					  break;
				} ?></td>
			</tr>
			<tr>
				<td>Coste: </td>
			</tr>
			<tr>
				<td>Dinero: </td>
				<td><?php echo $habilidad['dinero']; ?></td>
			</tr>
			<tr>
				<td>&Aacute;nimo: </td>
				<td><?php echo $habilidad['animo']; ?></td>
			</tr>
			<tr>
				<td>Influencia: </td>
				<td><?php echo $habilidad['influencias']; ?></td>
			</tr>
		</table>
	</div>

	<div class = "boton">
	 <tr>
	    <td >
	    	<?php echo CHtml::submitButton('Habilidades',array('submit' => array('/habilidades/index'),'class'=>"button verysmall black"));?>
	    </td>
	  </tr>
	</div>
</div>


<!-- codigo HTML -->