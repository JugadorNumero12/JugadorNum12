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

<?php echo CHtml::button('Responder', array('submit' => array('emails/redactar', 'destinatario'=>$from, 'tema'=>$email->asunto),'class'=>"button small black")); ?>
<?php echo CHtml::button('Borrar', array('submit' => array('emails/eliminarEmail', 'id'=>$email->id_email,'antes'=>'entrada'),'class'=>"button small black")); ?>
<?php echo CHtml::button('Redactar mensaje', array('submit' => array('emails/redactar' , 'destinatario'=>"",'tema'=>""),'class'=>"button small black")); ?>
<?php echo CHtml::button('Bandeja de entrada', array('submit' => array('emails/'),'class'=>"button small black")); ?>
<?php echo CHtml::button('Bandeja de salida', array('submit' => array('emails/enviados'),'class'=>"button small black")); ?>

 <?php $this->endWidget(); ?>