<?php
$this->breadcrumbs=array(
	'帐号管理'=>array("account/index"),
	$usermodel->user_nkname=>array("account/view","id"=>$usermodel->user_id),
	'录入限制添加',
);

$this->menu=array(
	array('label'=>'返回学员查看', 'url'=>array("account/view","id"=>$usermodel->user_id)), 
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'usermodel'=>$usermodel)); ?>