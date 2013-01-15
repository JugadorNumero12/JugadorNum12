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

	<div class="envoltorio-registro"> <div class="envoltorio2-registro">

	   		<div id="entrada-registro">
				<p><?php echo $content; ?></p>
	   		</div>

		<div class="push"></div>

	</div> </div> <!--ENVOLTORIOS-->

		<div class="pie-pagina-registro">
			<Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
			All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?>
		</div>


</body>

</html>