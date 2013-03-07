<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'emails-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>


<?php
	echo $from;
	echo $to;
	echo Yii::app()->dateFormatter->formatDateTime($email->fecha, 'medium', 'short');
	echo $email->asunto;
	echo $email->contenido;
?>

<br> <br>
<?php echo CHtml::button('Redactar mensaje', array('submit' => array('emails/redactar'),'class'=>"button small black")); ?> <br> <br>
<?php echo CHtml::button('Bandeja de entrada', array('submit' => array('emails/'),'class'=>"button small black")); ?> <br> <br>

 <?php $this->endWidget(); ?>