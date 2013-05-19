<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo Yii::app()->language; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="<?php echo Yii::app()->charset; ?>" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />

	<script type="text/javascript">
		window.baseUrl = '<?php echo Yii::app()->request->baseUrl ?>';
	</script>

	<!-- LESS import script -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.jgrowl.css" />
	<?php
	Helper::registerStyleFile('mainLayout');
	Helper::registerStyleFile('general');
	Helper::registerStyleFile('content');
	Helper::registerStyleFile('tablas');
	Helper::registerStyleFile('infohabilidad');
	Helper::registerStyleFile('infopartido');
	Helper::registerStyleFile('participar');
	Helper::registerStyleFile('cambiodatos');
	Helper::registerStyleFile('infoperfil');
	Helper::registerStyleFile('tutorial');
	/*
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/mainLayout.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/general.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/content.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/tablas.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/infohabilidad.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/infopartido.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/participar.less" />
	*/?>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	

	<!-- jQuery -->
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
	<?php $cssCoreUrl = Yii::app()->clientScript->getCoreScriptUrl();
	Yii::app()->clientScript->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsMain.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsGraficoCircular.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/jquery.jgrowl.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/flash.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/tutorial.js'); ?>


    
	<title><?php echo Yii::app()->name; ?></title>
<?php
	if (defined('YII_DEBUG') && YII_DEBUG) {
		Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/less-boot.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/less.js');
	}
?>


</head>

