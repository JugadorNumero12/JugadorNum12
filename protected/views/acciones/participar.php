<?php
// @var $habilidad
// @var $participacion
// @var $accion

// codigo PHP

?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
				'id'=>'acciones-grupales-form',
			    'enableAjaxValidation'=>false,
			    'enableClientValidation'=>true,
			    'clientOptions'=>array(
				'validateOnSubmit'=>true,),
			    ));
?>


<h1>Participar en: <?php echo $habilidad['nombre']; ?> </h1>


<img alt="imagen habilidad" src="<?php echo Yii::app()->BaseUrl ?>/images/habilidades/<?php echo $habilidad['token'] ?>.png"  width="128" height="128"/> </div>

<div class="barra-global">
	<p> Progreso total </p>
	<div class="meter">
	    <span class="s1" style="width:<?php echo (($accion->dinero_acc + $accion->animo_acc + $accion->influencias_acc)/ ($accion->habilidades->dinero_max + $accion->habilidades->animo_max + $accion->habilidades->influencias_max))*100; ?>%"></span>
	</div>
</div>


<table class="tabla-izq"> 
	<tr>
		<td> Dinero: </td> 
		<td> <div class="meter-aux"> <span class="s1" style="width:<?php echo ($accion->dinero_acc / $accion->habilidades->dinero_max)*100; ?>%"></span> </div> </td> 
		<td><?php echo $accion['dinero_acc'];?> / <?php echo $accion['habilidades']['dinero_max']; ?> </td>
	</tr>
	<tr>
		<td> Animo: </td> 
		<td><div class="meter-aux"> <span class="s1" style="width:<?php echo ($accion->animo_acc / $accion->habilidades->animo_max)*100; ?>%"></span> </div></td>
		<td><?php echo $accion['animo_acc'];?> / <?php echo $accion['habilidades']['animo_max']; ?> </td>
	</tr>
	<tr>
		<td> Influencia: </td> 
		<td> <div class="meter-aux"> <span class="s1" style="width:<?php echo ($accion->influencias_acc / $accion->habilidades->influencias_max)*100; ?>%"></span> </div> </td>
		<td><?php echo $accion['influencias_acc'];?> / <?php echo $accion['habilidades']['influencias_max']; ?> </td>
	</tr>
</table>

<?php if($accion->completada == 0){?>
	<table class="tabla-dcha">
		  <tr>
		    <td ><?php echo $form->labelEx($participacion,'Dinero'); ?>:</td>
		    <td><?php echo $form->textField($participacion,'dinero_nuevo',array('value'=>0)); ?></td>
		  </tr>
		  <tr>
		    <td><?php echo $form->error($participacion,'dinero_nuevo'); ?></td>
		  </tr>
		  <tr>
		    <td ><?php echo $form->labelEx($participacion,'Animo'); ?>:</td>
		    <td><?php echo $form->textField($participacion,'animo_nuevo',array('value'=>0)); ?></td>
		  </tr>
		  <tr>
		    <td ><?php echo $form->error($participacion,'animo_nuevo'); ?></td>
		  </tr>
		  <tr>
		    <td ><?php echo $form->labelEx($participacion,'Influencia'); ?>:</td>
		    <td><?php echo $form->textField($participacion,'influencia_nueva',array('value'=>0)); ?></td>
		  </tr>
		  <tr>
		    <td ><?php echo $form->error($participacion,'influencia_nueva'); ?></td>
		  </tr>
	</table>

	<table>
		<td><?php echo CHtml::submitButton('Participar',array('class'=>"button large black")); ?></td>
		<td> &nbsp; &nbsp; &nbsp; </td>
		<td><?php echo CHtml::button('Volver', array('class'=>"button large black", 'onclick' => "history.go(-1);return false")); ?></td>
	<table>

<br>
<table>
	<tr>
		<th>
			N&uacute;mero de participantes actuales:
		</th>
		<td>
			<?php echo $accion['jugadores_acc'].'/'.$habilidad['participantes_max']; ?>
		</td>
	</tr>
	<tr>
		<th>
			Tiempo restante para completarla:
		</th>
		<td>
			<?php $t_fin = 0;
				$t_fin = $accion['finalizacion'] - time();
				if ($t_fin < 0) $t_fin = 0;
			printf( '%02d h &nbsp; %02d m &nbsp; %02d s', $t_fin / 3600, $t_fin / 60 % 60, $t_fin % 60 ); ?>
		</td>
	</tr>
</table>

<?php } else {?>
		<table class="tabla-dcha">  <tr> <td>Acción completada. Por favor, participa en otra. </td> </tr> </table>
		<table>  <tr> <td><?php echo CHtml::button('Volver', array('class'=>"button large black", 'onclick' => "history.go(-1);return false")); ?> </td> </tr> </table>

	<?php }?>	


	

<?php $this->endWidget(); ?>
