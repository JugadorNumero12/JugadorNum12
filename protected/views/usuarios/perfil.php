<?php
/* @var $modeloU Modelo del usuario*/
/* @var $accionesPas array con las acciones pasivas desbloqueadas por el usuario*/
/* @var $accionesPas array con las acciones de partido desbloqueadas por el usuario*/

// codigo PHP 

?>

<head>
<!-- jQuery -->
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
	<?php $cssCoreUrl = Yii::app()->clientScript->getCoreScriptUrl();
	Yii::app()->clientScript->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsPerfil.js'); ?>
</head>

<body>

	<div class="envoltorio-perfil"> <div class="envoltorio2-perfil"> 

		<div class="perfil-grupo-arriba">

			<div class="perfil-grupo-arriba-izquierda">

				<div class="perfil-grupo-arriba-izquierda-personaje">
				
				<?php switch ($modeloU->personaje)
								{
								case Usuarios::PERSONAJE_ULTRA: ?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/perfil/ultra.jpg'; ?>" width=300 height=300 border=0 alt="Ultra"> 
								  <?php break;
								case Usuarios::PERSONAJE_MOVEDORA:?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/perfil/animadora.jpg'; ?>" width=300 height=300 border=0 alt="Animadora"> 
								  <?php break;
								case Usuarios::PERSONAJE_EMPRESARIO:?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/perfil/empresario.jpg'; ?>" width=300 height=300 border=0 alt="Empresario"> 
								  <?php break;
								} ?>
				</div>

				<div class="perfil-grupo-arriba-izquierda-equipo">
				
				 <?php switch ($modeloU->equipos->id_equipo)
								{
								case 1: ?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/escudos/escudo-rojo.png'; ?>" width=100 height=100 border=0 alt="Escudo rojo"> 
								  <?php break;
								case 2:?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/escudos/escudo-verde.png'; ?>" width=100 height=100 border=0 alt="Escudo verde"> 
								  <?php break;
								case 3:?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/escudos/escudo-negro.png'; ?>" width=100 height=100 border=0 alt="Escudo negro"> 
								  <?php break;
								  case 4:?>
								  <img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/escudos/escudo-blanco.png'; ?>" width=100 height=100 border=0 alt="Escudo blanco"> 
								  <?php break;
								} ?> 
				</div>

			</div>

			<div class="perfil-grupo-arriba-derecha">
				<?php $recursos = Recursos::model()->findByPk($modeloU->id_usuario) ?>
				<table >
						<tr><th>Nick: </th> <td><?php echo $modeloU->nick ?></td> </tr> 
						<tr><th>Nivel: </th> <td><?php echo $modeloU->nivel ?> </td> </tr> 
						<tr><th> <br></th> <td> </td> <br></tr> 
						<tr><th>Dinero: </th> <td><?php echo $modeloU->recursos->dinero ?></td> </tr> 
						<tr><th>&Aacute;nimo: </th> <td class="barrita" id="bar" data-valor="<?php echo $modeloU->recursos->animo?>" data-max="<?php echo $recursos->animo_max ?>"><div class="label1">Label</div></td> </tr> 
						<tr><th>Influencias: </th> <td class="barrita" id="bar2" data-valor="<?php echo $modeloU->recursos->influencias?>" data-max="<?php echo $recursos->influencias_max ?>"><div class="label2">Label</div></td> </tr> 
						<tr><th> <br></th> <td> </td> <br></tr> 
						<tr><th>Email: </th><td><?php echo $modeloU->email ?></td></tr>
						<tr><td><?php echo CHtml::submitButton('Cambiar contraseña', array('submit' => array('cambiarClave'),'class'=>"button small black"));?></td>
	    				<td><?php echo CHtml::submitButton('Cambiar email', array('submit' => array('cambiarEmail'),'class'=>"button small black"));?></td></tr>
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

</body>

</html>
