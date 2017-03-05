<?php
/* @var $this AppendixController */
/* @var $model Appendix */

$this->breadcrumbs=array(
	'Appendixes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Appendix', 'url'=>array('index')),
	array('label'=>'Create Appendix', 'url'=>array('create')),
	array('label'=>'Update Appendix', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Appendix', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Appendix', 'url'=>array('admin')),
);
?>

<h1>View Appendix #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
            "name"=>"status",
            'type'=>'raw',
            'value'=>Link::$Status[$model->status],
        ),
        array(
            "name"=>"ishome",
            'type'=>'raw',
            'value'=>Appendix::$ishome[$model->ishome],
        ),
		array(
            "name"=>"createtime",
            'type'=>'raw',
            'value'=>date("Y-m-d H:i:s",$model->createtime),
        ),
		'name',
		array(
            "name"=>"pic",
            'type'=>'raw',
            'value'=>CHtml::image($model->pic,""),
        ),
        array(
            "name"=>"fileurl",
            'value'=>DOMAIN.$model->fileurl,
        ),
		array(
            "name"=>"typeid",
            'type'=>'raw',
            'value'=>Appendix::$type[$model->typeid],
        ),
		'siteinfo',
	),
)); ?>
