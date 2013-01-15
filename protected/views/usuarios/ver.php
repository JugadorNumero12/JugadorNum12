<?php
/* @var $modeloU */

?>

<!-- codigo HTML -->
<!-- COMPARTE LOS CSS CON LA VISTA PERFIL PORQUE SON LOS MISMOS -->
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
				<table>
					<tr><th>Nick: </th> <td><?php echo $modeloU->nick ?></td> </tr> 
					<tr><th>Nivel: </th> <td><?php echo $modeloU->nivel ?> </td> </tr> 						 
				</table>
			</div>
		</div>

</div></div> <!--ENVOLTORIOS-->