<?php

?>

<div class="envoltorio-elegir-personaje">

<div class="contenido-elegir-personaje">
	<h3>ELIJA UN PERSONAJE</h3>
	<div class="descripcion-personaje">Pulse en la imagen de su personaje y haga click en finalizar. </div>

<div class="elegir-personaje">
	<table>		
		<tr>
			<td><input type="image" value="radio-ultra" 	 onclick="$(this).setIdPersonaje(this.value);" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/ultra.jpg'; ?>" class="personaje"></td>
			<td><input type="image" value="radio-animadora"  onclick="$(this).setIdPersonaje(this.value);" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/animadora.jpg'; ?>" class="personaje"></td>
			<td><input type="image" value="radio-empresario" onclick="$(this).setIdPersonaje(this.value);" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/empresario.jpg'; ?>" class="personaje"></td>
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