<?php
	Yii::app()->clientScript->registerLinkTag(
		'stylesheet/less', 'text/css', 
		Yii::app()->request->baseUrl . '/less/partido.less'
	);
	Yii::app()->clientScript->registerScript('partidos-data',
		'if(!partido)partido = {};partido.tiempo='
		. $partido->tiempoRestantePartido()
		. ';partido.tiempoTurno='
		. $partido->tiempoRestanteTurno()
		. ';');
?>
<div id="partido-dibujo" class="inner-block">
	Dibujo del partido aquí
</div>

<!-- Marcador e información de los equipos y el estadio -->
<div id="partido-marcador" class="inner-block">
	<!-- Información general -->
	<div id="partido-marcador-general">
		<div id="partido-goles"><?php echo $partido->goles_local ?>&nbsp;&nbsp;&nbsp;&nbsp;&ndash;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $partido->goles_visitante ?></div>
		<div id="partido-tiempo">12:34</div>
		<div id="partido-tiempo-turno">01:23</div>
		<div id="partido-ambiente"><?php echo $partido->ambiente ?></div>
	</div>

	<!-- Información del equipo local -->
	<div id="partido-equipo-local">
		<div class="equipo-info equipo-nombre"><?php echo $eqLoc->nombre ?></div>
		<div class="equipo-info equipo-escudo"><img src="<?php
			echo Yii::app()->BaseUrl . '/images/escudos/96px/' . $eqLoc->token . '.png' ?>" height="96"/></div>
		<div class="equipo-info equipo-nivel">Nivel <?php echo $eqLoc->nivel_equipo ?></div>
		<div class="equipo-info equipo-aforo"><?php echo $partido->aforo_local ?> asistentes</div>
	</div>

	<!-- Información del equipo visitante -->
	<div id="partido-equipo-visit">
		<div class="equipo-info equipo-nombre"><?php echo $eqVis->nombre ?></div>
		<div class="equipo-info equipo-escudo"><img src="<?php
			echo Yii::app()->BaseUrl . '/images/escudos/96px/' . $eqVis->token . '.png' ?>" height="96" /></div>
		<div class="equipo-info equipo-nivel">Nivel <?php echo $eqVis->nivel_equipo ?></div>
		<div class="equipo-info equipo-aforo"><?php echo $partido->aforo_visitante ?> asistentes</div>
	</div>
</div>

<div id="equipo-info">
	<nav id="equipo-info-tabs">

	</nav>
	<div id="equipo-info-content">

	</div>
</div>
