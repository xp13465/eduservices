<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'帐号管理'=>array("account/index"),
	'帐号添加',
);
$url=isset($_COOKIE['accountreturnurl'])?$_COOKIE['accountreturnurl']:array("index");
$this->menu=array(
	array('label'=>'返回', 'url'=>$url),
	
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

