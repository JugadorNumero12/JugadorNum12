<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'emails-form',
			    'enableAjaxValidation'=>true,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
					'validateOnSubmit'=>true,),
			    ));
 ?>

<h1> Redactar mensaje </h1>

<table>
  <tr>
  	<?php if($destinatario != "") $email->nombre=$destinatario; if($tema != "")	$email->asunto=$tema; ?> 
	    <td><?php echo $form->labelEx($email,'Nombre'); ?>:</td>
	    <td><?php echo $form->textField($email,'nombre'); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($email,'nombre'); ?></td>
	  </tr>

	  <tr>
	    <td><?php echo $form->labelEx($email,'Asunto'); ?>:</td>
	    <td><?php echo $form->textField($email,'asunto'); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($email,'asunto'); ?></td>
	  </tr>

	  <tr>
	    <td><?php echo $form->labelEx($email,'Contenido'); ?>:</td>
	    <td><?php echo $form->textArea($email,'contenido',array('maxlength' => 300, 'rows' => 8, 'cols' => 40)); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($email,'contenido'); ?></td>
	  </tr>

	   <tr>
	    <td >
	    	<?php echo CHtml::submitButton('Enviar',array('class'=>"button small black"));?>
	    </td>
	    <td >
	    	<?php  echo CHtml::link('Bandeja de entrada',array('emails/index'),array('class'=>"button small black")); ?>
	    	<?php  echo CHtml::link('Bandeja de salida',array('emails/enviados'),array('class'=>"button small black")); ?>
	    </td>
	   
	   </tr>

	  <tr> 
	  	<td> <h2> Jugadores de tu mismo equipo </h2> </td>
	</tr>

	
	  <?php foreach ($mi_aficion as $seguidor) { ?>
	  <tr> 
	  	<td> <h3> <?php echo $seguidor->nick; ?> </h3> </td>
	  <?php	} ?>
	</tr>


</table>

 <?php $this->endWidget(); ?>