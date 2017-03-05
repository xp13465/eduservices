<?php
$this->breadcrumbs=array(
	'Scrollpictures'=>array('index'),
	$model->sp_id=>array('view','id'=>$model->sp_id),
	'Update',
);

$this->menu=array(
	array('label'=>'图片列表', 'url'=>array('index')),
	array('label'=>'新建', 'url'=>array('create')),
	array('label'=>'查看', 'url'=>array('view', 'id'=>$model->sp_id)),
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>修改 <?php echo $model->sp_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>