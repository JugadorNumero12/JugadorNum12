<?php 
/*
@var $equipos lista de equipos
@var $seleccionado equipo elegido por el usuario
 */
?>
<?php
	Helper::registerStyleFile('registroEquipo');
/*
	Yii::app()->clientScript->registerLinkTag(
		'stylesheet/less', 'text/css', 
		Yii::app()->request->baseUrl . '/less/registroEquipo.less'
	);
	*/
?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsRegistro.js'); ?>
<div class="envoltorio-elegir-equipo">

<div class="contenido-elegir-equipo">
	<h3>ELIJA UN EQUIPO</h3>
	<div class="descripcion">Pulse en el escudo de su equipo favorito y haga click en siguiente. </div>

	<!-- Tabla con 2 filas y 4 columnas por fila -> 8 equipos -->	
	<div class="elegir-equipo">
		<table>
			<tr>
                <!-- rojos verdes negros blancos -->
				<td><input type="image" value="1" onclick="$(this).setIdEquipo(this.value)" title="Se acerca tu derrota. Somos los Black Starks." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/negros.png'; ?>" class="escudos" alt="Negros"></td>
				<td><input type="image" value="2" onclick="$(this).setIdEquipo(this.value)" title="Somos los Hijos de Thor. Ap&aacute;rta de nuestro camino." src="<?php echo Yii::app()->BaseUrl.'/images/escudos/verdes.png'; ?>" class="escudos" alt="Verdes"></td>
				<td><input type="image" value="3" onclick="$(this).setIdEquipo(this.value)" title="Tiembla antes los furiosos Osos Blancos" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/blancos.png'; ?>" class="escudos" alt="Blancos"></td>
				<td><input type="image" value="4" onclick="$(this).setIdEquipo(this.value)" title="¿C&oacute;mo quieres que te humille?" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/azules.png'; ?>" class="escudos" alt="Azules"></td>
			</tr>
			<tr>
				<td><?php echo $equipos[1]; ?></td>
				<td><?php echo $equipos[2]; ?></td>
				<td><?php echo $equipos[3]; ?></td>
				<td><?php echo $equipos[4]; ?></td>
			</tr>
			<tr>
                <!-- azules rosas naranjas amarillos -->
				<td><input type="image" value="5" onclick="$(this).setIdEquipo(this.value)" title="¡Embiste! ¡Destruye!" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/rosas.png'; ?>" class="escudos" alt="Rosas"></td>
				<td><input type="image" value="6" onclick="$(this).setIdEquipo(this.value)" title="¡Corred ardillas corred!" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/naranjas.png'; ?>" class="escudos" alt="Naranjas"></td>
				<td><input type="image" value="7" onclick="$(this).setIdEquipo(this.value)" title="Yellow submarine" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/amarillos.png'; ?>" class="escudos" alt="Amarillos"></td>
				<td><input type="image" value="8" onclick="$(this).setIdEquipo(this.value);" title="¡Vuela alto! ¡Vuela rápido! ¡Vuela como un &Aacute;guila roja!" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/rojos.png'; ?>" class="escudos" alt="Rojos"/></td>
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
		<?php
		$form = $this->beginWidget('CActiveForm', array(
				'id'=>'equipos-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 		?>
		<?php echo CHtml::hiddenfield('ocup', $seleccionado, array('value'=>'1','uncheckValue'=>null)); ?>
				
	</div>
	<div><?php echo CHtml::submitButton('Siguiente',array('class'=>"button large black")); ?></div>
</div>
<?php $this->endWidget(); ?>
</div>