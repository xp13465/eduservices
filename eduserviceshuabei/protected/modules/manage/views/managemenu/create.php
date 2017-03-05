<?php
$this->breadcrumbs=array(
	'菜单信息管理'=>array('index'),
	'新建',
);
$this->currentMenu = 37;
$this->menu=array(
	array('label'=>'浏览菜单', 'url'=>array('index')),
	array('label'=>'管理菜单', 'url'=>array('admin')),
);
?>

<h1>Create Managemenu</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'managemenu-grid',
	'dataProvider'=>$searchModel->search(),
	'filter'=>$searchModel,
	'columns'=>array(
		'm_id',
		'm_name',
        'm_link',
		'm_parentid',
	),
)); ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>