<?php
/* @var $this PartidosController */
/* @var $model Partidos */

$this->breadcrumbs=array(
	'Partidoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Partidos', 'url'=>array('index')),
	array('label'=>'Manage Partidos', 'url'=>array('admin')),
);
?>

<h1>Create Partidos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>