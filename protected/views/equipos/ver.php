<?php
/* @var $equipo */
/* @var $grupales */
/* @var $mi_equipo */


//Numero de jugadores de una aficion??

?>

<!-- codigo HTML -->

<h1>Equipo: <?php echo $equipo->nombre ?></h1>
<ul>
	<li>Aforo maximo del estadio -> <?php echo $equipo->aforo_max ?></li>
	<li>Aforo basico del estadio -> <?php echo $equipo->aforo_base ?></li>
	<li>Nivel del equipo -> <?php echo $equipo->nivel_equipo ?></li>
	
		<?php if($mi_equipo){ ?>
		<li> <?php
			if(empty($equipo['accionesGrupales'])) {
				echo "No hay acciones grupales.";
			} else {
				echo "Numero de acciones grupales -> ". sizeof($equipo['accionesGrupales']);
			}
			?>
		</li>
		<li><ul>
			<?php
			foreach ($equipo['accionesGrupales'] as $accion) { ?>
			<li>
				<? echo "Accion con ID " . $accion['id_accion_grupal']; ?>
			</li>
			<? } ?>
		</ul></li>
		<?php } ?>

		<!-- TODO: Lista de usuarios -->
		<!-- Usad la variables $equipo['usuarios'] -->
	
</ul>

<?php 
	if(!$mi_equipo){
		echo "Pulsa el botón para cambiarte a este equipo";	
		//echo CHtml::button('Cambiar de equipo', array('submit' => array('equipos/ver', 'id_equipo'=>$equipos->id_equipo)));
		//echo CHtml::link('Link Text',array('equipos/cambiar','id_equipo'=>$equipos->id_equipo));
		//EquiposController::actionCambiar($equipos->id_equipo);
?>
<!-- 	<button id="b" type="button" onClick="EquiposController::actionCambiar($equipos->id_equipo)";>Cambiar de equipo</button> -->
<!-- <?php } ?> -->
