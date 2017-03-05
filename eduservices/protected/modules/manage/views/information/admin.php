<?php
/* @var $this InformationController */
/* @var $model Information */

$this->breadcrumbs=array(
	'新闻管理'=>array('index'),
	'管理',
);

$this->menu=array(
	array('label'=>'列表展示', 'url'=>array('index')),
	array('label'=>'添加新闻', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#information-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理新闻</h1>

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
	'id'=>'information-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'i_id',
        array(
            "name"=>"i_class",
            "value"=>'isset(Information::$class[$data->i_class])?Information::$class[$data->i_class]:""',
        ),
		'i_label',
		'i_title',
        array(
            "name"=>"i_bool",
            "value"=>'Information::$isbool[$data->i_bool]."[{$data->i_bool}]"',  
        ),
		// 'i_con',
		/*
        'i_pic',
		
		'i_submitdate',
		'i_updatetime',
		
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
