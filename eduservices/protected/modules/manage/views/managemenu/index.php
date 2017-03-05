<?php
$this->breadcrumbs=array(
	'菜单信息管理',
);
$this->currentMenu = 37;
$this->menu=array(
	array('label'=>'新建菜单', 'url'=>array('create')),
	array('label'=>'管理菜单', 'url'=>array('admin')),
);
?>

<h1>Managemenus</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
