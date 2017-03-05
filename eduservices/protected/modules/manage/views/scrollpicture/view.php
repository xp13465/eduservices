<?php
$this->breadcrumbs=array(
	'Scrollpictures'=>array('index'),
	$model->sp_id,
);

$this->menu=array(
	array('label'=>'列表', 'url'=>array('index')),
	array('label'=>'新建', 'url'=>array('create')),
	array('label'=>'修改', 'url'=>array('update', 'id'=>$model->sp_id)),
	array('label'=>'删除', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->sp_id),'confirm'=>'确定删除吗?')),
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>View Scrollpicture #<?php echo $model->sp_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'sp_id',
		'sp_title',
        array(
            "name"=>"sp_picture",
            'type'=>'raw',
            'value'=>CHtml::image($model->sp_picture,"",array('width'=>"585px","height"=>"185px")),
        ),
		'sp_link',
		'sp_order',
	),
)); ?>
