<?php
/* @var $this HabilidadesController */
/* @var $model Habilidades */

$this->breadcrumbs=array(
	'Habilidades'=>array('index'),
	$model->id_habilidad=>array('view','id'=>$model->id_habilidad),
	'Update',
);

$this->menu=array(
	array('label'=>'List Habilidades', 'url'=>array('index')),
	array('label'=>'Create Habilidades', 'url'=>array('create')),
	array('label'=>'View Habilidades', 'url'=>array('view', 'id'=>$model->id_habilidad)),
	array('label'=>'Manage Habilidades', 'url'=>array('admin')),
);
?>

<h1>Update Habilidades <?php echo $model->id_habilidad; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>