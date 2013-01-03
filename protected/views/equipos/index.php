<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP

?>

<!-- codigo HTML -->

<table cellspacing="5px">
	<tr>
		<th>Equipo</th>
		<th>Posicion</th>
		<th>Puntos</th>
		<th>Ganados</th>
		<th>Empatados</th>
		<th>Perdidos</th>
	</tr> 
	<?php foreach ($modeloC as $m ) { ?>
	<tr>
		<td align="center"><?php $modeloEquipo = Equipos:: model()->findByPk($m->equipos_id_equipo);
								 echo $modeloEquipo['nombre']?></td>
		<td align="center"><?php echo $m->posicion ?></td>
		<td align="center"><?php echo $m->puntos ?></td>
		<td align="center"><?php echo $m->ganados ?></td>
		<td align="center"><?php echo $m->empatados ?></td>
		<td align="center"><?php echo $m->perdidos ?></td>
	</tr>
	<?php } ?>
	<tr></tr>
</table>