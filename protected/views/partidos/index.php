
<?php
/*
 * @var lista_partidos: lista completa de partidos
 * @var equipo_usuario: id del equipo del usuario
 * @var proximo_partido: id del proximo partido del equipo del usuario
 */
?>
<div class="calendario"> 

	<h1> Calendario de partidos </h1>

	<table border=0>
		<tr>
			<th>Equipo Local</th>
			<th>Equipo Visitante</th>
			<th>Hora</th>
			<th>Informaci&oacute;n</th>
		</tr>

	<?php foreach ($lista_partidos as $partido) { ?>
		<tr>
			<td>
				<a href="<?php echo $this->createUrl('/equipos/ver', array('id_equipo'=>$partido->local->id_equipo) )?>">
					<?php echo $partido->local->nombre ?> 
				</a>
			</td>
			
			<td>
				<a href="<?php echo $this->createUrl('/equipos/ver', array('id_equipo'=>$partido->visitante->id_equipo) )?>">
					<?php echo $partido->visitante->nombre ?>
				</a>
			</td>
			
			<td>
				<?php echo Yii::app()->format->formatDatetime($partido->hora)?>
			</td>

			<td>
				<?php if($partido->id_partido == $proximo_partido->id_partido &&  $proximo_partido->turno >= $primer_turno+1 && $proximo_partido->turno < $ultimo_turno+1) { ?>
					<?php echo CHtml::submitButton('Asistir', array('submit' => array('/partidos/asistir','id_partido'=>$partido->id_partido),'class'=>"button small black")) ?> 
				<?php } else if ($partido->id_partido == $proximo_partido->id_partido &&  $proximo_partido->turno == $primer_turno) {?>
					<?php echo CHtml::submitButton('Previa', array('submit' => array('/partidos/previa','id_partido'=> $proximo_partido->id_partido),'class'=>"button small black")) ?>
				<?php } else if ($partido->turno == $ultimo_turno+1 ){ ?>
					<?php echo CHtml::submitButton('Cronica', array('submit' => array('/partidos/previa','id_partido'=>$partido->id_partido),'class'=>"button small black")) ?>

				<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</table>

	

</div>


	
