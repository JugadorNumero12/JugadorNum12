<?php
/* @var $this AccionesGrupalesController */
/* @var $model AccionesGrupales */

$this->breadcrumbs=array(
	'Acciones Grupales'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AccionesGrupales', 'url'=>array('index')),
	array('label'=>'Manage AccionesGrupales', 'url'=>array('admin')),
);
?>

<h1>Create AccionesGrupales</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>