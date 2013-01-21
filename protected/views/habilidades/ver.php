<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

?>

<div class="envoltorio-ver-habilidad">
	<table class = 'tabla-ver-habilidad'>
		<tr>
			<h1><?php echo $habilidad['nombre']; ?></h1>
		</tr>

		<div class = 'separador'><tr>
			<?php echo '<b>Descripci&oacute;n: </b>'; echo $habilidad['descripcion']; ?>
		</tr></div>

		<div class = 'separador'><tr>
			<?php echo '<b>Tipo habilidad: </b>'; 
			switch ($habilidad['tipo']){
				case Habilidades::TIPO_INDIVIDUAL:
					echo 'Acci&oacute;n individual.';
				  break;
				case Habilidades::TIPO_GRUPAL:
				  	echo 'Acci&oacute;n grupal.';
				  break;
				case Habilidades::TIPO_PARTIDO:
				  	echo 'Acci&oacute;n de partido.';
				  break;
				case Habilidades::TIPO_PASIVA:
				  	echo 'Acci&oacute;n pasiva.';
				  break;
			}
			?>
		</tr></div>

		<div class="separador"><tr>
			<?php echo '<b>Recursos necesarios para activar la habilidad: </b>'?>
			<?php printf('<b>Dinero: </b>%d <b>&Aacute;nimo</b>: %d <b>Influencias: </b>%d', $habilidad['dinero'], $habilidad['animo'], $habilidad['influencias']); ?>
		</tr></div>


		<div class ="separador"><tr>
			<?php 
				if($habilidad['tipo'] == Habilidades::TIPO_GRUPAL){
					printf('<b>N&uacute;mero m&aacute;ximo de participantes: </b>%d',$habilidad['participantes_max']);
			?>
		</tr></div>	

		<div class ="separador"><tr>
			<?php echo '<b>Valores m&aacute;ximos que los recursos pueden sumar: </b>';
			printf('<b>Dinero: </b>%d <b>&Aacute;nimo</b>: %d <b>Influencias: </b>%d', $habilidad['dinero_max'], $habilidad['animo_max'], $habilidad['influencias_max']);
			}
			?>
		</tr></div>

		<div class="separador"><tr>
			<?php
				if($habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL || 
					$habilidad['tipo'] == Habilidades::TIPO_PARTIDO || 
					$habilidad['tipo'] == Habilidades::TIPO_GRUPAL){
					printf('<b>Cooldown: </b>%d',$habilidad['cooldown_fin']);
				}
			?>
		</tr></div>

		<div class="boton-mensaje"><tr>
			<?php
				if ($desbloqueada){ ?>
					<div class="mensaje-adquirido"> <?php echo "Ya has adquirido esta habilidad"; ?></div>
				<?php } else { ?>
					<div class="boton-adquirir"> <?php echo CHtml::button('Adquirir habilidad', array('submit' => array('habilidades/adquirir', 'id_habilidad'=>$habilidad['id_habilidad']),'class'=>"button small black")); ?> </div>
				<?php }
			?>
		</tr></div>

	</table>
</div>