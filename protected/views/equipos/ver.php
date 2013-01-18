<?php
/* @var $equipo */
/* @var $grupales */
/* @var $mi_equipo */


//Numero de jugadores de una aficion??

?>

<!-- codigo HTML -->

<h1><?php echo $equipo->nombre?></h1>
<ul>
	<h2>Datos del equipo</h2>
	<!-- Muestra el aforo maximo del estadio -->
	<li><b>Aforo maximo del estadio:</b> <?php echo $equipo->aforo_max; ?></li>
	<!-- Muestra el aforo básico del estadio -->
	<li><b>Aforo basico del estadio:</b> <?php echo $equipo->aforo_base; ?></li>
	<!-- Muestra el nivel del equipo -->
	<li><b>Nivel del equipo:</b> <?php echo $equipo->nivel_equipo; ?></li>

	<!--Muestra todos los usuarios del del equipo con su nick, su nivel y su tipo de personaje -->
	<h2>Jugadores del equipo</h2>
	<?php foreach ($equipo->usuarios as $e){ ?>
		<li>
			<b>Nick: </b> <?php echo $e->nick; ?>
			<b>Nivel: </b> <?php echo $e->nivel; ?>
			<?php switch($e->personaje){
				case Usuarios::PERSONAJE_ULTRA:
					$tipoPersonaje = "Ultra";
					break;
				case Usuarios::PERSONAJE_MOVEDORA:	
					$tipoPersonaje = "Movedora";
					break;
				case Usuarios::PERSONAJE_EMPRESARIO:
					$tipoPersonaje = "Empresario";
					break;	
			}; ?>
			<b>Personaje: </b> <?php echo $tipoPersonaje; ?>
		</li>
	<?php } ?>

	<!-- Si es el equipo del usuario muestra las acciones grupales abiertas del equipo -->
	<?php if($mi_equipo){ ?>
		<h2>Acciones grupales abiertas</h2>
		<?php
			if(empty($equipo->accionesGrupales)) {
				echo "No hay acciones grupales abiertas.";
			} else {
				foreach ($equipo->accionesGrupales as $ag) { ?>
					<li>
						<b>Accion: </b> <?php echo $ag->habilidades->codigo; ?>
						<b>Creador: </b> <?php echo $ag->usuarios->nick; ?>
						<b>Participantes: </b> <?php echo $ag->jugadores_acc; ?>
					</li>
				<?php }
			}
		?>
	<?php } ?>
</ul>