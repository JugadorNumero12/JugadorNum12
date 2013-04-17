<?php
	Yii::app()->clientScript->registerLinkTag(
		'stylesheet/less', 'text/css', 
		Yii::app()->request->baseUrl . '/less/partido.less'
	);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsPartido.js');
?>
<script type="text/javascript">
	if (!window.partido) {
		window.partido = {};
	}

	if (!window.info) {
		window.info = {}
	}

	$.extend(partido, {
		id: <?php echo $partido->id_partido ?>,
		tiempo: <?php echo $partido->tiempoRestantePartido() ?>,
		tiempoTurno: <?php echo $partido->tiempoRestanteTurno() ?>,
		golesLocal: <?php echo $partido->goles_local ?>,
		golesVisit: <?php echo $partido->goles_visitante ?>,
		turno: <?php echo $partido->turno ?>,
		estado: <?php echo $partido->estado ?>
	});

	info.turnos = {
		inicial: <?php echo Partido::PRIMER_TURNO ?>,
		descanso: <?php echo Partido::TURNO_DESCANSO ?>,
		final: <?php echo Partido::ULTIMO_TURNO ?>
	}
</script>

<div id="partido-dibujo" class="inner-block">
	Dibujo del partido aquí
</div>

<!-- Marcador e información de los equipos y el estadio -->
<div id="partido-marcador" class="inner-block">
	<!-- Información general -->
	<div id="partido-marcador-general">
		<div id="partido-goles">
			<span id="partido-goles-local"><?php echo $partido->goles_local ?></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&ndash;&nbsp;&nbsp;&nbsp;&nbsp;
			<span id="partido-goles-visit"><?php echo $partido->goles_visitante ?></span>
		</div>
		<div id="partido-tiempo"><?php
			$trp = $partido->tiempoRestantePartido();
			$s = $trp%60;
			$m = (int)($trp/60);
			echo ($m<10 ? '0'.$m : $m) . ':' . ($s<10 ? '0'.$s : $s);
		?></div>
		<div id="partido-tiempo-turno"><?php
			$trt = $partido->tiempoRestanteTurno();
			$s = $trt%60;
			$m = (int)($trt/60);
			echo ($m<10 ? '0'.$m : $m) . ':' . ($s<10 ? '0'.$s : $s);
		?></div>
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


<br>
<h2>Chat</h2>
<div id='chat'></div>
<?php 
    $this->widget('YiiChatWidget',array(
        'chat_id'=>'123',                   // a chat identificator
        'identity'=>Yii::app()->user->usIdent,   // the user
        'selector'=>'#chat',                // were it will be inserted
        'minPostLen'=>1,                    // min and
        'maxPostLen'=>50,                   // max string size for post
        'model'=>new ChatHandler(),    // the class handler.
        'data'=>'any data',                 // data passed to the handler
        // success and error handlers, both optionals.
        'onSuccess'=>new CJavaScriptExpression(
            "function(code, text, post_id){   }"),
        'onError'=>new CJavaScriptExpression(
            "function(errorcode, info){  }"),
    ));
?>