<body class="<?php echo Yii::app()->getParams()->bgclass ?>">

	<!-- Ayuda  -->
	<div id="ayuda-menu" class="ui-widget-content top-block">
	  <h2>Men&uacute;</h2>
	  <ul>
	  <li><a href="#" id="link-objetivo" >Objetivo del juego</a></li>
	  <li><a href="#" id="link-personajes" >Personajes</a></li>
	  <li><a href="#" id="link-habilidades" >Habilidades</a></li>
	  <li><a href="#" id="link-participar" >Participar</a></li>
	  <li><a href="#" id="link-asistir-partido" >Asistir al partido</a></li>
	  <li><a href="#" id="link-desarrollo-partido" >Desarrollo partido</a></li>
	  </ul>
	  <div><input type="button" id="cerrar-ayuda" value="Cerrar" /></div>
	</div>

	<div class="cuadro-ayuda top-block" id="ayuda-objetivo" class="ui-widget-content">
	  <h2>Objetivo del juego</h2> <br>
	  <h3>&iquest;Cu&aacute;l es el objetivo del juego?</h3>
	  <p>El objetivo del juego en jugador Num 12 es que <b>tu equipo se proclame campe&oacute;n de la liga</b>.</p>
	  <p>Para proclamarse campe&oacute;n de la liga tu equipo debe, obviamente, ganar partidos. La afici&oacute;n, es decir, t&uacute; y el resto de tus compa&ntilde;eros teneis diversas maneras de influir en un partido y ayudar al equipo. <p>
	  <h3>&iquest;C&oacute;mo ayudar a tu equipo antes del partido? </h3>
	  <p> La afici&oacute;n de un equipo puede aportar regursos en las acciones grupales para que, al completarsen, influyan en el partido de manera beneficiosa para su equipo. Para <b>completar una acci&oacute;n grupal</b> se necesita el apoyo, aporte y cooperaci&oacute;n de todos dus aficionados. No sirve abrir acciones grupales desde la vista del &aacute;rbol de habilidades. Se necesita participar en ellas y completarse para que sean efectivas. <br> M&aacute;s informaci&oacute;n sobre las acciones grupales en las pesta&ntilde;as de habilidades y participar.</p>
	  <h3>&iquest;C&oacute;mo ayudar a tu equipo durante el partido? </h3>
	  <p> Para ayudar a un equipo durante el partido lo mejor es hacer <b>acciones de partido</b>. Estas acciones influyen en el &aacute;nimo y el ambiente del partido. Una afici&oacute;n fogosa es el impulso que necesita un equipo para ganar un partido. <br>M&aacute;s informaci&oacute;n sobre las acciones de partido en la pesta&ntilde;a de habilidades.</p>

	</div>

	<div class="cuadro-ayuda top-block" id="ayuda-personajes" class="ui-widget-content">
	  <h2>Personajes</h2>
	  <p>En Jugador N&uacute;mero doce puedes elegir entre 3 tipos de personaje. Cada uno cuenta con sus propias caracter&iacute;sticas. </p> <br>
	  <img class="imagenes-ayuda-izq" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/ultra.png';?>" alt="ultra"><p> <b> El ultra </b> Representa la fuerza bruta, el sector m&aacute;s radical de la afici&oacute;n, que siempre intenta hacer mella en la moral del equipo contrario para lograr que su equipo logre alzarse con la victoria. Aunque suelen ser pocos por el car&aacute;cter agresivo y escandaloso que tienen, saben hacerse escuchar y animar a su equipo mejor que cualquier otro. <br> El ultra se deja la piel para respaldar a su equipo. Cuenta con mucho &aacute;nimo base y con una regeneraci&oacute;n de &aacute;nimo muy r&aacute;pida. Dispuesto a animar a su equipo con todas sus ganas, destina una cantidad de dinero moderada para apoyar a su equipo. No cuenta con demasiada influencia. Los dem&aacute;s aficionados, que no ven bien sus habilidades radicales. Cuando gasta su escasa, influencia tarda mucho en recuperarla. </p> <br>
	  <img class="imagenes-ayuda-izq" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/animadora.png';?>" alt="ultra"><p> <b>La animadora </b> Organizadora de eventos por naturaleza, utiliza las redes sociales y cualquier medio de comunicaci&oacute;n a su alcance para mover a los aficionados a dar apoyo a su equipo. Nadie puede igualarse a la movedora de masas en su af&aacute;n por conseguir adeptos y en ganarse su confianza tan f&aacute;cilmente. <br> El perfil con mayor cantidad de este recurso es el de la animadora, pudiendo ejercer su influencia sobre cualquier medio de comunicaci&oacute;n a su alcance y ganar as&iacute; seguidores de cara al pr&oacute;ximo encuentro. Siempre dispuestos a montar cualquier fiesta con la excusa de animar al equipo, manejan unas cantidades de &aacute;nimo moderado. Sin embargo, con su perfil universitario, no disponen de mucho dinero.</p> <br>
  	  <img class="imagenes-ayuda-izq" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/empresario.png';?>" alt="ultra"><p> <b>El empresario </b> Est&aacute; al frente de la lucha de las aficiones en los despachos, mueve cantidades abrumadoras de dinero. No pone pegas ni a las apuestas, ni a los sobornos y en general a nada que le proporcione rentabilidad econ&oacute;mica. Representa un alto cargo dedicado en cuerpo y alma a los negocios, pero a la hora de ir a ver un partido, prefiere sentarse en los palcos y ser un mero observador. <br> El empresario, capaz de amasar grandes fortunas en poco tiempo, destaca en el &aacute;rea econ&oacute;mica. Adem&aacute;s, cuenta tambi&eacute;n con su propio tipo de influencia, la que aporta el dinero (que no es poca). Sin embargo, apoyando a su equipo desde los negocios, y m&aacute;s pendiente de las apuestas que del partido, tiene un &aacute;nimo exiguo.</p> <br> 
  	  <table cellspacing=10>
  	  	<tr> <th> Perfil / Recurso</th> <th> Dinero </th> <th> &Aacute;nimo</th> <th> Influencia</th> </tr>
  	  	<tr> <td> Ultra </td> <td> <span style="color:orange">medio</span></td> <td> <span style="color:green">alto</span></td> <td> <span style="color:red">bajo</span></td> </tr>
  	  	<tr> <td> Animadora</td> <td> <span style="color:red">bajo</span> </td> <td> <span style="color:orange">medio</span> </td> <td> <span style="color:green">alto</span> </td></tr>
  	  	<tr> <td> Empresario</td> <td> <span style="color:green">alto</span> </td><td> <span style="color:red">bajo</span></td> <td> <span style="color:orange">medio</span> </td></tr>
  	  </table>
	</div>

	<div class="cuadro-ayuda top-block" id="ayuda-habilidades" class="ui-widget-content">
	  <h2>Habilidades</h2>
	  <p> En Jugador N&uacute;mero 4 hay diferentes tipos de habilidades </p>
	  <img class="imagenes-ayuda-izq" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/icono_grupal.png';?>" alt="accion grupal"><p> <b>Habilidades Grupales </b> Se necesita la colaboraci&oacute;n de toda la afici&oacute;n para completarlas. Una vez abiertas, hay un tiempo l&iacute;mite para completarlas. Para participar en una acci&oacute;n grupal, donando tus recursos, ve a la pantalla de inicio y comprueba cu&aacute;les son las acciones abiertas de tu equipo. Tambi&eacute;n lo puedes ver en la pantalla de Mi afici&oacute;n. Si el tiempo l&iacute;mite para una acci&oacute;n grupal se acaba sin completarla, los recursos aportados volver&aacute;n a sus due&ntilde;os.</p> <br>
	  <img class="imagenes-ayuda-izq" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/icono_individual.png';?>" alt="accion individual"><p> <b>Habilidades Individuales </b> El beneficio de una acci&oacute;n grupal solo afecta al jugador que la ejecuta. Estos beneficios durar&aacute;n solo hasta el siguiente partido.</p> <br>
	  <img class="imagenes-ayuda-izq" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/icono_pasiva.png';?>" alt="accion pasiva"><p> <b>Habilidades pasivas </b> El beneficio de una habilidad pasiva afecta solo al jugador que la ejecuta. El beneficio durar&aacute; para siempre y solo podr&aacute; ser ejecutada una vez. </p> <br>
	  <img class="imagenes-ayuda-izq" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/icono_partido.png';?>" alt="accion partido"><p> <b>Habilidades de partido </b> Las habilidades de partido solo se pueden usar durante un partido en curso. Sus beneficios sirven para mejorar los par&aacute;metros de tu equipo durante el partido y ayudarle a meter gol. Se pueden hacer tantas acciones de partido durante un partido como se quiera. </p> <br>
	</div>

	<div class="cuadro-ayuda top-block" id="ayuda-participar" class="ui-widget-content">
	  <h2>Participar</h2> <br>
	  <h3> &iquest;C&oacute;mo participo en una acci&oacute;n grupal? </h3>  
	  <p> Para participar en una acci&oacute;n grupal ve a la <b>pantalla de inicio</b> y mira que acciones hay abiertas.</p><br>
	  <img class="imagenes-ayuda-centro" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/grupales.png';?>" alt="grupales"><br> 
	  <p>Entra en ellas y participa donando tus recursos</p> <br> 
	  <img class="imagenes-ayuda-centro" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/participar.png';?>" alt="grupales"><br> <br> 
	  <h3> &iquest;De qu&eacute; sirve participar en las acciones grupales?</h3>  
	  <p>Cada acci&oacute;n grupal da beneficios a un equipo de cara a su pr&oacute;ximo partido. <b>Cuantas m&aacute;s acciones complete tu equipo m&aacute;s posibilidades tiene de ganar el pr&oacute;ximo partido</b>.</p> <br> 
	  <h3> &iquest;C&oacute;mo s&eacute; si mi equipo ganar&aacute; el siguiente partido?</h3>  
	  <p>En el calendario de partidos, el siguiente partido de tu equipo tendr&aacute; un bot&oacute;n llamado <b>previa</b>. Si entras all&iacute; ver&aacute;s una compartativa de como va tu equipo respecto al rival. </p> <br> 
	  <img class="imagenes-ayuda-centro" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/previa.png';?>" alt="previa">
	</div>

	<div class="cuadro-ayuda top-block" id="ayuda-asistir-partido" class="ui-widget-content">
	  <h2>Asistir al partido</h2> <br>
	  <h3>&iquest;C&oacute;mo puedo acceder a un partido? </h3>
	  <p>Para acceder a un partido puedes ir a inicio. Ah&iacute; indicar&aacute; la fecha y hora del siguiente partido. Cuando comience el partido al lado de la fecha y hora habr&aacute; un bot&oacute;n de asistir que te llevar&aacute; directo al partido. Si el partido a&uacute;n no ha empezado en el bot&oacute;n pondr&aacute; previa.</p>
	  <h3> &iquest;Puedo acceder a partidos en los que no juegue mi equipo?</h3>
	  <p> No, solo puedes acceder a partidos en los que juegue tu equipo. Tampoco pueder ver la previa de partidos en los que tu equipo no est&eacute; implicado</p>
	  <h3>&iquest;Qu&eacute; es la previa de un partido? </h3>
	  <p>La previa de un partido es una comparativa entre dos equipos que van a disputar un partido. Hay unos despegables en los que podr&aacute;s comparar las acciones grupales completadas de tu equipo y las de tu equipo rival. Esas acciones completadas son las que influir&aacute;n en el partido y decidir&sacute;n qui&eacute;n es el ganador. <br>Tambi&eacute;n hay unas barras para ver visualmente qui&eacute;n va mejor para el siguiente partido. </p>
	  <h3> Una vez que estoy dentro del partido, &iquest;puedo salir?</h3>
	  <p> S&iacute;. Puedes salir a otras pesta&ntilde;as, a mensajer&iacute;a y notificaciones, por ejemplo, y luego volver al partido sin problemas. </p>
	</div>

	<div class="cuadro-ayuda top-block" id="ayuda-desarrollo-partido" class="ui-widget-content">
	  <h2>Ayuda Desarrollo partido</h2> <br>
	  <h3> Estado del partido </h3>
	  <p> Los partidos duran 10 turnos. Cada turno dura un minuto. Cuando se cambia de turno el estado del partido cambia. Es decir, se mete un gol, un equipo se acerca a la porter&iacute;a contraria, los jugadores suben a defender etc. <br>Para ver en qu&eacute; estado est&aacute; el partido actualmente hay que fijarse en los dibujos de la izquierda el marcador y el dibujo del campo en la pesta&ntilde;a partido.</p>
	  <h3> Dibujos a la izquierda del marcador</h3>
	  <p> Los dibujos a la izquierda del marcador indican el estado del partido. Los monigotes son de dos colores gris y resaltado. Si el monigote resaltado es del color de tu equipo entonces tu equipo va mejor, y al rev&eacute;s si el monigote resaltado es del color de tu oponente.  </p>
	  <h3> Pesta&ntilde;a partido </h3>
	  <p>La pesta&ntilde;a partido sirve para saber en que estado est&aacute; el partido. Los circulos indican los jugadores locales y las cruces los jugadores visitantes. Puedes ver el estado del partido seg&uacute;n la posici&oacute;n de los jugadores en el campo. Si est&aacute;n presionando una porter&iacute;a, si est&aacute;n dispersos por el campo, etc.  </p>
	  <h3> Pesta&ntilde;a acciones</h3>
	  <p> <b>Puedes influir en un partido para ayudar a tu equipo a ganar.</b> En la pesta&ntilde;a acciones aparecer&aacute;n las acciones de partido que tengas desbloqueadas. Pincha en los iconos para ejecutar la acci&oacute;n y esta influir&aacute; en el partido ayudando a tu equipo a ganar. <br>Puedes hacer tantas acciones de partido como quieras durante un turno. Pero entre dos acciones seguidas tendr&aacute;s que esperar un peque&ntilde;o cool-down para volver a activar la acci&oacute;n. <br>Si resulta que ha llegado la hora del partido y no te has acordado de desbloquear ninguna habilidad, puedes salir del partido ir al &aacute;rbol de habilidades, desbloquear, y luego volver al partido sin problema. </p>
	  <h3> Pesta&ntilde;a chat</h3>
	  <p> Chat donde hablar con el resto de la afici&oacute;n del partido y comentarlo.</p>
	  <h3> Pesta&ntilde;a datos </h3>
	  <p> Indican los factores que influyen en el partido y sus valores. Est&aacute; un poco en construcci&oacute;n.</p>
	  <h3>Pesta&ntilde;a cr&oacute;nica </h3> 
	  <p> Cada turno, se genera una cronica comentando el partido. Luego la cr&oacute;nica se guardar&aacute; como un registro para que se pueda consultar una vez acabado el partido. Est&aacute; un poco en construcci&oacute;n.  </p>
	</div>
	<!-- Fin ayuda -->

