<?php
/* @var $this InformationController */
/* @var $model Information */

$this->breadcrumbs=array(
	'新闻公告列表'=>array("index"),
    '公告修改',
);
$url = isset($_COOKIE['ggnewslistreturnurl'])?$_COOKIE['ggnewslistreturnurl']:"information";
if(isset($_GET['return'])&&$_GET['return']=='view'){
    $this->menu=array(
    array('label'=>'返回新闻公告列表',"url"=>$url),
    array('label'=>'返回',"url"=>array("view","id"=>$model->i_id)),
);
}else{
    $this->menu=array(
    array('label'=>'返回',"url"=>$url),
);
}
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

