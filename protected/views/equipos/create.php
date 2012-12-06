<?php
/* @var $this EquiposController */
/* @var $model Equipos */

$this->breadcrumbs=array(
	'Equiposes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Equipos', 'url'=>array('index')),
	array('label'=>'Manage Equipos', 'url'=>array('admin')),
);
?>

<h1>Create Equipos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>