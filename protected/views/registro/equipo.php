<?php 
/*@var $equipos lista de equipos */
?>

<div class="envoltorio-elegir-equipo">
<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'usuarios-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>

<div class="contenido-elegir-equipo">
	<h3>ELIJA UN EQUIPO</h3>
	<div class="descripcion">Pulse en el escudo de su equipo favorito y haga click en siguiente. </div>

	<!-- Tabla con 2 filas y 4 columnas por fila -> 8 equipos -->	
	<div class="elegir-equipo">
		<table>
			<tr>
				<td><input type="image" value="1" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/rojos.png'; ?>" class="escudos" alt="Rojos"/></td>
				<td><input type="image" value="2" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/verdes.png'; ?>" class="escudos" alt="Verdes"></td>
				<td><input type="image" value="3" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/negros.png'; ?>" class="escudos" alt="Negros"></td>
				<td><input type="image" value="4" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/blancos.png'; ?>" class="escudos" alt="Blancos"></td>
			</tr>
			<tr>
				<td><?php echo $equipos[1]; ?></td>
				<td><?php echo $equipos[2]; ?></td>
				<td><?php echo $equipos[3]; ?></td>
				<td><?php echo $equipos[4]; ?></td>
			</tr>
			<tr>
				<td><input type="image" value="5" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/azules.png'; ?>" class="escudos" alt="Azules"></td>
				<td><input type="image" value="6" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/rosas.png'; ?>" class="escudos" alt="Rosas"></td>
				<td><input type="image" value="7" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/naranjas.png'; ?>" class="escudos" alt="Naranjas"></td>
				<td><input type="image" value="8" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/amarillos.png'; ?>" class="escudos" alt="Amarillos"></td>
			</tr>
			<tr>
				<td><?php echo $equipos[5]; ?></td>
				<td><?php echo $equipos[6]; ?></td>
				<td><?php echo $equipos[7]; ?></td>
				<td><?php echo $equipos[8]; ?></td>
			</tr>
	   	

		<!-- <tr><?php if($error): ?>
	   	<td>¡Error!</td>
	  	<?php endif; ?></tr> -->	

		</table>
		<div class="buttons"><?php echo CHtml::radioButtonList('ocup', $seleccionado, $equipos); ?></div>		
	</div>
	<div><?php echo CHtml::submitButton('Siguiente',array('class'=>"button large black")); ?></div>
</div>
<?php $this->endWidget(); ?>
</div>