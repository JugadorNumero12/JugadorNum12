<div id="partido-dibujo">
	Dibujo del partido aquí
</div>

<!-- Marcador e información de los equipos y el estadio -->
<div id="partido-marcador">
	<!-- Información general -->
	<div id="partido-marcador-general">
		<div id="partido-goles"><?php echo $partido->goles_local ?> - <?php echo $partido->goles_visitante ?></div>
		<div id="partido-tiempo">12:34</div>
		<div id="partido-tiempo-turno">01:23</div>
		<div id="partido-ambiente"><?php echo $partido->ambiente ?></div>
	</div>

	<!-- Información del equipo local -->
	<div id="partido-equipo-local">
		<div id="partido-nombre-local"><?php echo $eqLoc->nombre ?></div>
		<div id="partido-escudo-local"><img src="<?php
			echo Yii::app()->BaseUrl . '/images/escudos/' . $eqLoc->token . '.png' ?>" /></div>
		<div id="partido-nivel-local">Nivel <?php echo $eqLoc->nivel_equipo ?></div>
		<div id="partido-aforo-local"><?php echo $partido->aforo_local ?> asistentes</div>
	</div>

	<!-- Información del equipo visitante -->
	<div id="partido-equipo-visit">
		<div id="partido-nombre-visit"><?php echo $eqVis->nombre ?></div>
		<div id="partido-escudo-visit"><img src="<?php
			echo Yii::app()->BaseUrl . '/images/escudos/' . $eqVis->token . '.png' ?>" /></div>
		<div id="partido-nivel-visit">Nivel <?php echo $eqVis->nivel_equipo ?></div>
		<div id="partido-aforo-visit"><?php echo $partido->aforo_visitante ?> asistentes</div>
	</div>
</div>

<div id="partido-info">
	<nav id="partido-info-tabs">

	</nav>
	<div id="partido-info-content">

	</div>
</div>