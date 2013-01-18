<?php
/* @var $equipo */
/* @var $grupales */
/* @var $mi_equipo */


//Numero de jugadores de una aficion??

?>

<!-- codigo HTML -->

<div class="envoltorio-equipos"> <div class="envoltorio2-equipos"> 
	
	<div cass="equipos-arriba">

		<div class="equipos-escudo">
			<?php switch ($equipo->id_equipo)
				{
				case 1: ?>
				  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/escudos/escudo-rojo.png'; ?>" width=200 height=200 border=0 alt="Escudo rojo"> 
				  <?php break;
				case 2:?>
				  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/escudos/escudo-verde.png'; ?>" width=200 height=200 border=0 alt="Escudo verde"> 
				  <?php break;
				case 3:?>
				  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/escudos/escudo-negro.png'; ?>" width=200 height=200 border=0 alt="Escudo negro"> 
				  <?php break;
				  case 4:?>
				  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/escudos/escudo-blanco.png'; ?>" width=200 height=200 border=0 alt="Escudo blanco"> 
				  <?php break;
				} ?>				
		</div>

		<div class="equipos-informacion">
			<table>
				<tr><th>Nombre equipo: </th> <td><?php echo $equipo->nombre ?></td> </tr> 
				<tr><th>Nivel del equipo: </th> <td><?php echo $equipo->nivel_equipo ?></td> </tr>
				<tr><th>Aforo m&aacute;ximo del estadio: </th> <td><?php echo $equipo->aforo_max ?> </td> </tr> 	
				<tr><th>Aforo b&aacute;sico del estadio: </th> <td><?php echo $equipo->aforo_base ?> </td> </tr> 					 
			</table>

		</div>

	</div>

	<div class="equipos-acciones-grupales">

		<ul>
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
				}?>
			<?php } ?>
		</ul>

	</div>


</div></div> <!--ENVOLTORIOS-->

