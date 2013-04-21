<?php
// @var $habilidad
// @var $participacion
// @var $accion

// codigo PHP

?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'acciones-grupales-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
				'validateOnSubmit'=>true,),
			    ));
?>


<h1>Participar en: <?php echo $habilidad['nombre']; ?> </h1>

<img alt="imagen habilidad" src="<?php echo Yii::app()->BaseUrl ?>/images/habilidades/<?php echo $habilidad['token'] ?>.png"  width="128" height="128"/> </div>

<div class="meter">
    <span class="s1" style="width:<?php echo (($accion->dinero_acc + $accion->animo_acc + $accion->influencias_acc)/ ($accion->habilidades->dinero_max + $accion->habilidades->animo_max + $accion->habilidades->influencias_max))*100; ?>%"></span>
</div>

<table cellspacing="5px">
	  <tr>
	    <td ><b><?php echo $form->labelEx($participacion,'Dinero'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'dinero_nuevo',array('value'=>0)); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($participacion,'dinero_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td ><b><?php echo $form->labelEx($participacion,'Animo'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'animo_nuevo',array('value'=>0)); ?></td>
	  </tr>
	  <tr>
	    <td ><?php echo $form->error($participacion,'animo_nuevo'); ?></td>
	  </tr>
	  <tr>
	    <td ><b><?php echo $form->labelEx($participacion,'Influencia'); ?>:</b></td>
	    <td><?php echo $form->textField($participacion,'influencia_nueva',array('value'=>0)); ?></td>
	  </tr>
	  <tr>
	    <td ><?php echo $form->error($participacion,'influencia_nueva'); ?></td>
	  </tr>
</table>
	<td><?php echo CHtml::submitButton('Participar',array('class'=>"button large black")); ?></td>
	<td><?php echo CHtml::button('Volver', array('class'=>"button large black", 'onclick' => "history.go(-1);return false")); ?></td>

	<br>
	<br>
	<div class="encabezado2"> <h3>Recursos añadidos hasta ahora</h3> </div>
		<div class="recursos-aniadidos">
			<table class="tablas-acciones-ver">
				<tr><th>Dinero: </th><td><?php echo $accion['dinero_acc'];?> / <?php echo $accion['habilidades']['dinero_max']; ?> </td></tr>
				<tr><th>&Aacute;nimo: </th><td><?php echo $accion['animo_acc'];?> / <?php echo $accion['habilidades']['animo_max']; ?> </td></tr>
				<tr><th>Influencias: </th><td><?php echo $accion['influencias_acc'];?> / <?php echo $accion['habilidades']['influencias_max']; ?> </td></tr>
			</table>
	</div>
	<br>
	<table class="participantes"><tr><th>N&uacute;mero de participantes actuales:</th><td><?php echo $accion['jugadores_acc'].'/'.$habilidad['participantes_max']; ?></td></tr></table>

<?php $this->endWidget(); ?>
