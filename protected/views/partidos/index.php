
<?php
/*
 * @var lista_partidos: lista completa de partidos
 * @var equipo_usuario: id del equipo del usuario
 * @var proximo_partido: id del proximo partido del equipo del usuario
 */
?>
<div class="calendario"> 
	<table class="tabla-general">
		<tr>
			<th colspan="8">CALENDARIO DE PARTIDOS</th>
		</tr> 

	<?php foreach ($lista_partidos as $grupo) 
	{ ?>
		<tr>
			<th class="titulo-jornada" colspan="4">Jornada <?php echo $grupo[0]['jornada']; ?></th>
			<th class="titulo-jornada" colspan="4">Jornada <?php echo $grupo[1]['jornada']; ?></th>
		</tr>	
		<tr>
			<th class="cabecera-jornada">Local</th>
			<th class="cabecera-jornada">Visitante</th>
			<th class="cabecera-jornada">Hora</th>
			<th class="cabecera-jornada">Informaci&oacute;n</th>
			<th class="cabecera-jornada">Local</th>
			<th class="cabecera-jornada">Visitante</th>
			<th class="cabecera-jornada">Hora</th>
			<th class="cabecera-jornada">Informaci&oacute;n</th>
		</tr>
		<?php 
		$numP = count($grupo[0]['partidos']); 
		$alt = 1;	
		for ($f = 0; $f < $numP; $f++) { 
			$partido = $grupo[0]['partidos'][$f];
			$partido2 = $grupo[1]['partidos'][$f];?>
		<tr>
			<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>>
				<a href="<?php echo $this->createUrl('/equipos/ver', array('id_equipo'=>$partido->local->id_equipo) )?>">
					<?php echo $partido->local->nombre ?> 
				</a>
			</td>
			
			<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>>
				<a href="<?php echo $this->createUrl('/equipos/ver', array('id_equipo'=>$partido->visitante->id_equipo) )?>">
					<?php echo $partido->visitante->nombre ?>
				</a>
			</td>
			
			<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>>
				<?php echo date('Y-m-d G:i', $partido->hora)?>
			</td>

			<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>>
				<?php if($partido->id_partido == $proximo_partido->id_partido &&  $proximo_partido->turno >= $primer_turno+1 && $proximo_partido->turno < $ultimo_turno+1) { ?>
					<a href="<?php echo Yii::app()->createUrl( '/partidos/asistir?id_partido=' .$partido->id_partido ) ?>" class="button">Asistir</a>
				<?php } else if ($partido->id_partido == $proximo_partido->id_partido &&  $proximo_partido->turno == $primer_turno) {?>
					<a href="<?php echo Yii::app()->createUrl( '/partidos/previa?id_partido=' .$partido->id_partido ) ?>" class="button">Previa</a>
				<?php } else if ($partido->turno == $ultimo_turno+1 ){ ?>
					<a href="<?php echo Yii::app()->createUrl( '/partidos/previa?id_partido=' .$partido->id_partido ) ?>" class="button">Cr&oacute;nica</a>

				<?php } ?>
			</td>

			<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>>
				<a href="<?php echo $this->createUrl('/equipos/ver', array('id_equipo'=>$partido2->local->id_equipo) )?>">
					<?php echo $partido2->local->nombre ?> 
				</a>
			</td>
			
			<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>>
				<a href="<?php echo $this->createUrl('/equipos/ver', array('id_equipo'=>$partido2->visitante->id_equipo) )?>">
					<?php echo $partido2->visitante->nombre ?>
				</a>
			</td>
			
			<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>>
				<?php echo date('Y-m-d G:i', $partido2->hora)?>
			</td>

			<td <?php echo 'class='.(($alt === 1)? '"columna-alt"' : '"columna"'); ?>>
				<?php if($partido2->id_partido == $proximo_partido->id_partido &&  $proximo_partido->turno >= $primer_turno+1 && $proximo_partido->turno < $ultimo_turno+1) { ?>
					<a href="<?php echo Yii::app()->createUrl( '/partidos/asistir?id_partido=' .$partido2->id_partido ) ?>" class="button">Asistir</a>
				<?php } else if ($partido2->id_partido == $proximo_partido->id_partido &&  $proximo_partido->turno == $primer_turno) {?>
					<a href="<?php echo Yii::app()->createUrl( '/partidos/previa?id_partido=' .$partido2->id_partido ) ?>" class="button">Previa</a>
				<?php } else if ($partido2->turno == $ultimo_turno+1 ){ ?>
					<a href="<?php echo Yii::app()->createUrl( '/partidos/previa?id_partido=' .$partido2->id_partido ) ?>" class="button">Cr&oacute;nica</a>

				<?php } ?>
			</td>
		</tr>	
		<?php ($alt === 0)? $alt = 1  : $alt = 0;} ?>
	<?php } ?>
	</table>

	

</div>


	
