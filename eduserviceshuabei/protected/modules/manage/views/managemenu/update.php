<?php
$this->breadcrumbs=array(
	'菜单信息管理'=>array('index'),
	$model->m_id=>array('view','id'=>$model->m_id),
	'修改',
);
$this->currentMenu = 37;
$this->menu=array(
	array('label'=>'浏览菜单', 'url'=>array('index')),
	array('label'=>'新建菜单', 'url'=>array('create')),
	array('label'=>'查看菜单', 'url'=>array('view', 'id'=>$model->m_id)),
	array('label'=>'管理菜单', 'url'=>array('admin')),
);
?>

<h1>Update Managemenu <?php echo $model->m_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>