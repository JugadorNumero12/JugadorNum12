<?php
/* @var $this HabilidadesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Habilidades',
);

$this->menu=array(
	array('label'=>'Create Habilidades', 'url'=>array('create')),
	array('label'=>'Manage Habilidades', 'url'=>array('admin')),
);
?>

<h1>Habilidades</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
