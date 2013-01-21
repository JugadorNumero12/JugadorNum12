<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

?>

<div class="envoltorio-ver-habilidad">

	<h1><?php echo $habilidad['nombre']; ?></h1>

	<div class="separador">
		<?php echo '<b>Descripción: </b>'; echo $habilidad['descripcion']; ?>
	</div>

	<div class="separador">
		<?php echo '<b>Tipo habilidad: </b>'; 
			switch ($habilidad['tipo']){
				case Habilidades::TIPO_INDIVIDUAL:
					echo 'Acción individual.';
				  break;
				case Habilidades::TIPO_GRUPAL:
				  	echo 'Acción grupal.';
				  break;
				case Habilidades::TIPO_PARTIDO:
				  	echo 'Acción de partido.';
				  break;
				case Habilidades::TIPO_PASIVA:
				  	echo 'Acción pasiva.';
				  break;
			}
		?>
	</div>

	<div class="separador">
		<?php echo '<b>Recursos necesarios para activar la habilidad: </b>'?>
		<?php printf('<b>Dinero: </b>%d <b>Animo</b>: %d <b>Influencias: </b>%d', $habilidad['dinero'], $habilidad['animo'], $habilidad['influencias']); ?>
	</div>



	<div class ="separador">
		<?php 
		if($habilidad['tipo'] == Habilidades::TIPO_GRUPAL){
			printf('<b>Número máximo de participantes: </b>%d',$habilidad['participantes_max']);?>
	</div>	



	<div class ="separador">
			<?php echo '<b>Valores máximos que los recursos pueden sumar: </b>';
			printf('<b>Dinero: </b>%d <b>Animo</b>: %d <b>Influencias: </b>%d', $habilidad['dinero_max'], $habilidad['animo_max'], $habilidad['influencias_max']);
		}
		?>
	</div>



	<div class="separador">
		<?php
		if($habilidad['tipo'] == Habilidades::TIPO_INDIVIDUAL || 
			$habilidad['tipo'] == Habilidades::TIPO_PARTIDO || 
			$habilidad['tipo'] == Habilidades::TIPO_GRUPAL){
			printf('<b>Cooldown: </b>%d',$habilidad['cooldown_fin']);
		}
	?>
	</div>
</div>