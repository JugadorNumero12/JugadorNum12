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
	<div id="ayuda-menu" class="ui-widget-content">
	  <p>Men&uacute;</p>
	  <ul>
	  <li><a href="#" id="link-personajes" class="ui-state-default ui-corner-all">Personajes</a></li>
	  <li><a href="#" id="link-habilidades" class="ui-state-default ui-corner-all">Habilidades</a></li>
	  <li><a href="#" id="link-partido" class="ui-state-default ui-corner-all">Partido</a></li>
	  </ul>
	  <div><input type="button" id="cerrar-ayuda" value="Cerrar" /></div>
	</div>

	<div class="cuadro-ayuda" id="ayuda-personajes" class="ui-widget-content">
	  <h2>Personajes</h2>
	  <p>En Jugador N&uacute;mero doce puedes elegir entre 3 tipos de personaje. Cada uno cuenta con sus propias caracter&iacute;sticas. </p> <br>
	  <img class="imagenes-ayuda" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/ultra.png';?>" alt="ultra"><p> <b> El ultra </b> Representa la fuerza bruta, el sector m&aacute;s radical de la afici&oacute;n, que siempre intenta hacer mella en la moral del equipo contrario para lograr que su equipo logre alzarse con la victoria. Aunque suelen ser pocos por el car&aacute;cter agresivo y escandaloso que tienen, saben hacerse escuchar y animar a su equipo mejor que cualquier otro. <br> El ultra se deja la piel para respaldar a su equipo. Cuenta con mucho &aacute;nimo base y con una regeneraci&oacute;n de &aacute;nimo muy r&aacute;pida. Dispuesto a animar a su equipo con todas sus ganas, destina una cantidad de dinero moderada para apoyar a su equipo. No cuenta con demasiada influencia. Los dem&aacute;s aficionados, que no ven bien sus habilidades radicales. Cuando gasta su escasa, influencia tarda mucho en recuperarla. </p> <br>
	  <img class="imagenes-ayuda" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/animadora.png';?>" alt="ultra"><p> <b>La animadora </b> Organizadora de eventos por naturaleza, utiliza las redes sociales y cualquier medio de comunicaci&oacute;n a su alcance para mover a los aficionados a dar apoyo a su equipo. Nadie puede igualarse a la movedora de masas en su af&aacute;n por conseguir adeptos y en ganarse su confianza tan f&aacute;cilmente. <br> El perfil con mayor cantidad de este recurso es el de la animadora, pudiendo ejercer su influencia sobre cualquier medio de comunicaci&oacute;n a su alcance y ganar as&iacute; seguidores de cara al pr&oacute;ximo encuentro. Siempre dispuestos a montar cualquier fiesta con la excusa de animar al equipo, manejan unas cantidades de &aacute;nimo moderado. Sin embargo, con su perfil universitario, no disponen de mucho dinero.</p> <br>
  	  <img class="imagenes-ayuda" src="<?php echo Yii::app()->BaseUrl.'/images/ayuda/empresario.png';?>" alt="ultra"><p> <b>El empresario </b> Est&aacute; al frente de la lucha de las aficiones en los despachos, mueve cantidades abrumadoras de dinero. No pone pegas ni a las apuestas, ni a los sobornos y en general a nada que le proporcione rentabilidad econ&oacute;mica. Representa un alto cargo dedicado en cuerpo y alma a los negocios, pero a la hora de ir a ver un partido, prefiere sentarse en los palcos y ser un mero observador. <br> El empresario, capaz de amasar grandes fortunas en poco tiempo, destaca en el &aacute;rea econ&oacute;mica. Adem&aacute;s, cuenta tambi&eacute;n con su propio tipo de influencia, la que aporta el dinero (que no es poca). Sin embargo, apoyando a su equipo desde los negocios, y m&aacute;s pendiente de las apuestas que del partido, tiene un &aacute;nimo exiguo.</p> <br>
	</div>

	<div class="cuadro-ayuda" id="ayuda-habilidades" class="ui-widget-content">
	  <p>Ayuda habilidades</p>
	</div>

	<div class="cuadro-ayuda" id="ayuda-partido" class="ui-widget-content">
	  <p>Ayuda partido</p>
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