<?php

?>

<div class="elegir-personaje">
	<table>
		<tr>
			<td>Animadora</td>
			<td>Empresario</td>
			<td>Ultra</td>
		</tr>
		<tr>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/animadora.jpg'; ?>" class="personaje"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/empresario.jpg'; ?>" class="personaje"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/perfil/ultra.jpg'; ?>" class="personaje"></td>
		</tr>

		<tr><?php if($error): ?>
	   	<td>¡Error!</td>
	  	<?php endif; ?></tr>

	</table>
	<br>
	<div><?php echo CHtml::submitButton('Finalizar',array(/*'submit'=>array('/site/login'),*/'class'=>"button large black")); ?></div>
</div>