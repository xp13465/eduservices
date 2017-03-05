<?php 
$this->breadcrumbs=array(
	'题库管理'=>array("questions/index"),
	'修改试题',
);
$url=isset($_COOKIE['tkreturnurl'])?$_COOKIE['tkreturnurl']:array("index");

$this->menu=array(
    array('label'=>'返回列表', 'url'=>$url),
    array('label'=>'查看', 'url'=>array("questions/view","id"=>$model->t_id)),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>