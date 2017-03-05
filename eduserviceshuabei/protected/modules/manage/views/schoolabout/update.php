<?php
/* @var $this SchoolaboutController */
/* @var $model Schoolabout */

$this->breadcrumbs=array(
	'Schoolabouts'=>array('index'),
	$model->sa_id=>array('view','id'=>$model->sa_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Schoolabout', 'url'=>array('index')),
	array('label'=>'Create Schoolabout', 'url'=>array('create')),
	array('label'=>'View Schoolabout', 'url'=>array('view', 'id'=>$model->sa_id)),
	array('label'=>'Manage Schoolabout', 'url'=>array('admin')),
);
?>

<h1>Update Schoolabout <?php echo $model->sa_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>