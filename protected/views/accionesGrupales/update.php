<?php
/* @var $this AccionesGrupalesController */
/* @var $model AccionesGrupales */

$this->breadcrumbs=array(
	'Acciones Grupales'=>array('index'),
	$model->id_accion_grupal=>array('view','id'=>$model->id_accion_grupal),
	'Update',
);

$this->menu=array(
	array('label'=>'List AccionesGrupales', 'url'=>array('index')),
	array('label'=>'Create AccionesGrupales', 'url'=>array('create')),
	array('label'=>'View AccionesGrupales', 'url'=>array('view', 'id'=>$model->id_accion_grupal)),
	array('label'=>'Manage AccionesGrupales', 'url'=>array('admin')),
);
?>

<h1>Update AccionesGrupales <?php echo $model->id_accion_grupal; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>