<?php
	Yii::app()->clientScript->registerLinkTag(
		'stylesheet/less', 'text/css', 
		Yii::app()->request->baseUrl . '/less/partido.less'
	);
?>
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
		<div class="equipo-info equipo-nombre"><?php echo $eqLoc->nombre ?></div>
		<div class="equipo-info equipo-escudo"><img src="<?php
			echo Yii::app()->BaseUrl . '/images/escudos/' . $eqLoc->token . '.png' ?>" width="100"/></div>
		<div class="equipo-info equipo-nivel">Nivel <?php echo $eqLoc->nivel_equipo ?></div>
		<div class="equipo-info equipo-aforo"><?php echo $partido->aforo_local ?> asistentes</div>
	</div>

	<!-- Información del equipo visitante -->
	<div id="partido-equipo-visit">
		<div class="equipo-info equipo-nombre"><?php echo $eqVis->nombre ?></div>
		<div class="equipo-info equipo-escudo"><img src="<?php
			echo Yii::app()->BaseUrl . '/images/escudos/' . $eqVis->token . '.png' ?>" width="100" /></div>
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
