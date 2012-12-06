<?php
/* @var $this ClasificacionController */
/* @var $model Clasificacion */

$this->breadcrumbs=array(
	'Clasificacions'=>array('index'),
	$model->equipos_id_equipo,
);

$this->menu=array(
	array('label'=>'List Clasificacion', 'url'=>array('index')),
	array('label'=>'Create Clasificacion', 'url'=>array('create')),
	array('label'=>'Update Clasificacion', 'url'=>array('update', 'id'=>$model->equipos_id_equipo)),
	array('label'=>'Delete Clasificacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->equipos_id_equipo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Clasificacion', 'url'=>array('admin')),
);
?>

<h1>View Clasificacion #<?php echo $model->equipos_id_equipo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'equipos_id_equipo',
		'posicion',
		'puntos',
		'ganados',
		'empatados',
		'perdidos',
	),
)); ?>
