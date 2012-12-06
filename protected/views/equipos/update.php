<?php
/* @var $this EquiposController */
/* @var $model Equipos */

$this->breadcrumbs=array(
	'Equiposes'=>array('index'),
	$model->id_equipo=>array('view','id'=>$model->id_equipo),
	'Update',
);

$this->menu=array(
	array('label'=>'List Equipos', 'url'=>array('index')),
	array('label'=>'Create Equipos', 'url'=>array('create')),
	array('label'=>'View Equipos', 'url'=>array('view', 'id'=>$model->id_equipo)),
	array('label'=>'Manage Equipos', 'url'=>array('admin')),
);
?>

<h1>Update Equipos <?php echo $model->id_equipo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>