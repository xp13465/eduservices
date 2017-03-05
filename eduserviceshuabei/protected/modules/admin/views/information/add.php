<?php
/* @var $this InformationController */
/* @var $model Information */

$this->breadcrumbs=array(
	'新闻公告列表'=>array("index"),
    '公告添加',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

