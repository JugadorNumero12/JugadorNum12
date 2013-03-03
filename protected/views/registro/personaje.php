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
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/perfil/animadora.jpg'; ?>" class="personaje"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/perfil/empresario.jpg'; ?>" class="personaje"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/perfil/ultra.jpg'; ?>" class="personaje"></td>
		</tr>
	</table>
	<br>
	<div><?php echo CHtml::submitButton('Finalizar',array('submit'=>array('/site/login'),'class'=>"button large black")); ?></div>
</div>