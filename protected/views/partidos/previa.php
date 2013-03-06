<?php
/* @var $modeloP*/
/* @var $modeloL */
/* @var $modeloV */
/* @var $modeloGL */
/* @var $modeloGV*/


?>

<!-- codigo HTML -->
<h3> INFORMACIÓN PREVIA AL PARTIDO</h3>

<table cellspacing="5px">
	<tr>
		<th>Hora del encuentro</th>
		<th>Ambiente</th>
	</tr> 
	<tr>
		<td align="center"><?php echo Yii::app()->format->formatDatetime($modeloP->hora) ?></td>
		<td align="center"><?php echo $modeloP->ambiente ?></td>
	</tr>
	<tr></tr>
</table>

<table cellspacing="5px">
	<tr>
		<th>Equipo local</th>
		<th>Nivel del equipo local</th>
		<th>Aforo del equipo local</th>
	</tr> 
	<tr>
		<td align="center"><?php echo $modeloL->nombre ?></td>
		<td align="center"><?php echo $modeloP->nivel_local ?></td>
		<td align="center"><?php echo $modeloP->aforo_local ?></td>
	</tr>
	<tr></tr>
</table>

<table cellspacing="5px">
	<tr>
		<th>Equipo visitante</th>
		<th>Nivel del equipo visitante</th>
		<th>Aforo del equipo visitante</th>
	</tr> 
	<tr>
		<td align="center"><?php echo $modeloV->nombre ?></td>
		<td align="center"><?php echo $modeloP->nivel_visitante ?></td>
		<td align="center"><?php echo $modeloP->aforo_visitante ?></td>
	</tr>
	<tr></tr>
</table>

<h3> ACCIONES GRUPALES DEL EQUIPO LOCAL</h3>

<?php foreach ( $modeloGL as $accionL ){ ?>
    <?php if($accionL->completada == 1){ ?> 
		<li> <?php echo $accionL->habilidades->nombre; ?>
		</li>
    <?php } ?> 
<?php } ?>

<h3> ACCIONES GRUPALES DEL EQUIPO VISITANTE</h3>

<?php foreach ( $modeloGV as $accionV ){ ?>
    <?php if($accionV->completada == 1){ ?> 
		<li> <?php echo $accionV->habilidades->nombre; ?>
		</li>
    <?php } ?> 
<?php } ?>
