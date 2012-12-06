<?php
/* @var $this PartidosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Partidoses',
);

$this->menu=array(
	array('label'=>'Create Partidos', 'url'=>array('create')),
	array('label'=>'Manage Partidos', 'url'=>array('admin')),
);
?>

<h1>Partidoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
