<?php
/* @var $this SchoolaboutController */
/* @var $model Schoolabout */

$this->breadcrumbs=array(
	'Schoolabouts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Schoolabout', 'url'=>array('index')),
	array('label'=>'Manage Schoolabout', 'url'=>array('admin')),
);
?>

<h1>Create Schoolabout</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>