<?php
/* @var modeloC */

?>

<!-- codigo HTML -->

<div class="clasificacion"> 
	<table class="tabla-general">
	<tr>
		<th colspan="7">CLASIFICACI&Oacute;N</th>
	</tr> 
	<tr>
		<th>Posici&oacute;n</th>
		<th>Equipo</th>
		<th>Puntos</th>
		<th>Ganados</th>
		<th>Empatados</th>
		<th>Perdidos</th>
		<th>Dif. de goles</th>
	</tr> 
	<?php $alt = 1;
	foreach ($modeloC as $filaClasificacion) { ?>
	<tr <?php if (Yii::app()->user->usAfic == $filaClasificacion->equipos_id_equipo) { echo 'class="remarcado"'; } ?>>
		<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>><?php echo $filaClasificacion->posicion ?></td>
		<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>> <a href="<?php echo $this->createUrl( '/equipos/ver', array('id_equipo' => $filaClasificacion->equipos_id_equipo) ); ?>">  
				<?php echo $filaClasificacion->equipos->nombre ?>
			 </a>
		</td>
		<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>><?php echo $filaClasificacion->puntos ?></td>
		<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>><?php echo $filaClasificacion->ganados ?></td>
		<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>><?php echo $filaClasificacion->empatados ?></td>
		<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>><?php echo $filaClasificacion->perdidos ?></td>
		<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>><?php echo $filaClasificacion->diferencia_goles ?></td>
	</tr>
	<?php ($alt === 0)? $alt = 1  : $alt = 0;} ?>
	</table> 
</div>