<?php
/* @var $equipos */
/* @var $grupales */
/* @var $mi_equipo */


//Numero de jugadores de una aficion??

?>

<div class="envoltorio-equipos"> <div class="envoltorio2-equipos"> 
	
	<div class="equipos-escudo">
		<?php switch ($equipos->id_equipo)
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
			<tr><th>Nombre equipo: </th> <td><?php echo $equipos->nombre ?></td> </tr> 
			<tr><th>Nivel del equipo: </th> <td><?php echo $equipos->nivel_equipo ?></td> </tr>
			<tr><th>Aforo m&aacute;ximo del estadio: </th> <td><?php echo $equipos->aforo_max ?> </td> </tr> 	
			<tr><th>Aforo b&aacute;sico del estadio: </th> <td><?php echo $equipos->aforo_base ?> </td> </tr> 					 
		</table>

	</div>


</div></div> <!--ENVOLTORIOS-->

<ul>
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
