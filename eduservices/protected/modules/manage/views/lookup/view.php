<?php
/* @var $this LookupController */
/* @var $model Lookup */

$this->breadcrumbs=array(
	'Lookups'=>array('index'),
	$model->lu_id,
);

$this->menu=array(
	array('label'=>'List Lookup', 'url'=>array('index')),
	array('label'=>'Create Lookup', 'url'=>array('create')),
	array('label'=>'Update Lookup', 'url'=>array('update', 'id'=>$model->lu_id)),
	array('label'=>'Delete Lookup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lu_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lookup', 'url'=>array('admin')),
);
?>

<h1>View Lookup #<?php echo $model->lu_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lu_id',
		'lu_key',
		'lu_value',
		'lu_class',
		'lu_info',
		'lu_code',
	),
)); ?>
