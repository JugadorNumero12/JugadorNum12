<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo Yii::app()->language; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="<?php echo Yii::app()->charset; ?>" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />

	<!-- LESS import script -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.jgrowl.css" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/mainLayout.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/content.less" />
	<script type="text/javascript">
	    less = {
	        env: "development", // or "production"
	        async: false,       // load imports async
	        fileAsync: false,   // load imports async when in a page under
	                            // a file protocol
	        poll: 1000,         // when in watch mode, time in ms between polls
	        functions: {},      // user functions, keyed by name
	        dumpLineNumbers: "comments", // or "mediaquery" or "all"
	        relativeUrls: false,// whether to adjust url's to be relative
	                            // if false, url's are already relative to the
	                            // entry less file
	        rootpath: "<?php echo Yii::app()->request->baseUrl ?>/"// a path to add on to the start of every url
	                            //resource
	    };
	</script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/less.js" type="text/javascript"></script>

	<!-- jQuery -->
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
	<?php $cssCoreUrl = Yii::app()->clientScript->getCoreScriptUrl();
	Yii::app()->clientScript->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsMain.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsGraficoCircular.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsPartido.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/jquery.jgrowl.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/flash.js'); ?>
    
	<title><?php echo Yii::app()->name; ?></title>
</head>

<body class="<?php echo Yii::app()->getParams()->bgclass ?>">

<!-- Barra Superior -->
<div id="barrasup">
	<div id="barrasup-envoltorio">
		<!-- Parte izquierda de la barra -->
		<div id="barrasup-izquierda">
			<img id="barrasup-logo" src="<?php echo Yii::app()->BaseUrl ?>/images/logos/logo-barra.png" alt="logo">
		</div>

		<!-- Parte central de la barra -->
		<div id="barrasup-centro">

			<!-- Barra del dinero -->
			<div class="barrasup-recursos" title="Dinero">
				<img class="barrasup-icono-dinero" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-dinero.png';?>" alt="Icono dinero">
				<div id="barrasup-progressbar-dinero" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->dinero) ?>">
					<div id="progressbar-label-dinero"></div>
				</div>
			</div>

			<!-- Barra de �nimo -->
			<div class="barrasup-recursos" title="&Aacute;nimo">
				<img class="barrasup-icono-animo" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-animo.png';?>" alt="Icono animo">
				<div id="barrasup-progressbar-animo" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->animo)?>" data-max="<?php echo Yii::app()->getParams()->usuario->recursos->animo_max ?>">
					<div id="progressbar-label-animo"></div>
				</div>
			</div>

			<!-- Barra de influencias -->
			<div class="barrasup-recursos" title="Influencias">
				<img class="barrasup-icono-influencias" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-influencia.png';?>" alt="Icono influencias">
				<div id="barrasup-progressbar-influencias" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->influencias)?>" data-max="<?php echo Yii::app()->getParams()->usuario->recursos->influencias_max ?>">
					<div id="progressbar-label-influencias"></div>
				</div>
			</div> 
		</div>

		<!-- Parte derecha de la barra -->
		<div id="barrasup-derecha">
			<!-- Men� de usuario -->
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
						} ?>" width="24" height="24"><span class="user-menu-txt user-menu-title"><?php echo Yii::app()->getParams()->usuario->nick; ?></span>
				</li>

				<!-- Link al perfil -->
				<a href="<?php echo Yii::app()->createUrl('/usuarios/perfil') ?>">
					<li class="user-menu-item user-menu-hidden">
						<img alt="Perfil" src="<?php echo Yii::app()->BaseUrl ?>/images/iconos/menu/barra-perfil.png"
						     width="24" height="24"/><span class="user-menu-txt">Perfil</span>
					</li>
				</a>

				<!-- Logout -->
				<a href="<?php echo Yii::app()->createUrl('/site/logout') ?>">
					<li class="user-menu-item user-menu-hidden">
						<img alt="Logout" src="<?php echo Yii::app()->BaseUrl ?>/images/iconos/menu/barra-logout.png"
						     width="24" height="24"/><span class="user-menu-txt">Logout</span>
					</li>
				</a>
			</ul>
		</div>
	</div>
</div>

<div id="envoltorio-main">

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
						<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-empresario-2.png'; ?>" alt="menu-inicio-empresario">
					<?php break;
					case Usuarios::PERSONAJE_MOVEDORA: ?>
						<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-RRPP-2.png'; ?>" alt="menu-inicio-movedora">
					<?php break;
					case Usuarios::PERSONAJE_ULTRA: ?>
						<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-ultra.png'; ?>" alt="menu-inicio-ultra">
					<?php break;
				endswitch ?>
				<div class="nombre-menu">Inicio</div>
			</li>
		</a>
		<a href="<?php echo $this->createUrl( '/equipos/ver', array('id_equipo' => Yii::app()->user->usAfic) ); ?>">
		   	<li class="menu-item">
				<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/aficion.png'; ?>" alt="menu-aficion">
				<div class="nombre-menu">Mi Afici&oacute;n</div>
			</li>
		</a>
		<a href="<?php echo Yii::app()->createUrl('/partidos/index');?>">
		   	<li class="menu-item">
		   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/calendario.png'; ?>" alt="menu-calendario">
		   		<div class="nombre-menu">Calendario</div>
		   	</li>
	  	</a>
	   	<a href="<?php echo Yii::app()->createUrl('/acciones');?>">
	   		<li class="menu-item">
	   			<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/habilidades/habilidades.png'; ?>" alt="menu-desbloqueadas">
	   			<div class="nombre-menu">Mis Habilidades</div>
	   		</li>
	   	</a>
	   	<a href="<?php echo Yii::app()->createUrl('/habilidades');?>">
		   	<li class="menu-item">
		   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/habilidades.png'; ?>" alt="menu-arbol">
		   		<div class="nombre-menu">&Aacute;rbol Habilidades</div>
		   	</li>
	    </a>			   	
	    <a href="<?php echo Yii::app()->createUrl('/equipos');?>">
		   	<li class="menu-item menu-item-last">
		   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/clasificacion.png'; ?>" alt="menu-clasificacion">
		   		<div class="nombre-menu">Clasificaci&oacute;n</div>
		   	</li>
		</a>
	</ul>
    
    <!-- DIVISION PARA FLOTAR -->
    <div id="grupo-centro" class="top-block">

	    <!-- DIVISION CENTRAL/CONTENIDO -->
	    <div id="contenido">
	      <?php
    		foreach(Yii::app()->user->getFlashes() as $key => $message) { ?>
    			<script type="text/javascript">
    			$.jGrowl( "<?php echo $message; ?>", { sticky: true });
    			</script>
        	<?php	//echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    		}
		  ?>
		  <?php echo $content; ?>


	    </div>
  	

	</div>

	<!-- TODO Quitar esto mejorando CSS -->
	<div style="clear:both"></div>

</div>

<!-- DIVISION DEL PIE DE P�GINA -->
<!--    <div id="pie-pagina">
        Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
    </div>-->

</body>

</html>