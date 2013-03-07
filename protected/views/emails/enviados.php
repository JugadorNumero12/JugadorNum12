<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'emails-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>


<table>
	<tr> <th>Enviado a </th> <th> Asunto </th> <th> Fecha </th> <th> &nbsp; </th> </tr>

<?php foreach ( $emails as $i=>$email ){ ?>
	
	<tr> 
		<td> <?php echo $niks[$i]; ?> </td> 
		<td> <?php echo $email->asunto; ?> </td> 
		<td> <?php echo Yii::app()->dateFormatter->formatDateTime($email->fecha, 'medium', 'short'); ?> </td>  
		<td> <?php echo CHtml::button('Leer', array('submit' => array('emails/leerEmail', 'id'=>$email->id_email),'class'=>"button small black")); ?> </td> 
		<td> <?php echo CHtml::button('Borrar', array('submit' => array('emails/eliminarEmail', 'id'=>$email->id_email, 'antes'=>'salida'),'class'=>"button small black")); ?> </td> 
	</tr>
		
<?php }?>

</table>


<br> <br>
<?php echo CHtml::button('Redactar mensaje', array('submit' => array('emails/redactar'),'class'=>"button small black")); ?> <br> <br>
<?php echo CHtml::button('Bandeja de entrada', array('submit' => array('emails/'),'class'=>"button small black")); ?> <br> <br>

 <?php $this->endWidget(); ?>