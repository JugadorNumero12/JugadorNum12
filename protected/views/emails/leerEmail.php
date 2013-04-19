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
		<td class="col-dcha"> <?php echo $from; ?></td>
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
		<td class="col-izq" colspan="2"> <?php echo $form->labelEx($email,$email->contenido,array('maxlength' => 300, 'rows' => 8, 'cols' => 3)); ?></td>
 	</tr>
 	<tr>
		<td class="col-izq"> <?php echo CHtml::button('Responder', array('submit' => array('emails/redactar', 'destinatario'=>$from, 'tema'=>$email->asunto, 'equipo'=>false),'class'=>"button small black")); ?></td>
 	</tr>

</table>

</div>

<div class="recuadro">
<table class="tam-tablas">
	<tr>
		<td class="col-izq"> From:</td>
		<td class="col-dcha"> <?php echo $from; ?></td>
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

</table>

	<div class="texto-mensaje"> <p>dsfsdflhdsklhnkvjhlorhgkjlhdfkghkdfljghkdfjgkljkdfjñlhñuohrgfkjndfkljhgkñldfshgñfdhsklhdfhdfnkvljchkkjcxhvkjlbhskljdfhgkjhadsklkldfjklhufdnmldfkjhgldfhlkjhj</p></div>

<table>
 	<tr>
		<td class="col-izq"> <?php echo CHtml::button('Responder', array('submit' => array('emails/redactar', 'destinatario'=>$from, 'tema'=>$email->asunto, 'equipo'=>false),'class'=>"button small black")); ?></td>
 	</tr>

</table>

</div>

<br> <br> <br> <br> <br>
 
<table>
	<tr> <th>Remitente </th> <th> Destinatario </th> <th> Asunto </th> <th> Fecha </th> <th> &nbsp; </th> </tr>

	<tr> 
		<td> <?php echo $from; ?> </td> 
		<td> <?php echo $to; ?> </td> 
		<td> <?php echo $email->asunto; ?> </td> 
		<td> <?php echo Yii::app()->dateFormatter->formatDateTime($email->fecha, 'medium', 'short'); ?> </td> 
	</tr>

	<tr>
		<th>Contenido :  </th>
		<th> <?php echo $email->contenido; ?> </th>
	</tr>
</table>

<?php echo CHtml::button('Responder', array('submit' => array('emails/redactar', 'destinatario'=>$from, 'tema'=>$email->asunto, 'equipo'=>false),'class'=>"button small black")); ?>
<?php echo CHtml::button('Borrar', array('submit' => array('emails/eliminarEmail', 'id'=>$email->id_email,'antes'=>'entrada'),'class'=>"button small black")); ?>
<?php echo CHtml::button('Redactar mensaje', array('submit' => array('emails/redactar' , 'destinatario'=>"",'tema'=>"", 'equipo'=>false),'class'=>"button small black")); ?>
<?php echo CHtml::button('Bandeja de entrada', array('submit' => array('emails/'),'class'=>"button small black")); ?>
<?php echo CHtml::button('Bandeja de salida', array('submit' => array('emails/enviados'),'class'=>"button small black")); ?>

 <?php $this->endWidget(); ?>