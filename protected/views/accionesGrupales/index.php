<?php
/* @var $this AccionesGrupalesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Acciones Grupales',
);

$this->menu=array(
	array('label'=>'Create AccionesGrupales', 'url'=>array('create')),
	array('label'=>'Manage AccionesGrupales', 'url'=>array('admin')),
);
?>

<h1>Acciones Grupales</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
