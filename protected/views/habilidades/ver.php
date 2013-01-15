<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP

//arraglar tipo

?>

<div class="envoltorio-ver-habilidad">

<h1>Habilidad: <?php echo $habilidad['nombre']; ?></h1>

<table>
	<tr>
		<td>Descripci&oacute;n: </td>
		<td><?php echo $habilidad['descripcion']; ?></td>
	</tr>
	<tr>
		<td>Tipo habilidad: </td>
		<td><?php echo ($habilidad['tipo']==Habilidades::TIPO_INDIVIDUAL) ? 'Individual' : 'Grupal' ?></td>
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
<a href="<?php echo $this->createUrl('/habilidades/index'); ?>">&larr; Habilidades</a>
</div>


<!-- codigo HTML -->