<?php
/* @var $this ProfessionalController */
/* @var $model Professional */

$this->breadcrumbs=array(
	'学校信息设置'=>array("index"),
	'专业管理'=>array("index"),
	'专业编辑',
);

$url=isset($_COOKIE['professionalreturnurl'])?$_COOKIE['professionalreturnurl']:array("index");
$this->menu=array(
	array('label'=>'返回', 'url'=>$url),
);



?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>