<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo Yii::app()->language; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="<?php echo Yii::app()->charset; ?>" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

	<!-- jQuery -->
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsMain.js'); ?>

	<title><?php echo Yii::app()->name; ?></title>
</head>

<body>

<div id="envoltorio1"><div id="envoltorio2">

  	<!-- DIVISION DE CABECERA -->
    <div id="cabecera">
    	<div id = "logo">
    		<img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/logos/logo2.jpg'; ?>" width=100 height=160 border=0 alt="Logo Jugador numero 12">
    	</div>
    	<div id = "titulo-jugador">
    		<img src="<?php echo Yii::app()->BaseUrl.'/less/imagenes/logos/Jugador_Num_12_Verde.png'; ?>" width=1000 height=100 border=0 alt="Logo Jugador numero 12">
    	</div>
    	<div id = "clasificacion">
            <?php $clasificacion = Clasificacion::model()->findAll(array('order'=>'posicion ASC')); ?>
    		<ul>
    			<?php foreach ($clasificacion as $equipo) { ?>
                    <li> 
                        <a href="<?php echo $this->createUrl( '/equipos/ver', array('id_equipo' => $equipo->equipos_id_equipo) ); ?>">  
                            <?php switch ($equipo->equipos->nombre)
								{
								case 'Rojos': ?>
								  	<img title="<?php echo $equipo->posicion . "&ordm; con " . $equipo->puntos . " puntos, ver informaci&oacute;n del equipo Rojo"; ?>", class="escudos-clasificacion" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-rojo.png'; ?>" alt="Rojos">
									<?php break;
								case 'Verdes':?>
								  	<img title="<?php echo $equipo->posicion . "&ordm; con " . $equipo->puntos . " puntos, ver informaci&oacute;n del equipo Verde"; ?>", class="escudos-clasificacion" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-verde.png'; ?>" alt="Verdes">								  
									<?php break;
								case 'Negros':?>
								  	<img title="<?php echo $equipo->posicion . "&ordm; con " . $equipo->puntos . " puntos, ver informaci&oacute;n del equipo Negro"; ?>", class="escudos-clasificacion" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-negro.png'; ?>" alt="Negros">
									<?php break;
								case 'Blancos':?>				
								  	<img title="<?php echo $equipo->posicion . "&ordm; con " . $equipo->puntos . " puntos, ver informaci&oacute;n del equipo Blanco"; ?>", class="escudos-clasificacion" src="<?php echo Yii::app()->BaseUrl.'/images/escudos/escudo-blanco.png'; ?>" alt="Blancos">
									<?php break;
								} ?>
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
				<?php $personaje = Usuarios::model()->findByPK(Yii::app()->user->usIdent); ?>
				<a href="<?php echo Yii::app()->createUrl('/usuarios/perfil');?>">
				   	<li class="elementos-menu">
				   		<?php
				   			switch ($personaje->personaje){
				   				case Usuarios::PERSONAJE_ULTRA: ?>
				   					<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-ultra.png'; ?>" alt="perfil-ultra">
				   					<?php break;
				   				case Usuarios::PERSONAJE_EMPRESARIO: ?>
				   					<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-empresario.png'; ?>" alt="perfil-empresario">
				   					<?php break;
				   				case Usuarios::PERSONAJE_MOVEDORA: ?>
				   					<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-RRPP.png'; ?>" alt="perfil-RRPP">
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
				   		<div class="nombre-menu">&Aacute;rbol de <br> habilidades</div>
				   	</li>
			    </a>
			   	<a href="<?php echo Yii::app()->createUrl('/acciones');?>">
			   		<li class="elementos-menu">
			   			<img class="icono-menu" src="<?php echo Yii::app()->BaseUrl.'/images/iconos/menu/perfil-sin-definir.png'; ?>" alt="perfil-sin-definir">
			   			<div class="nombre-menu">Habilidades <br> desbloqueadas</div>
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
    <div id="grupo-derecha">

	    <!-- DIVISION CENTRAL/CONTENIDO -->
	    <div id="contenido">
	      <?php echo $content; ?>
	    </div>

		<!-- DIVISION DEL MENU DERECHO -->
	    <!--<div id="menu-derecho">
	    	<div id='cssmenu'>
				<ul>
				   <li><a href="<?php echo Yii::app()->createUrl('/usuarios/cuenta');?>"><span>Mi Cuenta</span></a></li>
				</ul>
			</div>
	    </div>-->
	    <table id="table">
		    <tr><th>Nick: </th> <td><?php echo $personaje->nick ?></td> </tr> 
			<tr><th>Nivel: </th> <td><?php echo $personaje->nivel ?> </td> </tr> 
			<tr><th> <br></th> <td> </td> <br></tr> 
			<tr><th>Dinero: </th> <td><?php echo $personaje->recursos->dinero ?></td> </tr> 
			<tr><th>&Aacute;nimo: </th> <td id="barrita"><!--<?php echo $personaje->recursos->animo ?>--> </td> </tr> 
			<tr><th>Influencias: </th> <td id="barrita"><!--<?php echo $personaje->recursos->influencias ?>--></td> </tr> 
		</table>
	</div>

	<div class="push"></div>
  	
    
</div></div> <!-- envoltorios -->

<!-- DIVISION DEL PIE DE P�GINA -->
    <div id="pie-pagina">
        <Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
    </div>

</body>

</html>