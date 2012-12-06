<?php
/* @var $this PartidosController */
/* @var $model Partidos */

$this->breadcrumbs=array(
	'Partidoses'=>array('index'),
	$model->id_partido=>array('view','id'=>$model->id_partido),
	'Update',
);

$this->menu=array(
	array('label'=>'List Partidos', 'url'=>array('index')),
	array('label'=>'Create Partidos', 'url'=>array('create')),
	array('label'=>'View Partidos', 'url'=>array('view', 'id'=>$model->id_partido)),
	array('label'=>'Manage Partidos', 'url'=>array('admin')),
);
?>

<h1>Update Partidos <?php echo $model->id_partido; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>