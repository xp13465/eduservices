<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员列表'=>array("index"),
	'学员编辑',
);
$url=isset($_COOKIE['xylistreturnurl'])?$_COOKIE['xylistreturnurl']:array("index");
$this->menu=array(
	array('label'=>'返回', 'url'=>$url),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>