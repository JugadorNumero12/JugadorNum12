<?php

?>
<?php

	Helper::registerStyleFile('registroEquipo');
/*
	Yii::app()->clientScript->registerLinkTag(
		'stylesheet/less', 'text/css', 
		Yii::app()->request->baseUrl . '/less/registroEquipo.less'
	);*/
?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsRegistro.js'); ?>
<div class="envoltorio-elegir-personaje">

<div class="contenido-elegir-personaje">
	<h3>ELIJA UN PERSONAJE</h3>
	<div class="descripcion-personaje">Pulse en la imagen de su personaje y haga click en finalizar. </div>

<div class="elegir-personaje">
	<table>		
		<tr>
			<td><input type="image" value="radio-ultra" 	 onclick="$(this).setIdPersonaje(this.value);" title="Representa la fuerza bruta, el sector m&aacute;s radical de la afici&oacute;n, que siempre intenta hacer mella en la moral del equipo contrario para lograr que su equipo logre alzarse con la victoria. Aunque suelen ser pocos por el car&aacute;cter agresivo y escandaloso que tienen, saben hacerse escuchar y animar a su equipo mejor que cualquier otro." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/ultra.jpg'; ?>" class="personaje"></td>
			<td><input type="image" value="radio-animadora"  onclick="$(this).setIdPersonaje(this.value);" title="Organizadora de eventos por naturaleza, utiliza las redes sociales y cualquier medio de comunicaci&oacute;n a su alcance para mover a los aficionados a dar apoyo a su equipo. Nadie puede igualarse a la relaciones p&uacute;blcias en su af&aacute;n por conseguir adeptos y en ganarse su confianza tan f&aacute;cilmente. En cambio, su perfil de estudiante hace que su nivel econ&oacute;mico sea limitado." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/animadora.jpg'; ?>" class="personaje"></td>
			<td><input type="image" value="radio-empresario" onclick="$(this).setIdPersonaje(this.value);" title="Est&aacute; al frente de la lucha de las aficiones en los despachos, mueve cantidades abrumadoras de dinero. No pone pegas ni a las apuestas, ni a los sobornos y en general a nada que le proporcione rentabilidad econ&oacute;mica. Representa un alto cargo dedicado en cuerpo y alma a los negocios, pero a la hora de ir a ver un partido, prefiere sentarse en los palcos y ser un mero observador." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/empresario.jpg'; ?>" class="personaje"></td>
		</tr>
		<tr>
			<td>Ultra</td>
			<td>Animadora</td>
			<td>Empresario</td>			
		</tr>
	</table>
</div>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'usuarios-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
?>
<div class="campos-ocultos">
	<table>
		<tr>
	 		<td>
	  		<?php echo CHtml::radioButton('pers', $ultra_status,
	  									  array('id'=>'radio-ultra','value'=>'ultra','uncheckValue'=>null)); ?>
	  		</td>
	  		<td>
	  		<?php echo CHtml::radioButton('pers', $animadora_status,
	  									  array('id'=>'radio-animadora','value'=>'animadora','uncheckValue'=>null)); ?>
	  		</td>
	  		<td>
	  		<?php echo CHtml::radioButton('pers', $empresario_status,
	  									   array('id'=>'radio-empresario','value'=>'empresario','uncheckValue'=>null)); ?>
	  		</td>
	  	</tr>
	</table>
</div>
<div><?php echo CHtml::submitButton('Finalizar',array('class'=>"button large black")); ?></div>

</div>
	<?php $this->endWidget(); ?>
</div>