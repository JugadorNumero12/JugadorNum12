<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo Yii::app()->language; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

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
 
    </div>

    <!-- DIVISION DE RECURSOS -->
    <div id="recursos">
    	<!--  <?php $id= Yii::app()->user->usIdent;
        	  $modeloUsuario = Usuarios:: model()->findByPk($id);  ?>
    	<ul>
		  <li> Dinero: <?php echo $modeloUsuario->recursos->dinero; ?></li>
		  <li> Animo: <?php echo $modeloUsuario->recursos->animo; ?></li>
		  <li> Influencia: <?php echo $modeloUsuario->recursos->influencias; ?></li>
		</ul>
		 -->
    </div>
	
    <!-- DIVISION DEL MENU IZQUIERDO -->
    <div id="menu-izquierdo">
		<div id='cssmenu'>
			<ul>
			   <li><a href="<?php echo Yii::app()->createUrl('/usuarios/perfil');?>"><span>Perfil</span></a></li>
			   <li><a href="<?php echo Yii::app()->createUrl('/acciones');?>"><span>Habilidades desbloqueadas</span></a></li>
			   <li><a href="<?php echo $this->createUrl( '/equipos/ver', 
									array('id_equipo' => Yii::app()->user->usAfic) ); ?>"><span>Afici&oacute;n</span></a></li>
			   <li><a href="<?php echo Yii::app()->createUrl('/partidos/index');?>"><span>Calendario de partidos</span></a></li>
			   <li><a href="<?php echo Yii::app()->createUrl('/habilidades');?>"><span>&Aacute;rbol de habilidades</span></a></li>
			   <li><a href="<?php echo Yii::app()->createUrl('/equipos');?>"><span>Clasificaci&oacute;n</span></a></li>
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
	    <div id="menu-derecho">
	    	<div id='cssmenu'>
				<ul>
				   <li><a href="<?php echo Yii::app()->createUrl('/usuarios/cuenta');?>"><span>Mi Cuenta</span></a></li>
				   <li><a <?php echo "href=".Yii::app()->createUrl('/site/logout').""?>><span>Logout</span></a></li>
				</ul>
			</div>
	    </div>

	</div>
  	<!-- DIVISION DEL PIE DE PÁGINA -->
    <div id="pie-pagina">
        <Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
    </div>
    
</div></div> <!-- envoltorio -->

</body>

</html>