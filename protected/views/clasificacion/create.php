<?php
/* @var $this ClasificacionController */
/* @var $model Clasificacion */

$this->breadcrumbs=array(
	'Clasificacions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Clasificacion', 'url'=>array('index')),
	array('label'=>'Manage Clasificacion', 'url'=>array('admin')),
);
?>

<h1>Create Clasificacion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>