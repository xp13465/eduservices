<?php
/* @var $this SchoolaboutController */
/* @var $model Schoolabout */

$this->breadcrumbs=array(
	'Schoolabouts'=>array('index'),
	$model->sa_id,
);

$this->menu=array(
	array('label'=>'List Schoolabout', 'url'=>array('index')),
	array('label'=>'Create Schoolabout', 'url'=>array('create')),
	array('label'=>'Update Schoolabout', 'url'=>array('update', 'id'=>$model->sa_id)),
	array('label'=>'Delete Schoolabout', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->sa_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Schoolabout', 'url'=>array('admin')),
);
?>

<h1>View Schoolabout #<?php echo $model->sa_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'sa_id',
		'sa_label',
		'sa_title',
		'sa_pic',
		'sa_con',
		'sa_click',
		'sa_bool',
		'sa_submitdate',
		'sa_updatetime',
	),
)); ?>
