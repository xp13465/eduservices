<?php
$this->breadcrumbs=array(
	'Scrollpictures'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'列表', 'url'=>array('index')),
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>Create Scrollpicture</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>