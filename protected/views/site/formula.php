<?php
/**
 * Las matrices devueltas por el controlador son tales que la posición [i][j]
 * contiene el valor asignado a "estado actual i, estado siguiente j".
 * Es decir, $probs[i][j] contendrá la probabilidad de ir del estado i
 * (actual) al estado j (sigueinte).
 *
 * @var $probs Matriz de probabilidades
 * @var $pesos Matriz de pesos
 * @var $colors Matriz con los colores de las celdas según probabilidad
 * @var $params Parámetros usados en la última petición
 */
?>
<table id="la-formula" style="font-size: 9px">
	<tr>
		<th>La F&oacute;rmula</th>
		<?php foreach ( $probs[0] as $i=>$v ): ?>
			<th><?php echo $i ?></th>
		<?php endforeach ?>
	</tr>

	<?php foreach ( $probs as $i=>$v ): ?>
	<tr>
		<th><?php echo $i ?></th>

		<?php foreach ( $probs[$i] as $j=>$p ):?>
			<td style="text-align: center; background-color: <?php echo $colors[$i][$j] ?>">
				<?php echo round($p*100, 1) ?>%<br/>(<?php echo (int) $pesos[$i][$j] ?>)
			</td>
		<?php endforeach ?>
	</tr>
<?php endforeach ?>
</table>