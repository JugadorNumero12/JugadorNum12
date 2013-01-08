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

<form action="<?php $this->createUrl('site/formula'); ?>" method="get">
	<label> 
		<b> Diferencia niveles: </b>
		<input type="text" name="dn" value="0" />
	</label>
	<br>
	<label> 
		<b> Aforo local: </b>
		<input type="text" name="al" value="0" />
	</label>

	<label> 
		<b> Aforo visitante: </b>
		<input type="text" name="av" value="0" />
	</label>
	<br>
	<label> 
		<b> Moral local: </b>
		<input type="text" name="ml" value="0" />
	</label>

	<label> 
		<b> Moral visitante: </b>
		<input type="text" name="mv" value="0" />
	</label>
	<br>
	<label> 
		<b> Factor ofensivo local: </b>
		<input type="text" name="ol" value="0" />
	</label>

	<label> 
		<b> Factor ofensivo visitante: </b>
		<input type="text" name="ov" value="0" />
	</label>
	<br>
	<label> 
		<b> Factor defensivo local: </b>
		<input type="text" name="dl" value="0" />
	</label>

	<label> 
		<b> Factor defensivo visitante: </b>
		<input type="text" name="dv" value="0" />
	</label>
	<br>
	<input type="submit" value="Simular"/>
</form>

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