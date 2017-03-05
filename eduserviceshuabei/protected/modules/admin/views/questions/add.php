<?php 
$this->breadcrumbs=array(
	'题库管理'=>array("questions/index"),
	'新增试题',
);
$this->menu=array(
	// array('label'=>'List Students', 'url'=>array('index')),
	// array('label'=>'Manage Students', 'url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>