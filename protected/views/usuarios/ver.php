<?php
/* @var $modeloU */

?>

<!-- codigo HTML -->
<!-- COMPARTE LOS CSS CON LA VISTA PERFIL PORQUE SON LOS MISMOS -->
<div id="info-perfil">
  	<div id="info-cabecera">
	  	<?php switch ($modeloU->personaje)
		{
			case Usuarios::PERSONAJE_ULTRA: ?>
			  <img id="img-perfil" src="<?php echo Yii::app()->BaseUrl.'/images/perfil/ultra.jpg'; ?>" alt="Ultra"> 
			  <?php break;
			case Usuarios::PERSONAJE_MOVEDORA:?>
			  <img id="img-perfil" src="<?php echo Yii::app()->BaseUrl.'/images/perfil/animadora.jpg'; ?>" alt="Animadora"> 
			  <?php break;
			case Usuarios::PERSONAJE_EMPRESARIO:?>
			  <img id="img-perfil" src="<?php echo Yii::app()->BaseUrl.'/images/perfil/empresario.jpg'; ?>" alt="Empresario"> 
			  <?php break;
		} ?>
		<div id="titulo">PERFIL DE USUARIO</div>
		<img src="<?php echo Yii::app()->BaseUrl.'/images/escudos/'.$modeloU->equipos->token.'.png'; ?>"
		id="img-escudo"
		alt="<?php echo $modeloU->equipos->nombre; ?>"> 
	</div>
	<div id="cambios-generales">
		<span class="span-cambio"><?php echo CHtml::button('Mandar mensaje', array('submit' => array('emails/redactar', 'destinatario'=>$modeloU->nick, 'tema'=>""),'class'=>"button small black")); ?></span>
	</div>
	<div id="i-usuario">
		<p><b>Nick:</b> </th> <td><?php echo $modeloU->nick ?></p>
		<p><b>Nivel: </b><?php echo $modeloU->nivel ?></p>
	</div>
</div>