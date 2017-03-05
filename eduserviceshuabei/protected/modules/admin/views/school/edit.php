<?php
/* @var $this ProfessionalController */
/* @var $model Professional */

$this->breadcrumbs=array(
	'学校信息设置'=>array("index"),
	'院校管理'=>array("index"),
	'院校编辑',
);

$url=isset($_COOKIE['schoolreturnurl'])?$_COOKIE['schoolreturnurl']:array("index");
$this->menu=array(
	array('label'=>'返回', 'url'=>$url),
);



?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>