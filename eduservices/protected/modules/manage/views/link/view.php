<?php
/* @var $this LinkController */
/* @var $model Link */

$this->breadcrumbs=array(
	'Links'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Link', 'url'=>array('index')),
	array('label'=>'Create Link', 'url'=>array('create')),
	array('label'=>'Update Link', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Link', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Link', 'url'=>array('admin')),
);
?>

<h1>View Link #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        array(
            "name"=>"status",
            'type'=>'raw',
            'value'=>Link::$Status[$model->status],
        ),
		'listorder',    
        array(
            "name"=>"createtime",
            'type'=>'raw',
            'value'=>date("Y-m-d H:i:s",$model->createtime),
        ),
		'name',
		array(
            "name"=>"logo",
            'type'=>'raw',
            'value'=>CHtml::image($model->logo,""),
        ),
		'siteurl',
        array(
            "name"=>"typeid",
            'type'=>'raw',
            'value'=>Link::$type[$model->typeid],
        ),
        array(
            "name"=>"linktype",
            'type'=>'raw',
            'value'=>Link::$linktype[$model->linktype],
        ),
		'siteinfo',
	),
)); ?>
