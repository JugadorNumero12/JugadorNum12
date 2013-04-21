<!-- 
	@var $modeloU Modelo del usuario
	@var $accionesPas array con las acciones pasivas desbloqueadas por el usuario
	@var $accionesPas array con las acciones de partido desbloqueadas por el usuario
	@var $recursos recursos del usuario
-->
<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/acordeon.js');
?>

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
		<div id="titulo">MI PERFIL</div>
		<img src="<?php echo Yii::app()->BaseUrl.'/images/escudos/'.$modeloU->equipos->token.'.png'; ?>"
		id="img-escudo"
		alt="<?php echo $modeloU->equipos->nombre; ?>"> 
	</div>
	<div id="cambios-generales">
		<span class="span-cambio"><?php echo CHtml::submitButton('Cambiar contraseña', array('submit' => array('cambiarClave'),'class'=>"button small black"));?></span>
		<span class="span-cambio"><?php echo CHtml::submitButton('Cambiar email', array('submit' => array('cambiarEmail'),'class'=>"button small black"));?></span>
    	<!-- DEBUG -->
		<span class="span-cambio"><?php echo CHtml::submitButton('+500 exp', array('submit' => array('debug'),'class'=>"button small black"));?></span>
		<span class="span-cambio"><?php echo CHtml::submitButton('+5000 exp', array('submit' => array('debug2'),'class'=>"button small black"));?></span>
		<!-- ** -->
	</div>
  </div>

  <div class="accordion" style="margin-top: 20px;">
    <h3 class="ui-accordion-header-active"><b>Informaci&oacute;n general</b></h3>
    <div class="datos-perfil">	
    	<p><b>Nick:&nbsp;</b><?php echo $modeloU->nick ?></p>
    	<p><b>Email:&nbsp;</b><?php echo $modeloU->email ?></p>
    	<p><b>Nivel:&nbsp;</b><?php echo $modeloU->nivel ?></p>
    	<p><b>Experencia:&nbsp;</b>   <?php echo $modeloU->exp.' / '.$modeloU->exp_necesaria; ?>
    		<div class="meter">
    			<span class="s1" style="width:<?php echo ($modeloU->exp / $modeloU->exp_necesaria)*100; ?>%"></span>
    		</div>
    	</p>
    	<p><b>Generaci&oacute;n de dinero:&nbsp;</b><?php echo $modeloU->recursos->dinero_gen ?>&nbsp;/&nbsp;min</p>
    	<p><b>Generaci&oacute;n de &aacute;nimo:&nbsp;</b><?php echo $modeloU->recursos->animo_gen ?>&nbsp;/&nbsp;min</p>
    	<p><b>Generaci&oacute;n de influencias:&nbsp;</b><?php echo $modeloU->recursos->influencias_gen ?>&nbsp;/&nbsp;min</p>
    </div>
    <h3 class="ui-accordion-header-active"><b>Habilidades pasivas desbloqueadas</b></h3>
    <div class="datos-perfil">
    	<?php if(empty($accionesPas)){ ?>
			<h5> No hay habilidades pasivas desbloqueadas </h5>
		<?php } else 
		{?>
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
    <h3 class="ui-accordion-header-active"><b>Habilidades de partido desbloqueadas</b></h3>
    <div class="datos-perfil">
    	<?php if(empty($accionesPar)){ ?>
			<h5> No hay habilidades de partido desbloqueadas </h5>
		<?php } else 
		{?>
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
   </div>