<?php
$this->breadcrumbs=array(
	'帐号管理'=>array("account/index"),
    '录入限制'=>array("inputlimits/index"),
	$usermodel->user_nkname=>array("account/view","id"=>$usermodel->user_id),
	'录入限制修改',
);

$url=isset($_COOKIE['illisturnurl'])?$_COOKIE['illisturnurl']:array("inputlimits/index");
$this->menu=array(
	array('label'=>'返回学员查看', 'url'=>array("account/view","id"=>$usermodel->user_id)), 
	array('label'=>'返回录入限制列表', 'url'=>$url),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'usermodel'=>$usermodel)); ?>