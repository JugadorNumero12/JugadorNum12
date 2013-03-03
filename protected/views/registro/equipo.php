<?php 
/*@var $equipos lista de equipos */
?>

<div class="descripcion">Elija equipo: Lorem ipsum dolor sit amet, consectetur adipiscing elit. </div>

<!-- Tabla con 2 filas y 4 columnas por fila -> 8 equipos -->
<div class="elegir-equipo">
	<table>
		<tr>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-rojo.png'; ?>" class="escudos" alt="Rojos"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-verde.png'; ?>" class="escudos" alt="Verdes"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-negro.png'; ?>" class="escudos" alt="Negros"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-blanco.png'; ?>" class="escudos" alt="Blancos"></td>
		</tr>
		<tr>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-azul.png'; ?>" class="escudos" alt="Azules"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-rosa.png'; ?>" class="escudos" alt="Rosas"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-naranja.png'; ?>" class="escudos" alt="Naranjas"></td>
			<td><img title="Lorem ipsum dolor sit amet, consectetur adipiscing elit." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-blanco.png'; ?>" class="escudos" alt="Blancos"></td>
		</tr>		
	</table>
	<div><?php echo CHtml::submitButton('Siguiente',array('submit'=>array('/registro/personaje'),'class'=>"button large black")); ?></div>
</div>