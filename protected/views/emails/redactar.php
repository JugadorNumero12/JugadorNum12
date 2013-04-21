<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'emails-form',
			    'enableAjaxValidation'=>true,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>

<h1> Redactar mensaje </h1>

<?php if($destinatario != "") $email->nombre=$destinatario; if($tema != "")	$email->asunto=$tema; ?>


<div class="recuadro">
<table class="tam-tablas">
	<tr>
		<td class="col-izq"> From:</td>
		<td class="col-dcha"> <?php echo $nombre_usuario; ?></td>
 	</tr>
 	<tr>
		<td class="col-izq"> <?php echo $form->labelEx($email,'to'); ?>:</td>
		<td class="col-dcha"> <?php echo $form->textField($email,'nombre'); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq" colspan="2"> <?php echo $form->error($email,'nombre'); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq"> <?php echo $form->labelEx($email,'Asunto:'); ?></td>
		<td class="col-dcha"> <?php echo $form->textField($email,'asunto',array('size' => 70, 'maxlength' => 100)); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq" colspan="2" colspan="2"> <?php echo $form->error($email,'asunto'); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq"> <?php echo $form->labelEx($email,'Mensaje:'); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq" colspan="2"> <?php echo $form->textArea($email,'contenido',array('maxlength' => 300, 'rows' => 8, 'cols' => 77)); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq" colspan="2"> <?php echo $form->error($email,'contenido'); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq"> <?php echo CHtml::submitButton('Enviar',array('class'=>"button small black"));?></td>
 	</tr>

</table>

</div>

<br> <br>
<table> 
<tr> 
	<td><?php  echo CHtml::link('Bandeja de entrada',array('emails/index'),array('class'=>"button small black")); ?> </td>
	<td> &nbsp; &nbsp; &nbsp; </td>
	<td> <?php  echo CHtml::link('Bandeja de salida',array('emails/enviados'),array('class'=>"button small black")); ?></td>
</tr>
</table>

 <?php $this->endWidget(); ?>