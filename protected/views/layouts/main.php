<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo Yii::app()->language; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="<?php echo Yii::app()->charset; ?>" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />


	<!-- LESS import script -->
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/main.less" />
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
	        rootpath: ":/a.com/"// a path to add on to the start of every url
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
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsPerfil.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsGraficoCircular.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsPartido.js'); ?>
	<title><?php echo Yii::app()->name; ?></title>
</head>

<body>

<div id="envoltorio1"><div id="envoltorio2">

	<!-- Barra Superior -->
	<div id="barrasup">
		<div id="barrasup-envoltorio">
			<!-- Nivel / Recursos / Notificaciones / Equipo / Perfil -->
			<div id="barrasup-izquierda">Izquierda</div>

			<div id="barrasup-centro">
				<div class="barrasup-recursos" title="Dinero">
					<img class="barrasup-icono" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-dinero.png';?>" alt="Icono dinero">
					<div id="barrasup-progressbar-dinero" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->dinero) ?>">
						<div id="progressbar-label-dinero"></div>
					</div>
				</div>
				<div class="barrasup-recursos" title="&Aacute;nimo">
					<img class="barrasup-icono" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-animo.png';?>" alt="Icono animo">
					<div id="barrasup-progressbar-animo" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->animo)?>" data-max="<?php echo Yii::app()->getParams()->usuario->recursos->animo_max ?>">
						<div id="progressbar-label-animo"></div>
					</div>
				</div> 
				<div class="barrasup-recursos" title="Influencias">
					<img class="barrasup-icono" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/menu-influencia.png';?>" alt="Icono influencias">
					<div id="barrasup-progressbar-influencias" data-valor="<?php echo (Yii::app()->getParams()->usuario->recursos->influencias)?>" data-max="<?php echo Yii::app()->getParams()->usuario->recursos->influencias_max ?>">
						<div id="progressbar-label-influencias"></div>
					</div>
				</div> 
			</div>

			<div id="barrasup-derecha">
				<ul id="user-menu">
					<li class="user-menu-item">
						<img alt="<?php echo Yii::app()->getParams()->usuario->nick; ?>"
						     src="" width="24" height="24"><span class="user-menu-txt"><?php echo Yii::app()->getParams()->usuario->nick; ?></span>
					</li>

					<a href="<?php echo Yii::app()->createUrl('/usuarios/perfil') ?>">
						<li class="user-menu-item user-menu-hidden">
							<img alt="Perfil" src="<?php echo Yii::app()->BaseUrl ?>/images/iconos/menu/barra-perfil.png"
							     width="24" height="24"/><span class="user-menu-txt">Perfil</span>
						</li>
					</a>
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

  	<!-- DIVISION DE CABECERA -->
    <div id="cabecera">
    	<div id = "logo">
    		<img src="<?php echo Yii::app()->BaseUrl.'/images/logos/logo2.jpg'; ?>" width=100 height=160 border=0 alt="Logo Jugador numero 12">
    	</div>
    	<div id = "titulo-jugador">
    		<img src="<?php echo Yii::app()->BaseUrl.'/images/logos/Jugador_Num_12_Verde.png'; ?>" width=800 height=100 border=0 alt="Logo Jugador numero 12">
    	</div>
    	<div id = "clasificacion">
            <?php $clasificacion = Clasificacion::model()->with('equipos')->findAll(array('order'=>'posicion ASC')); ?>
    		<ul>
    			<?php foreach ($clasificacion as $equipo) { ?>
                    <li> 
                        <a href="<?php echo $this->createUrl( '/equipos/ver', array('id_equipo' => $equipo->equipos_id_equipo) ); ?>">  
                            <img
                            	title="<?php echo $equipo->posicion . '&ordm; con ' . $equipo->puntos . ' puntos'; ?>",
                            	class="escudos-clasificacion equipo-<?php echo $equipo->equipos->token ?>"
                            	src="<?php echo Yii::app()->BaseUrl . '/images/escudos/' . $equipo->equipos->token . '.png'; ?>"
                            	alt="<?php echo $equipo->equipos->nombre; ?>">		
                        </a>
                    </li>
                <?php } ?>
    		</ul>
    	</div>
 
    </div>
	
    <!-- DIVISION DEL MENU IZQUIERDO -->
    <div id="menu-izquierdo">
		<div id='cssmenu'>
			<ul>
				<a href="<?php echo Yii::app()->createUrl('/usuarios/perfil');?>">
				   	<li class="elementos-menu">
				   		<?php
				   			switch (Yii::app()->getParams()->usuario->personaje){
				   				case Usuarios::PERSONAJE_ULTRA: ?>
				   					<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-ultra.png'; ?>" alt="perfil-ultra">
				   					<?php break;
				   				case Usuarios::PERSONAJE_EMPRESARIO: ?>
				   					<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-empresario-2.png'; ?>" alt="perfil-empresario">
				   					<?php break;
				   				case Usuarios::PERSONAJE_MOVEDORA: ?>
				   					<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-RRPP-2.png'; ?>" alt="perfil-RRPP">
				   					<?php break;
				   			}
				   		?>
				   		<div class="nombre-menu">Perfil</div>
				   	</li>
				</a>
				<a href="<?php echo $this->createUrl( '/equipos/ver', array('id_equipo' => Yii::app()->user->usAfic) ); ?>">
				   	<li class="elementos-menu">
						<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-sin-definir.png'; ?>" alt="perfil-sin-definir">
						<div class="nombre-menu">Afici&oacute;n</div>
					</li>
				</a>
				<a href="<?php echo Yii::app()->createUrl('/habilidades');?>">
				   	<li class="elementos-menu">
				   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-sin-definir.png'; ?>" alt="perfil-sin-definir">
				   		<div class="nombre-menu">Habilidades</div>
				   	</li>
			    </a>
			   	<a href="<?php echo Yii::app()->createUrl('/acciones');?>">
			   		<li class="elementos-menu">
			   			<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-sin-definir.png'; ?>" alt="perfil-sin-definir">
			   			<div class="nombre-menu">Desbloqueadas</div>
			   		</li>
			   	</a>			   	
				<a href="<?php echo Yii::app()->createUrl('/partidos/index');?>">
				   	<li class="elementos-menu">
				   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-sin-definir.png'; ?>" alt="perfil-sin-definir">
				   		<div class="nombre-menu">Calendario</div>
				   	</li>
			  	</a>
			    <a href="<?php echo Yii::app()->createUrl('/equipos');?>">
				   	<li class="elementos-menu">
				   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-sin-definir.png'; ?>" alt="perfil-sin-definir">
				   		<div class="nombre-menu">Clasificaci&oacute;n</div>
				   	</li>
				</a>
				<a <?php echo "href=".Yii::app()->createUrl('/site/logout').""?>>
				   	<li class="elementos-menu">
				   		<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-sin-definir.png'; ?>" alt="perfil-sin-definir">
				   		<div class="nombre-menu">Logout</div>
				   	</li>
				</a>

			</ul>
		</div>
    </div>
    
    <!-- DIVISION PARA FLOTAR -->
    <div id="grupo-centro">

	    <!-- DIVISION CENTRAL/CONTENIDO -->
	    <div id="contenido">
	      <?php
    			foreach(Yii::app()->user->getFlashes() as $key => $message) {
        			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    			}
		  ?>
	      <?php echo $content; ?>
	    </div>

	<div class="push"></div>
  	
    
</div></div> <!-- envoltorios -->

<!-- DIVISION DEL PIE DE PÁGINA -->
    <div id="pie-pagina">
        Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
    </div>

</body>

</html>