<?php
/* @var $this LookupController */
/* @var $model Lookup */

$this->breadcrumbs=array(
	'Lookups'=>array('index'),
	$model->lu_id=>array('view','id'=>$model->lu_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lookup', 'url'=>array('index')),
	array('label'=>'Create Lookup', 'url'=>array('create')),
	array('label'=>'View Lookup', 'url'=>array('view', 'id'=>$model->lu_id)),
	array('label'=>'Manage Lookup', 'url'=>array('admin')),
);
?>

<h1>Update Lookup <?php echo $model->lu_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>