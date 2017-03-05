<?php
/* @var $this OrganizationController */
/* @var $model Organization */

$this->breadcrumbs=array(
	'学习中心'=>array("index"),
	$show.'管理'=>array("index",'type'=>$type),
	$show.'编辑',
);
$url=isset($_COOKIE['organreturnurl'])?$_COOKIE['organreturnurl']:array("index",'type'=>$type);
$this->menu=array(
	array('label'=>'返回', 'url'=>$url),
);
?>
	

<?php echo $this->renderPartial('_form', array('model'=>$model,'show'=>$show)); ?>