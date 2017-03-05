<?php
/* @var $this ExamController */
/* @var $model Score */

$this->breadcrumbs=array(
	'Scores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Score', 'url'=>array('index')),
	array('label'=>'Create Score', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#score-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Scores</h1>

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
	'id'=>'score-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'sc_id',
		'sc_sid',
		'sc_sjid',
		'sc_thanswer',
		'sc_kgmark',
		'sc_zgmark',
		/*
		'sc_status',
		'sc_readerid',
		'sc_remark',
		'sc_sdt',
		'sc_ldt',
		'sc_source',
		'sc_isdel',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
