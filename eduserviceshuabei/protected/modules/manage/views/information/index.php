<?php
/* @var $this InformationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    '新闻管理'=>array('index'),
	'列表',
);

$this->menu=array(
	array('label'=>'添加新闻', 'url'=>array('create')),
	array('label'=>'管理新闻', 'url'=>array('admin')),
);
?>

<h1>新闻列表</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