<!-- Barra Superior -->
<div id="barrasup">
	<div id="barrasup-envoltorio">
		<!-- Parte izquierda de la barra -->
		<div id="barrasup-izquierda">
			<a href="<?php echo Yii::app()->createUrl('/usuarios/index') ?>">
				<img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/logos/logo-barra.png" alt="logo">
			</a>
		</div>

		<!-- Parte central de la barra -->
		<div id="barrasup-centro">

			<!-- Barra del dinero -->
			<div class="barrasup-recursos" title="Dinero">
				<img class="barrasup-icono-dinero" src="<?php echo Yii::app()->BaseUrl.'/images/menu/recurso_dinero.png';?>" alt="Icono dinero">
				<div id="barrasup-progressbar-dinero" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->dinero) ?>">
					<div id="progressbar-label-dinero"></div>
				</div>
			</div>

			<!-- Barra de ánimo -->
			<div class="barrasup-recursos" title="&Aacute;nimo">
				<img class="barrasup-icono-animo" src="<?php echo Yii::app()->BaseUrl.'/images/menu/recurso_animo.png';?>" alt="Icono animo">
				<div id="barrasup-progressbar-animo" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->animo)?>" data-max="<?php echo Yii::app()->getParams()->usuario->recursos->animo_max ?>">
					<div id="progressbar-label-animo"></div>
				</div>
			</div>

			<!-- Barra de influencias -->
			<div class="barrasup-recursos" title="Influencias">
				<img class="barrasup-icono-influencias" src="<?php echo Yii::app()->BaseUrl.'/images/menu/recurso_influencia.png';?>" alt="Icono influencias">
				<div id="barrasup-progressbar-influencias" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->influencias)?>" data-max="<?php echo Yii::app()->getParams()->usuario->recursos->influencias_max ?>">
					<div id="progressbar-label-influencias"></div>
				</div>
			</div> 
		</div>

		<!-- Parte derecha de la barra -->
		<div id="barrasup-derecha">
			<!-- Menú de usuario -->
			<ul id="user-menu">
				<!-- Avatar + Nombre -->
				<li class="user-menu-item">
					<img alt="<?php echo Yii::app()->getParams()->usuario->nick; ?>"
					     src="<?php switch (Yii::app()->getParams()->usuario->personaje) {
							case Usuarios::PERSONAJE_EMPRESARIO:
								echo Yii::app()->createUrl('/images/perfil/empresario-menu.jpg');
							break;
							case Usuarios::PERSONAJE_MOVEDORA: 
								echo Yii::app()->createUrl('/images/perfil/animadora-menu.jpg');
							break;
							case Usuarios::PERSONAJE_ULTRA:
								echo Yii::app()->createUrl('/images/perfil/ultra-menu.jpg');
							break;
						} ?>" width="24" height="24">
					<span class="user-menu-txt user-menu-title"><?php echo Yii::app()->getParams()->usuario->nick; ?></span>
					<?php if(Yii::app()->getParams()->countnot + Yii::app()->getParams()->countmens > 0) {?>
						<div class="notificacion-alerta">!</div>
						<!--<img alt="nueva notificacion" src="<?php echo Yii::app()->BaseUrl.'/images/menu/barra_nota.png'; ?>" width="17" height="17"> -->
					<?php }?>
				</li>

				<!-- Link al perfil -->
				<a href="<?php echo Yii::app()->createUrl('/usuarios/perfil') ?>">
					<li class="user-menu-item user-menu-hidden">
						<img alt="Perfil" src="<?php echo Yii::app()->BaseUrl ?>/images/menu/barra-perfil.png"
						     width="24" height="24"/><span class="user-menu-txt">Perfil</span>
					</li>
				</a>

				<!-- Notificaciones -->
				<a href="<?php echo Yii::app()->createUrl('/notificaciones/index') ?>">
					<li class="user-menu-item user-menu-hidden">
						<img alt="Notificacion" src="<?php echo Yii::app()->BaseUrl ?>/images/menu/barra_notificacion.png"
						     width="24" height="24"/><span class="user-menu-txt"><?php
						     	$not = Yii::app()->getParams()->countnot;
						     	if ($not > 0) { echo "<span class=\"contador\">$not</span>"; } ?>Notificaciones</span>
					</li>
				</a>

				<!-- Mensajeria -->
				<a href="<?php echo Yii::app()->createUrl('/emails/index') ?>">
					<li class="user-menu-item user-menu-hidden">
						<img alt="Mensajeria" src="<?php echo Yii::app()->BaseUrl ?>/images/menu/barra_mensajes.png"
						     width="24" height="24"/><span class="user-menu-txt"><?php
						     	$msg = Yii::app()->getParams()->countmens;
						     	if ($msg > 0) { echo "<span class=\"contador\">$msg</span>"; } ?>Mensajes</span>
					</li>
				</a>

				<!-- Logout -->
				<a href="<?php echo Yii::app()->createUrl('/site/logout') ?>">
					<li class="user-menu-item user-menu-hidden">
						<img alt="Logout" src="<?php echo Yii::app()->BaseUrl ?>/images/menu/barra_logout.png"
						     width="24" height="24"/><span class="user-menu-txt">Logout</span>
					</li>
				</a>
			</ul>
		</div>
	</div>
