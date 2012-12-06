<?php
/* @var $this ClasificacionController */
/* @var $model Clasificacion */

$this->breadcrumbs=array(
	'Clasificacions'=>array('index'),
	$model->equipos_id_equipo=>array('view','id'=>$model->equipos_id_equipo),
	'Update',
);

$this->menu=array(
	array('label'=>'List Clasificacion', 'url'=>array('index')),
	array('label'=>'Create Clasificacion', 'url'=>array('create')),
	array('label'=>'View Clasificacion', 'url'=>array('view', 'id'=>$model->equipos_id_equipo)),
	array('label'=>'Manage Clasificacion', 'url'=>array('admin')),
);
?>

<h1>Update Clasificacion <?php echo $model->equipos_id_equipo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>