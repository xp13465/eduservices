<?php
$this->breadcrumbs=array(
	'菜单信息管理'=>array('index'),
	$model->m_id,
);
$this->currentMenu = 37;
$this->menu=array(
	array('label'=>'浏览菜单', 'url'=>array('index')),
	array('label'=>'新建菜单', 'url'=>array('create')),
	array('label'=>'修改菜单', 'url'=>array('update', 'id'=>$model->m_id)),
	array('label'=>'删除菜单', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->m_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'管理菜单', 'url'=>array('admin')),
);
?>

<h1>View Managemenu #<?php echo $model->m_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'm_id',
		'm_name',
		'm_link',
		'm_parentid',
        array(
        'name'=>"m_role",
        'value'=>User::model()->getUserName(explode(",",$model->m_role))
        ),
	),
)); ?>
