<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo Yii::app()->language; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
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
	<title><?php echo Yii::app()->name; ?></title>
</head>

<body>

	<div class="envoltorio-login"> <div class="envoltorio2-login">

		<div id="descripcion-login">
			<h1>Bienvenido a Jugador n&uacute;mero 12</h1>
			<p> </b>Un juego de estrategia multijugador, centrado en la gesti&oacute;n de pe&ntilde;as de aficionados.
	      		Ponte en la piel de un hincha y organiza la afici&oacute;n de tu equipo para llevarlo a lo m&aacute;s alto.</br></b></p>
	      	<p>
	      		</br>
	      	</p>
			<a href="<?php echo Yii::app()->createUrl('/registro/index', array());?>" class="button large black">Reg&iacute;strate</a>
	   	</div>

	   	<div id="grupo-derecha-login"> 

			<div id="columna-vacia-central-login"> </div>

	   		<div id="entrada-login">
				<p><?php echo $content; ?></p>
	   		</div>
	
		</div>

   	

		<div class="push"></div>

	</div> </div> <!--ENVOLTORIOS-->

		<div class="pie-pagina-login">
			<Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
			All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?>
		</div>


</body>

</html>