<?php
$this->currentMenu = 82;
$this->breadcrumbs=array(
	'优化管理'=>array('index'),
	'修改基本信息',
);

$this->menu=array(
	array('label'=>'查看所有小区', 'url'=>array('index')),
	array('label'=>'新增SEO优化', 'url'=>array('create')),
	array('label'=>'删除SEO优化', 'url'=>array('delete',"id"=>$model->stkd_id,)),
);
?>

<h1>修改优化位置为<?php echo $model->getPosition($model->stkd_id);?>，Id为 <?php echo $model->stkd_id; ?>的数据</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>