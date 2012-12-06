<?php
/* @var $this AccionesGrupalesController */
/* @var $model AccionesGrupales */

$this->breadcrumbs=array(
	'Acciones Grupales'=>array('index'),
	$model->id_accion_grupal,
);

$this->menu=array(
	array('label'=>'List AccionesGrupales', 'url'=>array('index')),
	array('label'=>'Create AccionesGrupales', 'url'=>array('create')),
	array('label'=>'Update AccionesGrupales', 'url'=>array('update', 'id'=>$model->id_accion_grupal)),
	array('label'=>'Delete AccionesGrupales', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_accion_grupal),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccionesGrupales', 'url'=>array('admin')),
);
?>

<h1>View AccionesGrupales #<?php echo $model->id_accion_grupal; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_accion_grupal',
		'usuarios_id_usuario',
		'habilidades_id_habilidad',
		'equipos_id_equipo',
		'influencias_acc',
		'animo_acc',
		'dinero_acc',
		'jugadores_acc',
		'finalizacion',
	),
)); ?>
