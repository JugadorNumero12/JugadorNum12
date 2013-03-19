<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<div id="descripcion-login">
	<h1>Bienvenido a Jugador n&uacute;mero 12</h1>
	<p> </b>Un juego de estrategia multijugador, centrado en la gesti&oacute;n de pe&ntilde;as de aficionados.
  		Ponte en la piel de un hincha y organiza la afici&oacute;n de tu equipo para llevarlo a lo m&aacute;s alto.</br></b></p>
  	<p>
  		</br>
  	</p>
	<a href="<?php echo Yii::app()->createUrl('/registro/index', array());?>" class="button large black">Reg&iacute;strate</a>
</div>

<div id="grupo-derecha-login"> 

<div id="columna-vacia-central-login"> </div>

	<div id="entrada-login">
		<p>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'login-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?> 	
			<table cellspacing="5px">
			  <tr>
			    
			  </tr>
			  <tr>
			    <td align="center"><?php echo $form->labelEx($model,'Usuario'); ?>:</td>
			    <td><?php echo $form->textField($model,'username'); ?></td>
			  </tr>
			  <tr>
			  <tr>
			    <td align="center"><?php echo $form->labelEx($model,'Clave'); ?>:</td>
			    <td><?php echo $form->passwordField($model,'password'); ?></td>
			  </tr>
			  <tr>
			    <td colspan="2">			    	
			    	<div class="envoltorio-errores">
				  		<ul>
				    		<li><?php echo $form->error($model,'username'); ?></li>
				  			<li><?php echo $form->error($model,'password'); ?></li>
				  		</ul>
				  	</div>
			    </td>
			  </tr>
			  <tr>
			    <td colspan="2" align="center"><?php echo CHtml::submitButton('Entrar',array('class'=>"button large black"));?></td>
			  </tr>
			</table>
			<?php $this->endWidget(); ?>
		</p>
	</div>

</div>

	