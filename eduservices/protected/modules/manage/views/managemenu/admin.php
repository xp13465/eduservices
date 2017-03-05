<?php
$this->breadcrumbs=array(
	'菜单信息管理'=>array('index'),
	'管理',
);
$this->currentMenu = 37;
$this->menu=array(
	array('label'=>'浏览菜单', 'url'=>array('index')),
	array('label'=>'新建菜单', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('managemenu-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Managemenus</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'managemenu-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'm_id',
		'm_name',
		'm_link',
		'm_parentid',
        array(
        'name'=>"m_role",
        'value'=>'User::model()->getUserName(explode(",",$data->m_role))'
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
