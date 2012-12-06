<?php
/* @var $this AccionesGrupalesController */
/* @var $model AccionesGrupales */

$this->breadcrumbs=array(
	'Acciones Grupales'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AccionesGrupales', 'url'=>array('index')),
	array('label'=>'Create AccionesGrupales', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('acciones-grupales-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Acciones Grupales</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'acciones-grupales-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_accion_grupal',
		'usuarios_id_usuario',
		'habilidades_id_habilidad',
		'equipos_id_equipo',
		'influencias_acc',
		'animo_acc',
		/*
		'dinero_acc',
		'jugadores_acc',
		'finalizacion',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
