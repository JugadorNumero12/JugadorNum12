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

<h3>boton redactar</h3> <br>
<h3>boton enviados</h3> <br>
<?php foreach ( $emails as $i=>$email ){ 
	//en funcion de si se ha leido o no que muestre un color diferente o lo que sea
	echo $niks[$i];
	echo $email->asunto;
	echo Yii::app()->dateFormatter->formatDateTime($email->fecha, 'medium', 'short');
	echo CHtml::button('Leer', array('submit' => array('emails/leerEmail', 'id'=>$email->id_email),'class'=>"button small black"));
}?>

 <?php $this->endWidget(); ?>