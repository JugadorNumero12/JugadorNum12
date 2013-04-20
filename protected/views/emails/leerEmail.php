<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'emails-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>

<h1> Leer mensaje </h1>

<div class="recuadro">
<table class="tam-tablas">
	<tr>
		<td class="col-izq"> From:</td>
		<td class="col-dcha"> <?php echo $from; ?> </td>  <td><?php echo Yii::app()->dateFormatter->formatDateTime($email->fecha, 'medium', 'short'); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq"> To:</td>
		<td class="col-dcha"> <?php echo $to; ?></td>
 	</tr>
 	<tr>
		<td class="col-izq"> Asunto:</td>
		<td class="col-dcha"> <?php echo $email->asunto; ?></td>
 	</tr>
 	<tr>
		<td class="col-izq"> Mensaje:</td>
 	</tr>
 	<tr>
		<td class="col-izq" colspan="2"> <p><?php echo nl2br($email->contenido); ?></p></td>
 	</tr>
 	<tr>
		<td class="col-izq"> <?php echo CHtml::button('Responder', array('submit' => array('emails/redactar', 'destinatario'=>$from, 'tema'=>$email->asunto),'class'=>"button small black")); ?></td>
		<td class="col-dcha"> <div class="alinear-derecha"><?php echo CHtml::button('Borrar', array('submit' => array('emails/eliminarEmail', 'id'=>$email->id_email,'antes'=>'entrada'),'class'=>"button small black")); ?></div></td>
 	</tr>

</table>

</div>

<br> <br>
<table> 
<tr> 
	<td><?php  echo CHtml::link('Bandeja de entrada',array('emails/index'),array('class'=>"button small black")); ?> </td>
	<td> &nbsp; &nbsp; &nbsp; </td>
	<td><?php echo CHtml::button('Bandeja de salida', array('submit' => array('emails/enviados'),'class'=>"button small black")); ?> </td>
</tr>
</table>

 <?php $this->endWidget(); ?>