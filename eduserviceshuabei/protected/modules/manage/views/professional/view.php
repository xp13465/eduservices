<?php
/* @var $this ProfessionalController */
/* @var $model Professional */

$this->breadcrumbs=array(
	'Professionals'=>array('index'),
	$model->p_id,
);

$this->menu=array(
	array('label'=>'List Professional', 'url'=>array('index')),
	array('label'=>'Create Professional', 'url'=>array('create')),
	array('label'=>'Update Professional', 'url'=>array('update', 'id'=>$model->p_id)),
	array('label'=>'Delete Professional', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->p_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Professional', 'url'=>array('admin')),
);
?>

<h1>View Professional #<?php echo $model->p_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'p_id',
		'p_code',
		'p_name',
		'p_pid',
		'p_isdel',
	),
)); ?>
