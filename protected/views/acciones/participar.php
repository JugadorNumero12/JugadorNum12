<?php
// @var $habilidad
// @var $datosAccion

// codigo PHP

?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'clave-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
				'validateOnSubmit'=>true,),
			    ));
?>

<h1>Participar en la acción grupal: <?php echo $habilidad['nombre']; ?></h1>
<h2> Aportar recursos </h2>

<form action="<?php echo $this->createUrl('acciones/participar');?>" method="post">
	<label> 
		<b> Dinero: </b>
		<input type="text" name="dinero" value=0 />
	</label>

	<label>
		<b> Animo: </b>
		<input type="text" name="animo" value=0 />
	</label>

	<label>
		<b> Influencia: </b>
		<input type="text" name="influencias" value=0 />
	</label>

	<input type="submit" value="Participar"/>
</form>

<?php $this->endWidget(); ?>