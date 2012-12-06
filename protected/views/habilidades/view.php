<?php
/* @var $this HabilidadesController */
/* @var $model Habilidades */

$this->breadcrumbs=array(
	'Habilidades'=>array('index'),
	$model->id_habilidad,
);

$this->menu=array(
	array('label'=>'List Habilidades', 'url'=>array('index')),
	array('label'=>'Create Habilidades', 'url'=>array('create')),
	array('label'=>'Update Habilidades', 'url'=>array('update', 'id'=>$model->id_habilidad)),
	array('label'=>'Delete Habilidades', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_habilidad),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Habilidades', 'url'=>array('admin')),
);
?>

<h1>View Habilidades #<?php echo $model->id_habilidad; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_habilidad',
		'codigo',
	),
)); ?>
