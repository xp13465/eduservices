<?php
/* @var $this InformationController */
/* @var $model Information */

$this->breadcrumbs=array(
    '新闻管理'=>array('index'),
	$model->i_id=>array('view','id'=>$model->i_id),
	'编辑',
);

$this->menu=array(
	array('label'=>'列表展示', 'url'=>array('index')),
	array('label'=>'添加新闻', 'url'=>array('create')),
	array('label'=>'查看本新闻', 'url'=>array('view', 'id'=>$model->i_id)),
	array('label'=>'管理新闻', 'url'=>array('admin')),
);
?>

<h1>编辑新闻 <?php echo $model->i_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>