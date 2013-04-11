<?php
/* @var $emails los emails recibidos*/
/* @var $niks usario que nos envio cada email*/

?>



<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'emails-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>

<h1> Bandeja de salida </h1>

<table>
	<tr> <th>Enviado por </th> <th> Asunto </th> <th> Fecha </th> <th> Le&iacute;do </th> <th> &nbsp; </th> </tr>

<?php foreach ( $emails as $i=>$email ){ ?>
	
	<tr> 
		<td> <?php echo $niks[$i]; ?> </td> 
		<td> <?php echo $email->asunto; ?> </td> 
		<td> <?php echo Yii::app()->dateFormatter->formatDateTime($email->fecha, 'medium', 'short'); ?> </td> 
		<td> <?php if ($email->leido == 0) {echo 'No';} else {echo 'Sí';}?> </td> 
		<td> <?php echo CHtml::button('Leer', array('submit' => array('emails/leerEmail', 'id'=>$email->id_email),'class'=>"button small black")); ?> </td> 
		<td> <?php echo CHtml::button('Borrar', array('submit' => array('emails/eliminarEmail', 'id'=>$email->id_email,'antes'=>'entrada'),'class'=>"button small black")); ?> </td>
	</tr>
		
<?php }?>

</table>

<br> <br>
<?php echo CHtml::button('Redactar mensaje', array('submit' => array('emails/redactar', 'destinatario'=>"" , 'tema'=>""),'class'=>"button small black")); ?> <br> <br>
<?php echo CHtml::button('Bandeja de salida', array('submit' => array('emails/enviados'),'class'=>"button small black")); ?> <br> <br>


 <?php $this->endWidget(); ?>