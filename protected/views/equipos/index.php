<?php
/* @var modeloC */

?>

<!-- codigo HTML -->

<div class="cabecera-clasificacion"> <h1> CLASIFICACI&Oacute;N</h1> </div>

<div class="clasificacion"> <table cellspacing="0">
	<tr>
		<th>Equipo</th>
		<th>Posici&oacute;n</th>
		<th>Puntos</th>
		<th>Ganados</th>
		<th>Empatados</th>
		<th>Perdidos</th>
		<th>Diferencia de goles</th>
	</tr> 
	<?php foreach ($modeloC as $filaClasificacion) { ?>
	<tr <?php if (Yii::app()->user->usAfic == $filaClasificacion->equipos_id_equipo) { echo 'class="remarcado"'; } ?>>
		<td> <a href="<?php echo $this->createUrl( '/equipos/ver', array('id_equipo' => $filaClasificacion->equipos_id_equipo) ); ?>">  
				<?php echo $filaClasificacion->equipos->nombre ?>
			 </a>
		</td>
		<td><?php echo $filaClasificacion->posicion ?></td>
		<td><?php echo $filaClasificacion->puntos ?></td>
		<td><?php echo $filaClasificacion->ganados ?></td>
		<td><?php echo $filaClasificacion->empatados ?></td>
		<td><?php echo $filaClasificacion->perdidos ?></td>
		<td><?php echo $filaClasificacion->diferencia_goles ?></td>
	</tr>
	<?php } ?>
	<tr></tr>
</table> </div>