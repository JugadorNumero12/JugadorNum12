<?php
/* @var $this PartidosController */
/* @var $model Partidos */

$this->breadcrumbs=array(
	'Partidoses'=>array('index'),
	$model->id_partido,
);

$this->menu=array(
	array('label'=>'List Partidos', 'url'=>array('index')),
	array('label'=>'Create Partidos', 'url'=>array('create')),
	array('label'=>'Update Partidos', 'url'=>array('update', 'id'=>$model->id_partido)),
	array('label'=>'Delete Partidos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_partido),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Partidos', 'url'=>array('admin')),
);
?>

<h1>View Partidos #<?php echo $model->id_partido; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_partido',
		'equipos_id_equipo_1',
		'equipos_id_equipo_2',
		'hora',
		'cronica',
	),
)); ?>
