<?php
/* @var $this UsuariosController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
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

<h3>boton redactar<h3>
<h3>boton enviados<h3>
<?php foreach ( $emails as $i=>$email ){ 
	echo $niks[$i];
	echo $email->asunto;
	echo $email->fecha;
}?>

 <?php $this->endWidget(); ?>