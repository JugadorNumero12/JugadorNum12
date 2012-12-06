<?php
/* @var $this ClasificacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Clasificacions',
);

$this->menu=array(
	array('label'=>'Create Clasificacion', 'url'=>array('create')),
	array('label'=>'Manage Clasificacion', 'url'=>array('admin')),
);
?>

<h1>Clasificacions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
