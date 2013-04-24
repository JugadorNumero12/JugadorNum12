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
		<div id="partido-ambiente"><!--<?php echo $partido->ambiente ?>--></div>
		<div id="partido-turnos">
<?php for ($t = Partido::PRIMER_TURNO + 1; $t <= Partido::ULTIMO_TURNO; $t++ ):
	if ( $t < Partido::TURNO_DESCANSO ) {
		$pos = -1;
	} else if ($t == Partido::TURNO_DESCANSO ) {
		$pos = 0;
	} else {
		$pos = 1;
	}
?>
			<div id="partido-turno-<?php echo $t ?>" class="turno turno-<?php
				echo ($pos < 0 ? 'pre' : ($pos > 0 ? 'post' : 'desc'))
			?> turno-<?php
				echo ($t < $partido->turno ? 'anterior' : ($t > $partido->turno ? 'siguiente' : 'actual'))
			?>"><?php
				echo ($pos < 0 ? $t : ($pos > 0 ? $t-1 : 'D'))
			?></div>
<?php endfor ?>
		</div>
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

<div id="partido-info" class="inner-block">
	<ul id="partido-info-tabs">
		<li><a href="#partido-info-campo">Partido</a></li>
		<li><a href="#partido-info-acciones">Acciones</a></li>
		<li><a href="#partido-info-chat">Chat</a></li>
		<li><a href="#partido-info-datos">Datos</a></li>
		<li><a href="#partido-info-cronica">Cronica</a></li>
	</ul>
	<div id="partido-info-campo" class="partido-info-content">
		<div id="js-campo"></div>
	</div>
	<div id="partido-info-datos" class="partido-info-content">
		<!-- Datos  -->
		Turno: <?php echo $partido->turno ?>
		Estado: <?php echo $partido->estado ?>
        Ambiente: <?php echo $partido->ambiente ?>
        Nivel de <?php echo $eqLoc->nombre ?>: <?php echo $eqLoc->nivel_equipo ?>
  		Nivel de <?php echo $eqVis->nombre ?>: <?php echo $eqVis->nivel_equipo ?>
  		Indice ofensivo de <?php echo $eqLoc->nombre ?>: <?php echo $partido->ofensivo_local ?>
  		Indice ofensivo de <?php echo $eqVis->nombre ?>: <?php echo $partido->ofensivo_visitante ?>
  		Indice defensivo de <?php echo $eqLoc->nombre ?>: <?php echo $partido->defensivo_local ?>
  		Indice defensivo de <?php echo $eqVis->nombre ?>: <?php echo $partido->defensivo_visitante ?>
  		Aforo de <?php echo $eqLoc->nombre ?>: <?php echo $partido->aforo_local ?>
  		Aforo de <?php echo $eqVis->nombre ?>: <?php echo $partido->aforo_visitante ?>
  		Moral de <?php echo $eqLoc->nombre ?>: <?php echo $partido->moral_local ?>
  		Moral de <?php echo $eqVis->nombre ?>: <?php echo $partido->moral_visitante ?>
        
	</div>
	<div id="partido-info-cronica" class="partido-info-content">
		<pre><?php echo $partido->cronica ?></pre>
	</div>
	<div id="partido-info-chat" class="partido-info-content">
<?php 
    $this->widget('YiiChatWidget', array(
        'chat_id'    => '123',                   // a chat identificator
        'identity'   => Yii::app()->user->usIdent,   // the user
        'selector'   => '#partido-info-chat',                // were it will be inserted
        'minPostLen' => 1,                    // min and
        'maxPostLen' => 200,                   // max string size for post
        'model'      => new ChatHandler(),    // the class handler.
        'data'       => 'any data',                 // data passed to the handler
        // success and error handlers, both optionals.
        'onSuccess'  => new CJavaScriptExpression(
            "function(code, text, post_id){}"),
        'onError'    => new CJavaScriptExpression(
            "function(errorcode, info){}"),
    ));
?>
	</div>
	<div id="partido-info-acciones" class="partido-info-content">
		<h2>Acciones de partido</h2> 
		<h3>(pulsa para ejecutar)</h3>
		<div id="ac-p-error"></div>
		<table class="tabla-acciones">
		<?php $c = 0;
		foreach ($l_acciones as $a) 
		{ 
			if ($c === 0) echo '<tr>';
			?>		
			<td class="div-ac-p" onclick="ejecutarAP(<?php echo $a->id_habilidad; ?>)">
				<img title="<?php echo $a->nombre; ?>" alt="<?php echo $a->nombre; ?>" src="<?php echo Yii::app()->BaseUrl ?>/images/habilidades/<?php echo $a->token; ?>.png"  class="imagen-ac-p" />
				<h4><?php echo $a->nombre; ?></h4>
				<br>
				<?php
					echo '<b><img class="info-ac-p" src="'.Yii::app()->BaseUrl."/images/menu/recurso_dinero.png".'" alt="Icono dinero"> </b><span class="info-ac-p-txt">'.$a['dinero'].'</span>'.
					'<b><img class="info-ac-p" src="'.Yii::app()->BaseUrl."/images/menu/recurso_animo.png".'" alt="Icono animo"></b><span class="info-ac-p-txt">'.$a['animo'].'</span>'.
					'<b><img class="info-ac-p" src="'.Yii::app()->BaseUrl."/images/menu/recurso_influencia.png".'" alt="Icono influencia"> </b><span class="info-ac-p-txt">'.$a['influencias'].'</span>';
				?>
			</td>
		<?php 
			if ($c === 2) 
			{
				echo '</tr>';
				$c = 0;
			}
			else
			{
				$c++;
			}
		} 
		if ($c < 2)
		{
			echo '<tr>';
		}
		?>
		</table>
	</div>

</div>