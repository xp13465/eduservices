<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'免考管理'=>array("emapp/index"),
	'信息编辑',
);
$url=isset($_COOKIE['emappreturnurl'])?$_COOKIE['emappreturnurl']:array("index");
$this->menu=array(
	array('label'=>'返回', 'url'=>$url),
    array('label'=>'查看', 'url'=>array("view",'id'=>$model->mk_id)),
	
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

