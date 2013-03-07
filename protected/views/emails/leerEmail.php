<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'emails-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>

<h1>boton redactar</h1> 
<h1>boton recibidos</h1>
<?php
	echo $from;
	echo $to;
	echo Yii::app()->dateFormatter->formatDateTime($email->fecha, 'medium', 'short');
	echo $email->asunto;
	echo $email->contenido;
?>

 <?php $this->endWidget(); ?>