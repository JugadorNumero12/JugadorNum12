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

<h1> Bandeja de entrada </h1>

<table class="bandejas-mensajeria">
	<tr> <th> Enviado por  </th> <th> Asunto </th> <th> Fecha </th> <th> Le&iacute;do </th> <th> &nbsp;  </th>  <th> &nbsp; </th>  </tr> </table>


<table class="bandejas-mensajeria">
<?php foreach ( $emails as $i=>$email ){ ?>
	
	<tr> 
		<td> <p><?php echo $niks[$i]; ?></p> </td> 
		<td> <p><?php echo $email['asunto']; ?></p> </td> 
		<td> <p><?php echo Yii::app()->dateFormatter->formatDateTime($email['fecha'], 'medium', 'short'); ?> </p> </td> 
		<td> <?php if ($email['leido'] == 0) {echo 'No';} else {echo 'Sí';}?> </td> 
		<td> <?php echo CHtml::button('Leer', array('submit' => array('emails/leerEmail', 'id'=>$email['id_email']),'class'=>"button small black")); ?> </td> 
		<td> <?php echo CHtml::button('Borrar', array('submit' => array('emails/eliminarEmail', 'id'=>$email['id_email'],'antes'=>'entrada'),'class'=>"button small black")); ?> </td>
	</tr>
		
<?php }?>

</table>

<br>
<table> 
<tr> 
	<td><?php echo CHtml::button('Redactar mensaje', array('submit' => array('emails/redactar', 'destinatario'=>"" , 'tema'=>"" ,'equipo'=>false),'class'=>"button small black")); ?> </td>
	<td> &nbsp; &nbsp; &nbsp; </td>
	<td><?php echo CHtml::button('Bandeja de salida', array('submit' => array('emails/enviados'),'class'=>"button small black")); ?> </td>
</tr>
</table>




 <?php $this->endWidget(); ?>