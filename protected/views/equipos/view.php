<?php
/* @var $this EquiposController */
/* @var $model Equipos */

$this->breadcrumbs=array(
	'Equiposes'=>array('index'),
	$model->id_equipo,
);

$this->menu=array(
	array('label'=>'List Equipos', 'url'=>array('index')),
	array('label'=>'Create Equipos', 'url'=>array('create')),
	array('label'=>'Update Equipos', 'url'=>array('update', 'id'=>$model->id_equipo)),
	array('label'=>'Delete Equipos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_equipo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Equipos', 'url'=>array('admin')),
);
?>

<h1>View Equipos #<?php echo $model->id_equipo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_equipo',
		'nombre',
		'categoria',
		'aforo_max',
		'aforo_base',
		'nivel_equipo',
		'factor_ofensivo',
		'factor_defensivo',
	),
)); ?>
