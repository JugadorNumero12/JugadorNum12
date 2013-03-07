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
  <tr>
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
	    	<?php echo CHtml::button('Bandeja de entrada', array('submit' => array('emails/'),'class'=>"button small black")); ?> 
			<?php echo CHtml::button('Enviados', array('submit' => array('emails/enviados'),'class'=>"button small black")); ?> 

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