<?php
/* @var $this AppendixController */
/* @var $model Appendix */

$this->breadcrumbs=array(
	'Appendixes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Appendix', 'url'=>array('index')),
	array('label'=>'Create Appendix', 'url'=>array('create')),
	array('label'=>'View Appendix', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Appendix', 'url'=>array('admin')),
);
?>

<h1>Update Appendix <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>