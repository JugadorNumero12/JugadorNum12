<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'emails-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>

<h3>boton redactar<h3>
<h3>boton recibidos<h3>
<?php foreach ( $emails as $i=>$email ){ 
	//en funcion de si se ha leido o no que muestre un color diferente o lo que sea
	echo $niks[$i];
	echo $email->asunto;
	echo $email->fecha;
	echo CHtml::button('Leer', array('submit' => array('emails/leerEmail', 'id'=>$email->id_email),'class'=>"button small black"));
}?>

 <?php $this->endWidget(); ?>