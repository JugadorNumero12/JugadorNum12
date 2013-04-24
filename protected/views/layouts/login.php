<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="<?php echo Yii::app()->language; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />


	<!-- LESS import script -->
	<?php
	Helper::registerStyleFile('loginLayout');
	Helper::registerStyleFile('general');
	/*
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/loginLayout.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/general.less" />
	*/?>


	<!-- jQuery -->
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/scriptsRegistro.js'); ?>
	<title><?php echo Yii::app()->name; ?></title>

<?php
	if (defined('YII_DEBUG') && YII_DEBUG) {
		Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/less-boot.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->BaseUrl.'/js/less.js');
	}
?>
</head>

<body>

	<div class="envoltorio-login"> <div class="envoltorio2-login">

		<p><?php echo $content; ?></p>
	   	
		<div class="push"></div>

	</div> </div> <!--ENVOLTORIOS-->
		<!-- PIE DE PAGINA
		<div class="pie-pagina-login">
			<Copyright &copy; <?php echo date('Y'); ?> by Unknown.<br/>
			All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?>
		</div>
		-->


</body>

</html>