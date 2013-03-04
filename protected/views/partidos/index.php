
<?php
/*
 * @var lista_partidos: lista completa de partidos
 * @var equipo_usuario: id del equipo del usuario
 * @var proximo_partido: id del proximo partido del equipo del usuario
 */
?>
<div class="calendario"> 

	<h1> Calendario de partidos </h1>

	<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
	?>

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
				<?php echo $partido->hora ?>
			</td>

			<td>
				<?php if($partido->id_partido == $proximo_partido) { ?>
					<?php echo CHtml::submitButton('Asistir', array('submit' => array('/partidos/asistir','id_partido'=>$partido->id_partido),'class'=>"button small black")) ?> </td>
				
				<?php } else { ?>
					<?php echo $partido->cronica ?>

				<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</table>

	

</div>


	
