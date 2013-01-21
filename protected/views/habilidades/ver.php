<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

/*

			<td>Coste: </td>
				<td>Dinero: </td>
				<td><?php echo $habilidad['dinero']; ?></td>
				<td>&Aacute;nimo: </td>
				<td><?php echo $habilidad['animo']; ?></td>
				<td>Influencia: </td>
				<td><?php echo $habilidad['influencias']; ?></td>
*/

?>

<div class="envoltorio-ver-habilidad">

	<h1><?php echo 'Habilidad: '; echo $habilidad['nombre']; ?></h1>

	<div class="separador">
		<?php echo 'Descripción: '; echo $habilidad['descripcion']; ?>
	</div>

<div class="separador">
			<?php echo 'Tipo habilidad: '; switch ($habilidad['tipo']){
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
		?></div>
<div class='separador'>
</div>

</div>