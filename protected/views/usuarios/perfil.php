<!-- 
	@var $modeloU Modelo del usuario
	@var $accionesPas array con las acciones pasivas desbloqueadas por el usuario
	@var $accionesPas array con las acciones de partido desbloqueadas por el usuario
	@var $recursos recursos del usuario
-->

	<div class="envoltorio-perfil"> <div class="envoltorio2-perfil"> 

		<div class="perfil-grupo-arriba">

			<div class="perfil-grupo-arriba-izquierda">

				<div class="perfil-grupo-arriba-izquierda-personaje">
				
				<?php switch ($modeloU->personaje)
								{
								case Usuarios::PERSONAJE_ULTRA: ?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/images/perfil/ultra.jpg'; ?>" width=200 height=200 border=0 alt="Ultra"> 
								  <?php break;
								case Usuarios::PERSONAJE_MOVEDORA:?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/images/perfil/animadora.jpg'; ?>" width=200 height=200 border=0 alt="Animadora"> 
								  <?php break;
								case Usuarios::PERSONAJE_EMPRESARIO:?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/images/perfil/empresario.jpg'; ?>" width=200 height=200 border=0 alt="Empresario"> 
								  <?php break;
								} ?>
				</div>

				<div class="perfil-grupo-arriba-izquierda-equipo">
					<img
						src="<?php echo Yii::app()->BaseUrl.'/images/escudos/'.$modeloU->equipos->token.'.png'; ?>"
						width="200" height="200"
						alt="<?php echo $modeloU->equipos->nombre; ?>"> 
						
				</div>

			</div>

			<div class="perfil-grupo-arriba-derecha">
				<table >
						<tr>
							<th>Nick: </th>
							<td><?php echo $modeloU->nick ?></td>
						</tr> 
						<tr>
							<th>Nivel: </th>
							<td><?php echo $modeloU->nivel ?> </td>
						</tr> 
						<tr>
							<th>Experencia: <br></th>
							<td>
								<!-- FIXME: dar estilo a la brrar de progreso (actualmente no aparece) -->
								<div id="barra-progreso-exp" data-valor="<?php echo $modeloU->exp?>" data-max="<?php echo $modeloU->exp_necesaria ?>">
									<div id="progress-label-exp"> <?php echo $modeloU->exp?> / <?php echo $modeloU->exp_necesaria?> </div>
								</div>
							</td> 
						</tr> 
						<tr>
							<th> <br></th>
							<td> </td> <br>
						</tr> 
						<tr>
							<th>Email: </th>
							<td><?php echo $modeloU->email ?></td>
						</tr>
						<tr>
							<td><?php echo CHtml::submitButton('Cambiar contraseña', array('submit' => array('cambiarClave'),'class'=>"button small black"));?></td>
	    					<td><?php echo CHtml::submitButton('Cambiar email', array('submit' => array('cambiarEmail'),'class'=>"button small black"));?></td>
	    				</tr>
	    				<!-- DEBUG -->
	    				<tr>
							<td><?php echo CHtml::submitButton('+500 exp', array('submit' => array('debug'),'class'=>"button small black"));?></td>
	    					<td><?php echo CHtml::submitButton('+5000 exp', array('submit' => array('debug2'),'class'=>"button small black"));?></td>
	    				</tr>
	    				<!-- ** -->
				</table>
			</div>
		</div>

		<div class="perfil-abajo-pasivas">

			<?php if(empty($accionesPas)){ ?>
				<h1> No hay habilidades pasivas desbloqueadas </h1>
			<?php } else 
			{?>

				<h1> Habilidades pasivas desbloqueadas </h1>
				<table > 
				<?php foreach ($accionesPas as $accion){ ?> 
						<tr> 
							<td><?php echo $accion->nombre; ?> 	
							 </td>
							<td> <?php echo CHtml::submitButton('Ver',array('submit' => array('/habilidades/ver','id_habilidad'=>$accion->id_habilidad),'class'=>"button small black"));?> </td>
						</tr>				
				 <?php } ?>
				</table>

			<?php } ?>
			
		</div>

		<div class="perfil-abajo-partido">

			<?php if(empty($accionesPar)){ ?>
				<h1> No hay habilidades de partido desbloqueadas </h1>
			<?php } else 
			{?>

				<h1> Habilidades de partido desbloqueadas </h1>
				<table > 
				<?php foreach ($accionesPar as $accion){ ?> 
						<tr> 
							<td><?php echo $accion->nombre; ?> 	
							 </td>
							<td> <?php echo CHtml::submitButton('Ver',array('submit' => array('/habilidades/ver','id_habilidad'=>$accion->id_habilidad),'class'=>"button small black"));?> </td>
						</tr>				
				 <?php } ?>
				</table>

			<?php } ?>

		</div>


	</div></div> <!--ENVOLTORIOS-->