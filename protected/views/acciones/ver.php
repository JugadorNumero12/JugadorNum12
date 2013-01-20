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
<div class="envoltorio-acciones-ver">

	<div class="encabezado"><?php echo $accionGrupal['habilidades']['nombre']; ?></div>

	<div class="datos-accion">
		<table class="tablas-acciones-ver">
			<tr><th>Creador: </th><td> <a href="<?php echo $this->createUrl('/usuarios/ver', array('id_usuario' => $accionGrupal->usuarios->id_usuario));?>"> <?php echo $accionGrupal->usuarios->nick; ?> </a></td></tr>
			<tr><th>Equipo creador: </th><td><?php echo $accionGrupal->equipos->nombre; ?> </td></tr>
			<tr><th>Numero de participantes: </th><td><?php echo $accionGrupal['jugadores_acc']; ?></td></tr>
			<!--<tr><th>Efecto que se consigue: </th><td><?php echo $accionGrupal['habilidades']['descripcion']; ?></td></tr>-->
			<tr><th>Finalizacion: </h><td><?php echo $accionGrupal['finalizacion']; ?></td></tr>
		</table>
	</div>

	<div class="encabezado2"> Recursos añadidos </div>
		<div class="recursos-aniadidos">
			<table class="tablas-acciones-ver">
				<tr><th>Dinero: </th><td><?php echo $accionGrupal['dinero_acc'];?> / <?php echo$accionGrupal['habilidades']['dinero_max']; ?> </td></tr>
				<tr><th>Influencias: </th><td><?php echo $accionGrupal['influencias_acc'];?> / <?php echo $accionGrupal['habilidades']['influencias_max']; ?> </td></tr>
				<tr><th>Animo: </th><td><?php echo $accionGrupal['animo_acc'];?> / <?php echo $accionGrupal['habilidades']['animo_max']; ?> </td></tr>
			</table>
	</div>

	<div class="encabezado2"> Participantes </div>
	<div class="participantes"> 
			<table class="tabla-participantes">
				<tr> 
					<th>Usuario</th>
					<th>Dinero</th>
					<th>Influencias</th>
					<th>Animo</th>
				</th>
				<?php foreach ($accionGrupal->participaciones as $participacion){ ?>
					<tr>
						<td><?php echo 'usuario'; ?></td>
						<td><?php printf('%d / %d', $participacion->dinero_aportado, $accionGrupal->habilidades->dinero_max); ?> </td>
						<td><?php printf('%d / %d', $participacion->influencias_aportadas, $accionGrupal->habilidades->influencias_max); ?> </td>
						<td><?php printf('%d / %d', $participacion->animo_aportado, $accionGrupal->habilidades->animo_max); ?> </td>
						<!--El usuario es el propietario de la accion y puede expulsar jugadores -->
						<td><?php echo CHtml::button('Expulsar jugador', array('submit' => array('acciones/expulsar', 'id_accion'=>$accionGrupal->id_accion_grupal, 'id_jugador'=>$participacion->usuarios_id_usuario), 'class'=>"button small black")); ?></td>
					</tr>
				<?php } ?>
			</table>
	</div>

	<div class="mensaje">
		<?php if ($esParticipante == true){
			echo "Ya has participado en la accion";} ?>
	</div>

	<!-- Compruebo si la accion ha alcanzado el numero maximo de participantes -->
	<div class="mensaje">
		<?php if ($accionGrupal['jugadores_acc'] >= $accionGrupal['habilidades']['participantes_max']){
			echo 'La accion ha alcanzado el número máximo de participantes';
		} ?>
	</div>

	<div class="mensaje">
		<?php if ($accionGrupal['completada'] == 1){
			echo "La accion se ha completado";
		} ?>
	</div>

	<!-- si la acción no ha pasado de jugadores máximos, ni ha terminado, y la acción es de su equipo, entonces puede participar -->
	<div class="boton-participar">
		<?php if($accionGrupal['jugadores_acc'] < $accionGrupal['habilidades']['participantes_max'] && $accionGrupal['completada'] == 0 && $equipoUsuario == $equipoAccion){ ?>
		<!--El usuario no es participante ni creador, así que puede participar en la accion -->
			<?php echo CHtml::button('Participar', array('submit' => array('acciones/participar', 'id_accion'=>$accionGrupal->id_accion_grupal))); ?>
		<?php } ?>
	</div>
</div>