<?php

?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'usuarios-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
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


		<tr>
	  	<td>
	  		<?php echo CHtml::radioButton('pers', $animadora_status,array('value'=>'animadora','uncheckValue'=>null)); ?>
	  	</td>
	  	<td>
	  		<?php echo CHtml::radioButton('pers', $empresario_status,array('value'=>'empresario','uncheckValue'=>null)); ?>
	  	</td>
	  	<td>
	  		<?php echo CHtml::radioButton('pers', $ultra_status,array('value'=>'ultra','uncheckValue'=>null)); ?>
	  	</td>
	  	</tr>



		<!-- <tr><?php if($error): ?>
	   	<td>¡Error!</td>
	  	<?php endif; ?></tr> -->

	</table>
	<br>
	<div><?php echo CHtml::submitButton('Finalizar',array('class'=>"button large black")); ?></div>
</div>

<?php $this->endWidget(); ?>