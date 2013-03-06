<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP

?>

<!-- codigo HTML -->
<h3> INFORMACIÓN DEL PARTIDO</h3>

<table cellspacing="5px">
	<tr>
		<th>Hora del encuentro</th>
		<th>Ambiente</th>
	</tr> 
	<tr>
		<td align="center"><?php echo Yii::app()->format->formatDatetime($modeloP->hora) ?></td>
		<td align="center"><?php echo $modeloP->ambiente ?></td>
	</tr>
	<tr></tr>
</table>

<table cellspacing="5px">
	<tr>
		<th>Equipo local</th>
		<th>Nivel del equipo local</th>
		<th>Aforo del equipo local</th>
	</tr> 
	<tr>
		<td align="center"><?php echo $modeloL->nombre ?></td>
		<td align="center"><?php echo $modeloP->nivel_local ?></td>
		<td align="center"><?php echo $modeloP->aforo_local ?></td>
	</tr>
	<tr></tr>
</table>

<table cellspacing="5px">
	<tr>
		<th>Equipo visitante</th>
		<th>Nivel del equipo visitante</th>
		<th>Aforo del equipo visitante</th>
	</tr> 
	<tr>
		<td align="center"><?php echo $modeloV->nombre ?></td>
		<td align="center"><?php echo $modeloP->nivel_visitante ?></td>
		<td align="center"><?php echo $modeloP->aforo_visitante ?></td>
	</tr>
	<tr></tr>
</table>

<table cellspacing="5px">
	<tr>
		<th>Cr&oacute;nica del partido</th>
	</tr> 
	<tr>
		<td align="center"><?php echo $modeloP->cronica ?></td>
	</tr>
	<tr></tr>
</table>