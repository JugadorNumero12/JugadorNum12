<?php
/* @var $modeloP*/
/* @var $modeloL */
/* @var $modeloV */
/* @var $modeloGL */
/* @var $modeloGV*/

Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/acordeon.js');
?>

<!-- codigo HTML -->
<div id="info-previa">
	<div id="info-equipos">
		<div id="info-equipo">
			<div id="nombre-equipo">	
			<?php echo strtoupper($modeloL->nombre); ?>	
			</div>
		</div>
		<div id="escudo-equipo">	
			<img src="<?php echo Yii::app()->BaseUrl . '/images/escudos/96px/' . $modeloL->token . '.png' ?>" height="100px" />	
		</div>
		<div id="escudo-equipo">
			<img src="<?php echo Yii::app()->BaseUrl . '/images/escudos/96px/' . $modeloV->token . '.png' ?>" height="100px" />	
		</div>
		<div id="info-equipo">
			<div id="nombre-equipo">	
			<?php echo strtoupper($modeloV->nombre); ?>	
			</div>
		</div>
	</div>
	<div id="info-hora"><b>Inicio del encuentro:</b> <?php echo date('Y-m-d G:i', $modeloP->hora); ?>
						<br>
						<b>Ambiente:</b> <?php echo $modeloP->ambiente;; ?>
	</div>
</div>

<table class="tabla-general">
	<tr>
		<th colspan="3">Informaci&oacute;n previa del partido</th>
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
</table>

<div class="accordion" style="margin-top: 20px;">
    <h3 class="ui-accordion-header-active"><b>ACCIONES GRUPALES DEL EQUIPO LOCAL</b></h3>
    <div>
        <?php foreach ( $modeloGL as $accionL ){ ?>
		    <?php if($accionL->completada == 1){ ?> 
				<li> <?php echo $accionL->habilidades->nombre; ?>
				</li>
		    <?php } ?> 
		<?php } ?>		
    </div>
    <h3 class="ui-accordion-header-active"><b>ACCIONES GRUPALES DEL EQUIPO VISITANTE</b></h3>
    <div class="info-acciones">
		<?php foreach ( $modeloGV as $accionV ){ ?>
		    <?php if($accionV->completada == 1){ ?> 
				<li> <?php echo $accionV->habilidades->nombre; ?>
				</li>
		    <?php } ?> 
		<?php } ?>
    </div>
</div>
