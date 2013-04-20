<?php
/* @var $equipo */
/* @var $grupales */
/* @var $mi_equipo */


//Numero de jugadores de una aficion??

?>

<!-- codigo HTML -->

<div class="envoltorio-perfil"> <div class="envoltorio2-perfil">

		<div class="perfil-grupo-arriba">
			<div class="perfil-grupo-arriba-izquierda">
				<div class="perfil-grupo-arriba-izquierda-equipo">
					<img
						src="<?php echo Yii::app()->BaseUrl.'/images/escudos/'.$equipo->token.'.png'; ?>"
						width=150 height=150 
						alt="<?php echo $equipo->nombre ?>"> 
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
					<h1> No hay acciones grupales </h1>
				<?php } else 
				{?>

					<h1> Acciones grupales  </h1>
					<table > 
						<tr> 
							<th>Nombre</th>
							<th>Creador</th>
							<th>Num. participantes</th>
							<th>Completada</th>

						</tr>
					<?php foreach ($equipo->accionesGrupales as $ag){ ?> 
							<tr> 
								<td><?php echo  $ag->habilidades->nombre; ?> 	</td>
								<td><?php echo  $ag->usuarios->nick; ?> 	</td>
								<td><?php echo  $ag->jugadores_acc; ?> 	</td>	
								<td> <?php if($ag->completada) {?>
										S&iacute; 
									<?php } else {?>
										No 
									<?php }?>
									</td>
								<td> <?php echo CHtml::submitButton('Ver',array('submit' => array('/acciones/ver','id_accion'=>$ag->id_accion_grupal),'class'=>"button small black"));?> 	</td>		
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
							<td><a href="<?php echo $this->createUrl( '/usuarios/ver', array('id_usuario' => $e->id_usuario) ); ?>">  

										<?php echo $e->nick ?></td>
								</a> 	
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

		<?php if(!$mi_equipo){ ?>
			<td><?php echo CHtml::button('Cambiar equipo', array('submit' => array('equipos/cambiar', 'id_nuevo_equipo'=>$equipo->id_equipo), 'class'=>"button small black")); ?></td>

		<?php } ?>

		<?php if($mi_equipo){ ?>
        	<td><?php echo CHtml::button('Mandar mensaje a los compañeros', array('submit' => array('emails/mensajeEquipo', 'id_equipo'=>$equipo->id_equipo), 'class'=>"button small black")); ?></td>  
   		<?php } ?>

		

	</div></div> <!--ENVOLTORIOS-->
