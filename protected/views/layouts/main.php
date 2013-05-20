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
	  <li><a href="#" id="link-tutorial-0" > <span class="resaltar">Tutorial </span></a></li>
	  <li><a href="#" id="link-tutorial-1" class="submenu" >Paso 1</a></li>
	  <li><a href="#" id="link-tutorial-2"  class="submenu" >Paso 2</a></li>
	  <li><a href="#" id="link-tutorial-3"  class="submenu" >Paso 3</a></li>
	  <li><a href="#" id="link-tutorial-4"  class="submenu" >Paso 4</a></li>
	  <li><a href="#" id="link-tutorial-5"  class="submenu" >Paso 5</a></li>
	  <li><a href="#" id="link-tutorial-6"  class="submenu" >Paso 6</a></li>
	  <li><a href="#" id="link-tutorial-7"  class="submenu" >Paso 7</a></li>  
	  <li><a href="#" id="link-tutorial-8"  class="submenu" >Paso 8</a></li> 
	  <li><a href="#" id="link-tutorial-9"  class="submenu" >Paso 9</a></li> 
	  <li><a href="#" id="link-tutorial-10"  class="submenu" >Paso 10</a></li> 
	  <li><a href="#" id="link-objetivo" >Objetivo del juego</a></li>
	  <li><a href="#" id="link-personajes" >Personajes</a></li>
	  <li><a href="#" id="link-habilidades" >Habilidades</a></li>
	  <li><a href="#" id="link-participar" >Participar</a></li>
	  <li><a href="#" id="link-asistir-partido" >Asistir al partido</a></li>
	  <li><a href="#" id="link-desarrollo-partido" >Desarrollo partido</a></li>
	  </ul>
	  <div><input type="button" id="cerrar-ayuda" value="Cerrar" /></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-0" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1>&iquest;Nuevo en <span style="color:#570;font-weight:bold">JUGADOR N&Uacute;MERO 12?</span> <h1>
			<br> <br>
			<h1>&iquest;No sabes por d&oacute;nde comenzar? <h1><br> <br>
			<h2>En este tutorial te ayudaremos a entender el juego en </h2> <h1> <span style="color:orangered;font-weight:bold">10 sencillos pasos</span></h1> </div>
			<span style="color:#0099FF;font-weight:bold">Nota: </span> El tutorial no es interactivo


	   <div class="flecha-dcha"><a href="#" id="link-flecha-01" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-1" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">1</span> Desbloquea habilidades</h1> <br>
			<h2> No te olvides de las habilidades de partido</h2>
			<br> <br> <br>
			<h3> Ve al men&uacute; habilidades <img  src="<?php echo Yii::app()->BaseUrl ?>/images/menu/menu_habilidades.png" alt="logo"> y desbloquea las habilidades de nivel b&aacute;sico. <h3>
				<br> <br><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/tutorial-1.png" alt="logo">
		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-10" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>
	   <div class="flecha-dcha"><a href="#" id="link-flecha-12" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-2" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">2</span> Ejecuta acciones</h1> <br>
			<h2> &Uacute;salas desde el &aacute;rbol de habilidades</h2>
			<br> <br> 
			<h3> Ahora que tienes habilidades desbloqueadas, est&aacute;s listo para usarlas y rockanrolear el mundo. <br> <br> Vuelve a &aacute;rbol de habilidades <img  src="<?php echo Yii::app()->BaseUrl ?>/images/menu/menu_habilidades.png" alt="logo"> y usa las acciones que has desbloqueado. <br> <br> <br><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/tutorial-2.png" alt="logo"> <br> <br> <br> <span class="resaltar">Pista: </span> Te aconsejo que uses una grupal y una individual. Pero no m&aacute;s, reservaremos nuestro recursos para parcipar.<h3>
		</div>
	 	<div class="flecha-izq"><a href="#" id="link-flecha-21" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
		<div class="flecha-dcha"><a href="#" id="link-flecha-23" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-3" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">3</span> Participa en acciones</h1> <br>
			<h2> No te olvides de completarlas</h2>
			<br> <br> 
			<h3> Ve a la pantalla de inicio y encontrar&aacute;s todas las acciones grupales abiertas por tu equipo.<br><br> Pincha en participar y dona los recursos para completarlas. <br><br> <br> <img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/grupales.png" alt="logo"> <br> <br> <br><span class="resaltar">Pista: </span> Es m&aacute;s importante gastarse todos los recursos en participar en una sola acci&oacute;n y completarla que participar en muchas acciones, pero no compeltar ninguna.</h3>
			
		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-32" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
	  <div class="flecha-dcha"><a href="#" id="link-flecha-34" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-4" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">4</span> Gana experiencia</h1> <br>
			<h2> Y sube de nivel</h2>
			<br> <br> <br>
			<h3>  Usa acciones, participa en ellas, completal&aacute;s , y ganar&aacute;s experiencia. Cuanto m&aacute;s teng&aacute;s m&aacute;s recursos tendr&aacute;s y m&aacute;s habilidades podr&aacute;s desbloquear <br> <br> <img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/tutorial-4.png" alt="logo"> <br> <br>  <span class="resaltar">Pista: </span> Lo que m&aacute;s da experiencia es completar acciones. Si est&aacute;s en nivel 1 y completas una acci&oacute;n subir&aacute;s de nivel. <br> <br> <span class="resaltar">Pista: </span> Consulta tu perfil <img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/menu/barra-perfil.png"  width="16px" height="16px"alt="logo">para ver cu&aacute;nta experiencia tienes.  </h3>
		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-43" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
	  <div class="flecha-dcha"><a href="#" id="link-flecha-45" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-5" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">5</span> Charla con tus compa&ntilde;eros de equipo</h1> <br>
			<h2> Usa la mensajer&iacute;a</h2>
			<br> <br> <br>
			<h3> En la p&aacute;gina, arriba a la derecha pone tu nombre. Es un men&uacute; desplegable donde podr&aacute;s ir a la bandeja de entrada de la mansajer&iacute;a. <img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/menu/barra_mensajes.png" alt="logo"> <br> <br> Manda mensaje a tus compa&ntilde;eros escribiendo su nombre de ususario. <br> <br> Puedes mandar un mensaje a varias personas si separas sus nombres por comas ","<br> <br> <span class="resaltar"> Pista: </span> Si no te sabes el nombre de tus compa&ntilde;eros, <br> cons&uacute;ltalo en la pesta&ntilde;a Jugadores del men&uacute; de mi afici&oacute;n <img  src="<?php echo Yii::app()->BaseUrl ?>/images/menu/menu_aficion.png" alt="logo"></h3>

		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-54" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
	  <div class="flecha-dcha"><a href="#" id="link-flecha-56" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-6" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">6</span> Mantente al d&iacute;a</h1> <br>
			<h2> Mira tus notificaciones</h2>
			<br> <br> 	
			<h3> Encontrar&aacute;s las notificaciones <img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/menu/barra_notificacion.png" alt="logo"> en el men&uacute; despegable donde estaba la mensajer&iacute;a.<br><br>Puedes cosultar la actividad de tu equipo con las notificaciones.</h3> <br> <img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/tutorial-6.png" alt="logo">	
		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-65" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
	  <div class="flecha-dcha"><a href="#" id="link-flecha-67" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-7" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">7 </span> Comenta la previa</h1> <br>
			<h2> Consulta c&oacute;mo de preparado est&aacute; tu equipo para el siguiente partido</h2>
			<br> <br> 
			<h3> En el men&uacute; de inicio encontrar&aacute;s la fecha y la hora de tu siguiente partido. <br> <br> Si no se est&aacute; disputando ning&uacute;n partido ahora mismo ver&aacute;s al lado un bot&oacute;n que pone previa. <br> <br> La previa es una vista que compara como se han preparado dos equipos para el siguiente partido que van a disputar <br> <br> <img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/tutorial-7.png" alt="logo"> <br> <br>  <span style="color:#0099FF;font-weight:bold">Nota: </span> si el partido se est&aacute; disputando en ese momento. En el bot&oacute;n, en vez de previa pone asistir y te llevar&aacute; al partido. <h3>
		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-76" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
	  <div class="flecha-dcha"><a href="#" id="link-flecha-78" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-8" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">8 </span>Asiste al partido</h1> <br>
			<h2> Apoya a tu equipo en el momento m&aacute;s importante</h2>
			<br> <br> <br>
			<h3>En el men&uacute; de inicio encontrar&aacute;s la fecha y la hora de tu siguiente partido. <br> <br> Si el momento ha llegado habr&uacute; un bot&oacute;n de asistir. Si pinchas en &eacute;l te llevar&aacute; a la vista del partido. <br> <br> <img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/tutorial-8.png" alt="logo"> <br> <br> Puedes entrar en la vista del partido, salir, y despu&eacute;s volver a entrar sin problema. <h3>
		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-87" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
	  <div class="flecha-dcha"><a href="#" id="link-flecha-89" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-9" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">9 </span>Influye en el partido</h1> <br>
			<h2> Haz acciones de partido. </h2>
			<br> <br> <br>
			<h3> En la pesta&ntilde;a acciones del partido, activa tus acciones de partido influir en &eacute;l. <br> <br> Las acciones tienen un peque&ntilde;o cool-down tienes que esperar un poco para repetir una misma acci&oacute;n de partido. <br><br>Puedes hacer tantas acciones en un turno como quieras.</h3>
			<br> <br> <br><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/tutorial-9.png" alt="logo">
		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-98" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
	  <div class="flecha-dcha"><a href="#" id="link-flecha-910" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-dcha.png" alt="logo"></a></div>
	</div>

	<div class="cuadro-tutorial top-block" id="tutorial-10" class="ui-widget-content">
		<div class="contenido-tutorial">
			<h1> <span class="resaltar">10 </span>&iexcl;&iexcl;Gana!!</h1> <br>
			<h2> LLeva tu equipo a la gloria </h2>
			<br> <br> <br>
			<h3>Si has seguido el tutorial paso a paso, tienes las herramientas necesarias para hacer que tu equipo arrase en la liga y se proclame campe&oacute;n. <br> <br><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/tutorial-10.png" alt="logo"><h3>
			<br> <br><h1> <span class="resaltar">Enhorabuena has acabado el tutorial </span><h1>
		</div>
	  <div class="flecha-izq"><a href="#" id="link-flecha-109" ><img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/ayuda/flecha-izq.png" alt="logo"></a></div>	   
	  </div>

	 
	<div class="cuadro-ayuda top-block" id="ayuda-objetivo" class="ui-widget-content">
	  <h2>Objetivo del juego</h2> <br>
	  <h3>&iquest;Cu&aacute;l es el objetivo del juego?</h3>
	  <p>El objetivo del juego en jugador Num 12 es que <span class="resaltar">tu equipo se proclame campe&oacute;n de la liga</span>.</p>
	  <p>Para proclamarse campe&oacute;n de la liga tu equipo debe, obviamente, ganar partidos. La afici&oacute;n, es decir, t&uacute; y el resto de tus compa&ntilde;eros teneis diversas maneras de influir en un partido y ayudar al equipo. <p>
	  <h3>&iquest;C&oacute;mo ayudar a tu equipo antes del partido? </h3>
	  <p> La afici&oacute;n de un equipo puede aportar regursos en las acciones grupales para que, al completarsen, influyan en el partido de manera beneficiosa para su equipo. Para <span class="resaltar">completar una acci&oacute;n grupal</span> se necesita el apoyo, aporte y cooperaci&oacute;n de todos dus aficionados. No sirve abrir acciones grupales desde la vista del &aacute;rbol de habilidades. Se necesita participar en ellas y completarse para que sean efectivas. <br> M&aacute;s informaci&oacute;n sobre las acciones grupales en las pesta&ntilde;as de habilidades y participar.</p>
	  <h3>&iquest;C&oacute;mo ayudar a tu equipo durante el partido? </h3>
	  <p> Para ayudar a un equipo durante el partido lo mejor es hacer <span class="resaltar">acciones de partido</span>. Estas acciones influyen en el &aacute;nimo y el ambiente del partido. Una afici&oacute;n fogosa es el impulso que necesita un equipo para ganar un partido. <br>M&aacute;s informaci&oacute;n sobre las acciones de partido en la pesta&ntilde;a de habilidades.</p>

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
	  <p> Para participar en una acci&oacute;n grupal ve a la <span class="resaltar">pantalla de inicio</span> y mira que acciones hay abiertas.</p><br>
	  <img class="imagenes-ayuda-centro" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/grupales.png';?>" alt="grupales"><br> 
	  <p>Entra en ellas y participa donando tus recursos</p> <br> 
	  <img class="imagenes-ayuda-centro" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/participar.png';?>" alt="grupales"><br> <br> 
	  <h3> &iquest;De qu&eacute; sirve participar en las acciones grupales?</h3>  
	  <p>Cada acci&oacute;n grupal da beneficios a un equipo de cara a su pr&oacute;ximo partido. <span class="resaltar">Cuantas m&aacute;s acciones complete tu equipo m&aacute;s posibilidades tiene de ganar el pr&oacute;ximo partido</span>.</p> <br> 
	  <h3> &iquest;C&oacute;mo s&eacute; si mi equipo ganar&aacute; el siguiente partido?</h3>  
	  <p>En el calendario de partidos, el siguiente partido de tu equipo tendr&aacute; un bot&oacute;n llamado <b>previa</b>. Si entras all&iacute; ver&aacute;s una compartativa de como va tu equipo respecto al rival. </p> <br> 
	  <img class="imagenes-ayuda-centro" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/previa.png';?>" alt="previa">
	</div>

	<div class="cuadro-ayuda top-block" id="ayuda-asistir-partido" class="ui-widget-content">
	  <h2>Asistir al partido</h2> <br>
	  <h3>&iquest;C&oacute;mo puedo acceder a un partido? </h3>
	  <p>Para acceder a un partido puedes ir a inicio. Ah&iacute; indicar&aacute; la fecha y hora del siguiente partido. Cuando comience el partido al lado de la fecha y hora habr&aacute; un bot&oacute;n de asistir que te llevar&aacute; directo al partido. Si el partido a&uacute;n no ha empezado en el bot&oacute;n pondr&aacute; previa. <br> Tambi&eacute; puedes asistir desde el calendario de partidos, buscando el pr&oacute;imo partido de tu equipo en el calendario</p>
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
	  <p> <span class="resaltar">Puedes influir en un partido para ayudar a tu equipo a ganar.</span> En la pesta&ntilde;a acciones aparecer&aacute;n las acciones de partido que tengas desbloqueadas. Pincha en los iconos para ejecutar la acci&oacute;n y esta influir&aacute; en el partido ayudando a tu equipo a ganar. <br>Puedes hacer tantas acciones de partido como quieras durante un turno. Pero entre dos acciones seguidas tendr&aacute;s que esperar un peque&ntilde;o cool-down para volver a activar la acci&oacute;n. <br>Si resulta que ha llegado la hora del partido y no te has acordado de desbloquear ninguna habilidad, puedes salir del partido ir al &aacute;rbol de habilidades, desbloquear, y luego volver al partido sin problema. </p>
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