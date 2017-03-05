<?php
/* @var $this ExampaperController */
/* @var $model Exampaper */

$this->breadcrumbs=array(
	'Exampapers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Exampaper', 'url'=>array('index')),
	array('label'=>'Create Exampaper', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#exampaper-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Exampapers</h1>

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
	'id'=>'exampaper-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'e_id',
		'e_name',
		'e_cat',
		'e_display',
		'e_maxenum',
		'e_btime',
		/*
		'e_etime',
		'e_timecat',
		'e_treap',
		'e_tsecurity',
		'e_esecurity',
		'e_edescription',
		'e_snum',
		'e_scat',
		'e_rpeople',
		'e_scoreset',
		'e_pstrategy',
		'e_totals',
		'e_passs',
		'e_use',
		'e_isdel',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
