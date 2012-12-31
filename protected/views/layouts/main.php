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

<div id="genLayer">

  	<!-- DIVISION DE CABECERA -->
    <div id="headBox">
		CABECERA
    </div>
	
    <!-- DIVISION DEL MENU IZQUIERDO -->
    <div id="leftMenuBar">
		<div id='cssmenu'>
			<ul>
			   <li><a href="<?php echo Yii::app()->createUrl('/usuarios/perfil');?>"><span>Perfil</span></a></li>
			   <li><a href="<?php echo Yii::app()->createUrl('/habilidades');?>">><span>Habilidades</span></a></li>
			   <li><a href="<?php echo Yii::app()->createUrl('/acciones');?>"><span>Acciones</span></a></li>
			   <li><a href='#'><span>Afici&oacute;n</span></a></li>
			   <li><a href='#'><span>Estad&iacute;sticas</span></a></li>
			   <li><a href='#'><span>Calendario</span></a></li>
			   <li><a href='#'><span>Clasificaci&oacute;n</span></a></li>
			   <li><a href='#'><span>Partido</span></a></li>
			</ul>
		</div>
    </div>
    
    <!-- DIVISION CENTRAL/CONTENIDO -->
    <div id="contentSection" align="center">
      <?php echo $content; ?>
    </div>

	<!-- DIVISION DEL MENU DERECHO -->
    <div id="rightMenuBar">
    	ESTADO JUGADOR
    	<div id='cssmenu'>
			<ul>
			   <li><a href="<?php echo Yii::app()->createUrl('/usuarios/cuenta');?>"><span>Mi Cuenta</span></a></li>
			   <li><a href='#'><span>Mensajes</span></a></li>
			   <li><a <?php echo "href=".Yii::app()->createUrl('/site/logout').""?>><span>Logout</span></a></li>
			</ul>
		</div>
    </div>
	
  	<!-- DIVISION DEL PIE DE PÁGINA -->
    <div id="bottomBox">
        <Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
    </div>
    
</div> <!-- End GenLayer -->

</body>

</html>
