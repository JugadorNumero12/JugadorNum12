<?php
/* @var ejemplo de variable dada por el controlador */
/* @var ejemplo de variable dada por el controlador */

// codigo PHP

?>

<!-- codigo HTML -->
<div id="info-previa">
	<div id="info-equipos">
		<div id="escudo-equipo">	
			<img src="<?php echo Yii::app()->BaseUrl . '/images/escudos/96px/' . $modeloL->token . '.png' ?>" height="100px" />	
		</div>
		<div id="info-equipo">
			<div id="nombre-equipo">	
			<?php echo strtoupper($modeloL->nombre); ?>	
			</div>
		</div>
		<div id="info-equipo">
			<div id="nombre-equipo">	
			<?php echo strtoupper($modeloV->nombre); ?>	
			</div>
		</div>
		<div id="escudo-equipo">
			<img src="<?php echo Yii::app()->BaseUrl . '/images/escudos/96px/' . $modeloV->token . '.png' ?>" height="100px" />	
		</div>
	</div>
	<div id="info-hora"><b>Ambiente:</b> <?php echo $modeloP->ambiente;; ?></div>
</div>

<table class="tabla-general">
	<tr>
		<th colspan="3">Datos del partido</th>
	</tr> 
	<tr>
		<th>Nivel local</th>
		<th></th>
		<th>Nivel visitante</th>
	</tr> 
	<tr>
		<td align="center" class="columna"><?php echo $modeloP->nivel_local; ?></td>
		<td align="center" class="meter">
			<span class="s1" style="width:<?php echo ($modeloP->nivel_local/($modeloP->nivel_local+$modeloP->nivel_visitante+0.01))*100; ?>%"></span>
			<span class="s2" style="width:<?php echo ($modeloP->nivel_visitante/($modeloP->nivel_local+$modeloP->nivel_visitante+0.01))*100; ?>%"></span>
		</td>
		<td align="center" class="columna"><?php echo $modeloP->nivel_visitante; ?></td>
	</tr>	
	<tr>
		<th>Aforo local</th>
		<th></th>
		<th>Aforo visitante</th>
	</tr> 
	<tr>
		<td align="center" class="columna"><?php echo $modeloP->aforo_local; ?></td>
		<td align="center" class="meter">
			<span class="s1" style="width:<?php echo ($modeloP->aforo_local/($modeloP->aforo_local+$modeloP->aforo_visitante+0.01))*100; ?>%"></span>
			<span class="s2" style="width:<?php echo ($modeloP->aforo_visitante/($modeloP->aforo_local+$modeloP->aforo_visitante+0.01))*100; ?>%"></span>
		</td>
		<td align="center" class="columna"><?php echo $modeloP->aforo_visitante; ?></td>
	</tr>	
	<tr>
		<th colspan="3">Cr&oacute;nica del encuentro</th>
	</tr> 
	<tr>
		<td colspan="3" style="background-color: #edf2fa"><pre width="90"><?php echo $modeloP->cronica ?></pre></td>
	</tr>
</table>