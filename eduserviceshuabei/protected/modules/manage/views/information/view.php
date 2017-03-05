<?php
/* @var $this InformationController */
/* @var $model Information */

$this->breadcrumbs=array(
	'新闻管理'=>array('index'),
    '查看',
	$model->i_id,
);

$this->menu=array(
	array('label'=>'列表展示', 'url'=>array('index')),
	array('label'=>'添加新闻', 'url'=>array('create')),
	array('label'=>'编辑本新闻', 'url'=>array('update', 'id'=>$model->i_id)),
	array('label'=>'删除本新闻', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->i_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'管理新闻', 'url'=>array('admin')),
);
?>

<h1>查看新闻 #<?php echo $model->i_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'i_id',
        array(
            "name"=>"i_class",
            "value"=>Information::$class[$model->i_class],  
        ),
		'i_label',
		'i_title',
        array(
            "name"=>"i_pic",
            'type'=>'raw',
            'value'=>CHtml::image($model->i_pic,"",array("width"=>"200px",'height'=>"120px")),
        ),
        array(
            "name"=>"i_con",
            'type'=>'raw',
            'value'=>$model->i_con,
        ),
		'i_click',
        array(
            "name"=>"i_bool",
            "value"=>Information::$isbool[$model->i_bool],  
        ),
        array(
            "name"=>"i_submitdate",
            "value"=>$model->i_submitdate?date("Y-m-d H:i:s",$model->i_submitdate):"",  
        ),
         array(
            "name"=>"i_updatetime",
            "value"=>$model->i_submitdate?date("Y-m-d H:i:s",$model->i_updatetime):"",  
        ),
		'i_form',
		'i_author',
	),
)); ?>
