<?php
/* @var modeloC */

?>

<!-- codigo HTML -->

<div class="cabecera-clasificacion"> <h1> CLASIFICACIÓN</h1> </div>

<div class="clasificacion"> <table cellspacing="0">
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
		<td> <a href=
									"<?php echo $this->createUrl( '/equipos/ver', 
									array('id_equipo' => $m->equipos_id_equipo) ); ?>">  

							<?php echo $m->equipos->nombre ?></td>
							</a>
		<td><?php echo $m->posicion ?></td>
		<td><?php echo $m->puntos ?></td>
		<td><?php echo $m->ganados ?></td>
		<td><?php echo $m->empatados ?></td>
		<td><?php echo $m->perdidos ?></td>
	</tr>
	<?php } ?>
	<tr></tr>
</table> </div>