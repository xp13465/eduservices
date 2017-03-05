<?php
/* @var $this ApplicationController */
/* @var $stuModel Students */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员申请列表'=>array("index"),
    '学员申请',
);
$url=isset($_COOKIE['xyckreturnurl'])?$_COOKIE['xyckreturnurl']:'students';
$this->menu=array(
    array('label'=>'返回','url'=>$url),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'stuModel'=>$stuModel)); ?>

