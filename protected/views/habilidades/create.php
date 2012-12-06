<?php
/* @var $this HabilidadesController */
/* @var $model Habilidades */

$this->breadcrumbs=array(
	'Habilidades'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Habilidades', 'url'=>array('index')),
	array('label'=>'Manage Habilidades', 'url'=>array('admin')),
);
?>

<h1>Create Habilidades</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>