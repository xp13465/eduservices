<?php
/* @var $this PiciController */
/* @var $model Pici */

$this->breadcrumbs=array(
	'Picis'=>array('index'),
	$model->p_id,
);

$this->menu=array(
	array('label'=>'List Pici', 'url'=>array('index')),
	array('label'=>'Create Pici', 'url'=>array('create')),
	array('label'=>'Update Pici', 'url'=>array('update', 'id'=>$model->p_id)),
	array('label'=>'Delete Pici', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->p_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pici', 'url'=>array('admin')),
);
?>

<h1>View Pici #<?php echo $model->p_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'p_id',
		'p_value',
		'p_status',
		'p_isdel',
	),
)); ?>