</div>

<div id="envoltorio-main">

	<div class="top-padding"></div>

  	<!-- DIVISION DE CABECERA -->
	<div id="clasificacion" class="top-block">
        <ul>
		<?php foreach (Yii::app()->getParams()->clasificacion as $equipo): ?>
            <a href="<?php echo $this->createUrl( '/equipos/ver', array('id_equipo' => $equipo->equipos_id_equipo) ); ?>">  
            <li class="clasif-item<?php if ($equipo->equipos->id_equipo == Yii::app()->user->usAfic) { echo ' clasif-mi-equipo'; } ?>">
            	<span class="clasif-hash">#</span><span class="clasif-posicion"><?php echo $equipo->posicion ?></span>
            	<img
                	title="<?php echo $equipo->equipos->nombre . ' &ndash; ' . $equipo->puntos . ' puntos'; ?>",
                	class="clasif-escudo equipo-<?php echo $equipo->equipos->token ?>"
                	src="<?php echo Yii::app()->BaseUrl . '/images/escudos/40px/' . $equipo->equipos->token . '.png'; ?>"
                	alt="<?php echo $equipo->equipos->nombre; ?>"
                	width="40" height="40" />
            </li></a>
        <?php endforeach ?>
		</ul>
	</div>
	
    <!-- DIVISION DEL MENU IZQUIERDO -->
    <ul id="menu-izquierdo" class="top-block">
		<a href="<?php echo $this->createUrl( '/usuarios/index', array() ); ?>">
			<li class="menu-item menu-item-first">
				<?php switch (Yii::app()->getParams()->usuario->personaje):
					case Usuarios::PERSONAJE_EMPRESARIO: ?>
						<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/perfil/empresario-menu.jpg'; ?>" alt="menu-inicio-empresario">
					<?php break;
					case Usuarios::PERSONAJE_MOVEDORA: ?>
						<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/perfil/animadora-menu.jpg'; ?>" alt="menu-inicio-movedora">
					<?php break;
					case Usuarios::PERSONAJE_ULTRA: ?>
						<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/perfil/ultra-menu.jpg'; ?>" alt="menu-inicio-ultra">
					<?php break;
				endswitch ?>
				<div class="nombre-menu">Inicio</div>
			</li>
		</a>
	   	<a href="<?php echo Yii::app()->createUrl('/habilidades');?>">
		   	<li class="menu-item">
		   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/menu/menu_habilidades.png'; ?>" alt="menu-arbol">
		   		<div class="nombre-menu">Habilidades</div>
		   	</li>
	    </a>
		<a href="<?php echo $this->createUrl( '/equipos/ver', array('id_equipo' => Yii::app()->user->usAfic) ); ?>">
		   	<li class="menu-item">
				<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/menu/menu_aficion.png'; ?>" alt="menu-aficion">
				<div class="nombre-menu">Mi Afici&oacute;n</div>
			</li>
		</a>			   	
	    <a href="<?php echo Yii::app()->createUrl('/equipos');?>">
		   	<li class="menu-item">
		   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/menu/menu_clasificacion.png'; ?>" alt="menu-clasificacion">
		   		<div class="nombre-menu">Clasificaci&oacute;n</div>
		   	</li>
		</a>
		<a href="<?php echo Yii::app()->createUrl('/partidos/index');?>">
		   	<li class="menu-item">
		   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/menu/menu_calendario.png'; ?>" alt="menu-calendario">
		   		<div class="nombre-menu">Calendario</div>
		   	</li>
		</a>
		<a href="#" id="button-ayuda" >
		   	<li class="menu-item menu-item-last">
		   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/menu/menu_ayuda.png'; ?>" alt="menu-ayuda">
		   		<div class="nombre-menu">Ayuda</div>
		   	</li>
	  	</a>
	</ul>
    
    <!-- DIVISION PARA FLOTAR -->
    <div id="grupo-centro" class="top-block">

	    <!-- DIVISION CENTRAL/CONTENIDO -->
	    <div id="contenido">
	    	<!-- BEGIN FLASH -->
	      <?php
    		foreach(Yii::app()->user->getFlashes() as $key => $message) { ?>
    			<script type="text/javascript">
    			$.jGrowl( "<?php echo $message; ?>", { sticky: true });
    			</script>
        	<?php	//echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    		}
		  ?>
		  <!-- END FLASH -->
		  <!-- BEGIN CONTENT -->
		  <?php echo $content; ?>
		  <!-- END CONTENT -->
	    </div>
	</div>

	<div class="clear"></div>

	<div class="bottom-padding"></div>

	<!-- FUERA -->
	<div class="pie-pagina"> <!-- top-block -->
		<Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
		<span class="separados">All Rights Reserved.</span>
		<span class="separados"><?php echo Yii::powered(); ?></span>
		<span class="separados"><a href="mailto:jugnum12@gmail.com">Contacto</a></span>
		<span class="separados"><a href="http://lobonleal.blogspot.com.es">Arte</a></span>
		<span class="separados">Universidad Complutense de Madrid.</span>
	</div>

</div>

</body>

</html>