<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员申请管理列表'=>array("index"),
	'学员申请编辑',
);
if(isset($_GET['return'])&&$_GET['return']=='view'){
    $url=array("view","id"=>$model->sa_id);
    $label='查看';
}else{
    $url = isset($_COOKIE['xysqlistreturnurl'])?$_COOKIE['xysqlistreturnurl']:"application";
    $label='学员申请列表';
}
$this->menu=array(
	array('label'=>$label, 'url'=>$url),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'stuModel'=>$stuModel)); ?>