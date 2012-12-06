<?php
/* @var $this EquiposController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equiposes',
);

$this->menu=array(
	array('label'=>'Create Equipos', 'url'=>array('create')),
	array('label'=>'Manage Equipos', 'url'=>array('admin')),
);
?>

<h1>Equiposes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
