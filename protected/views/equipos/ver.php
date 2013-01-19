<?php
/* @var $equipo */
/* @var $grupales */
/* @var $mi_equipo */


//Numero de jugadores de una aficion??

?>

<!-- codigo HTML -->

<head>

</head>

<body>

<div class="envoltorio-perfil"> <div class="envoltorio2-perfil"> 

		<div class="perfil-grupo-arriba">

			<div class="perfil-grupo-arriba-izquierda">

				<div class="perfil-grupo-arriba-izquierda-personaje">
				
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

				<div class="perfil-grupo-arriba-izquierda-equipo">
				
				</div>

			</div>

			<div class="perfil-grupo-arriba-derecha">
				<?php if($mi_equipo){ ?>
					<h1> Tu equipo </h1>
				<?php } ?>

				<table>
					<tr><th>Nombre equipo: </th> <td><?php echo $equipo->nombre ?></td> </tr> 
					<tr><th>Nivel del equipo: </th> <td><?php echo $equipo->nivel_equipo ?></td> </tr>
					<tr><th>Aforo m&aacute;ximo del estadio: </th> <td><?php echo $equipo->aforo_max ?> </td> </tr> 	
					<tr><th>Aforo b&aacute;sico del estadio: </th> <td><?php echo $equipo->aforo_base ?> </td> </tr> 					 
				</table>

			</div>
		</div>

		<div class="perfil-abajo-pasivas">

			<?php if($mi_equipo){ ?>

				<?php if(empty($equipo->accionesGrupales)){ ?>
					<h1> No hay acciones grupales abiertas </h1>
				<?php } else 
				{?>

					<h1> Acciones grupales abiertas </h1>
					<table > 
						<tr> 
							<th>C&oacute;digo</th>
							<th>Creador</th>
							<th>Num. participantes</th>
						</tr>
					<?php foreach ($equipo->accionesGrupales as $ag){ ?> 
							<tr> 
								<td><?php echo  $ag->habilidades->codigo; ?> 	</td>
								<td><?php echo  $ag->usuarios->nick; ?> 	</td>
								<td><?php echo  $ag->jugadores_acc; ?> 	</td>								
							</tr>				
					 <?php } ?>
					</table>
				<?php } ?>
			<?php } ?>
			
		</div>

		<div class="perfil-abajo-partido">
			<?php if(empty($equipo->usuarios)){ ?>
				<h1>Este equipo no tiene jugadores</h1>
			<?php } else 
			{?>
				<h1> Jugadores </h1>
				<table > 
					<tr> 
						<th>Jugador</th>
						<th>Nivel</th>
						<th>Personaje</th>
					</tr>
					<?php foreach ($equipo->usuarios as $e){ ?>
						
						<tr> 
							<td><?php echo  $e->nick; ?> 	</td>
							<td><?php echo  $e->nivel; ?> 	</td>
							<td><?php switch($e->personaje){
									case Usuarios::PERSONAJE_ULTRA:
										echo "Ultra";
										break;
									case Usuarios::PERSONAJE_MOVEDORA:	
										echo "Animadora";
										break;
									case Usuarios::PERSONAJE_EMPRESARIO:
										echo "Empresario";
										break;	
								}; ?> 	</td>								
						</tr>	
					<?php } ?>
				</table>

			<?php }  ?>
		

		</div>


	</div></div> <!--ENVOLTORIOS-->

</body>

</html>
