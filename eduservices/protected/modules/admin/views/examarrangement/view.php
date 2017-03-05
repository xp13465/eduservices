<?php
/* @var $this ExamarrangementController */
/* @var $model Examarrangement */

$this->breadcrumbs=array(
	'Examarrangements'=>array('index'),
	$model->ea_id,
);

$this->menu=array(
	array('label'=>'List Examarrangement', 'url'=>array('index')),
	array('label'=>'Create Examarrangement', 'url'=>array('create')),
	array('label'=>'Update Examarrangement', 'url'=>array('update', 'id'=>$model->ea_id)),
	array('label'=>'Delete Examarrangement', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ea_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Examarrangement', 'url'=>array('admin')),
);
?>

<h1>View Examarrangement #<?php echo $model->ea_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ea_id',
		'ea_pkid',
		'ea_examid',
		'ea_stime',
		'ea_etime',
		'ea_status',
	),
)); ?>
