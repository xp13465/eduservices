<?php
/* @var $this InformationController */
/* @var $model Information */

$this->breadcrumbs=array(
	
	'新闻管理'=>array('index'),
	'添加',
);

$this->menu=array(
	array('label'=>'列表展示', 'url'=>array('index')),
	array('label'=>'管理新闻', 'url'=>array('admin')),
);
?>

<h1>添加新闻</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>