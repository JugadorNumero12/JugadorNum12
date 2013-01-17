<?php
/* @var $accionGrupal */
/* @var $habilidad */
// @var $usuario
// @var $propietarioAccion
// @var $participaciones
// @var esParticipante
// @var equipoAccion
// @var equipoUsuario

// codigo PHP
?>

<h1>ACCION GRUPAL: <?php echo $accionGrupal['habilidades']['nombre']; ?></h1>

<p> <b>USUARIO QUE HA CREADO LA ACCION => </b>
		<?php echo $accionGrupal['usuarios_id_usuario']; ?>
		&nbsp;
		<?php if($propietarioAccion == $usuario){
			echo "(Eres el creador de esta accion)";
		} ?>
</p>

<p> <b>NUMERO DE PARTICIPANTES => </b>
		<?php echo $accionGrupal['jugadores_acc']; ?>
</p>

<p> <b>EQUIPO CREADOR DE LA ACCION => </b>
		<?php echo $equipoAccion; ?>
		&nbsp;
		<?php if($equipoAccion == $equipoUsuario){
			echo "(Este es tu equipo)";
		} ?>
</p>

<p> <b>TOTAL DE RECURSOS AÑADIDOS => </b>
		<?php printf('<b>Dinero:</b> %d / %d', $accionGrupal['dinero_acc'], $accionGrupal['habilidades']['dinero_max']); ?>
		&nbsp;
		<?php printf('<b>Influencias:</b> %d / %d', $accionGrupal['influencias_acc'], $accionGrupal['habilidades']['influencias_max']); ?>
		&nbsp;
		<?php printf('<b>Animo:</b> %d / %d', $accionGrupal['animo_acc'], $accionGrupal['habilidades']['animo_max']); ?>
</p>

<p> <b>EFECTO QUE SE CONSIGUE => </b>
		<?php echo $accionGrupal['habilidades']['descripcion']; ?>
</p>

<p> <b>PARTICIPANTES Y RECURSOS AÑADIDOS POR CADA UNO </b> </p>

<p> 
<?php foreach ($accionGrupal['participaciones'] as $participacion){ ?>
	<li>
		<?php printf('<b>Usuario:</b> %d', $participacion['usuarios_id_usuario']); ?>
		&nbsp;
		<?php printf('<b>Dinero aportado:</b> %d / %d', $participacion['dinero_aportado'], $accionGrupal['habilidades']['dinero_max']); ?>
		&nbsp;
		<?php printf('<b>Influencias aportadas:</b> %d / %d', $participacion['influencias_aportadas'], $accionGrupal['habilidades']['influencias_max']); ?>
		&nbsp;
		<?php printf('<b>Animo aportado:</b> %d / %d', $participacion['animo_aportado'], $accionGrupal['habilidades']['animo_max']);
		if ($propietarioAccion == $usuario){ ?>
		<!--El usuario es el propietario de la accion y puede expulsar jugadores -->
		<a href="<?php echo $this->createUrl('acciones/expulsar', array('id_accion'=>$accionGrupal['id_accion_grupal'], 'id_jugador'=>$participacion['usuarios_id_usuario'])); ?>">
		<input type="button" value="Expulsar jugador"/> </a>
		<?php } ?>
	</li>
<?php } ?>
</p>

<p> <b>FINALIZACION DE LA ACCION => </b>
	<?php echo $accionGrupal['finalizacion']; ?>
</p>

<p><b> <?php if ($esParticipante == true){
	echo "Has participado en la accion";
} ?> </b></p>

<!-- Compruebo si la accion ha alcanzado el numero maximo de participantes -->
<p><b><?php if ($accionGrupal['jugadores_acc'] >= $accionGrupal['habilidades']['participantes_max']){
	echo 'La accion ha alcanzado el número máximo de participantes';
} ?> </b></p>

<p><b><?php if ($accionGrupal['completada'] == 1){
		echo "La accion se ha completado";
	} ?> </b>
</p>

<!-- si la acción no ha pasado de jugadores máximos, ni ha terminado, y la acción es de su equipo, entonces puede participar -->
<p><?php if($accionGrupal['jugadores_acc'] < $accionGrupal['habilidades']['participantes_max'] && $accionGrupal['completada'] == 0 && $equipoUsuario == $equipoAccion){ ?>
	<!--El usuario no es participante ni creador, así que puede participar en la accion -->
	<a href="<?php echo $this->createUrl('acciones/participar', array('id_accion'=>$accionGrupal['id_accion_grupal']));?>"> 
	<input type="button" value="<?php echo !$esParticipante?'Participar':'Aumentar Participacion';?>"/> </a>
<?php } ?></p>
