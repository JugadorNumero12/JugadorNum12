<?php
/* @var $equipos */
/* @var $grupales */

// codigo PHP

//Numero de jugadores de una aficion??

?>

<!-- codigo HTML -->

<h1>Equipo: <?php echo $equipos->nombre ?></h1>
<ul>
	<li>Aforo maximo del estadio -> <?php echo $equipos->aforo_max ?></li>
	<li>Aforo basico del estadio -> <?php echo $equipos->aforo_base ?></li>
	<li>Nivel del equipo -> <?php echo $equipos->nivel_equipo ?></li>
	
		<?php 
		if($mi_equipo){ ?>
		<li> <?php
			if($grupales==null)
				echo "No hay acciones grupales.";
			else 
				echo "Numero de acciones grupales -> ". sizeof($grupales);
			?>
		</li><br>
			<?php
			foreach ($grupales as $accion) {
				echo "Accion con ID " . $accion['id_accion_grupal'];
			}
		} ?>
	
</ul>

<?php 
	if(!$mi_equipo){
		echo "Pulsa el botón para cambiarte a este equipo";	
?>
	<button type="button" onClick="actionCambiar($equipos->id_equipo)">Cambiar de equipo</button>
<?php }
?>
