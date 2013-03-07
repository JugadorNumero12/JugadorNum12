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
	    <td><?php echo $form->textField($email,'contenido'); ?></td>
	  </tr>
	  <tr>
	    <td><?php echo $form->error($email,'contenido'); ?></td>
	  </tr>

	   <tr>
	    <td >
	    	<?php echo CHtml::submitButton('env',array('class'=>"button large black"));?>
	    </td>
	   
	  </tr>

</table>
 <?php $this->endWidget(); ?>