<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'帐号管理'=>array("account/index"),
	'帐号编辑',
);
$url=isset($_COOKIE['accountreturnurl'])?$_COOKIE['accountreturnurl']:array("index");
$this->menu=array(
	array('label'=>'返回', 'url'=>$url),
    array('label'=>'查看', 'url'=>array("view",'id'=>$model->user_id)),
	
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

