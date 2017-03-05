<?php
/* @var $this ExamController */
/* @var $model Score */

$this->breadcrumbs=array(
	'Scores'=>array('index'),
	$model->sc_id,
);

$this->menu=array(
	array('label'=>'List Score', 'url'=>array('index')),
	array('label'=>'Create Score', 'url'=>array('create')),
	array('label'=>'Update Score', 'url'=>array('update', 'id'=>$model->sc_id)),
	array('label'=>'Delete Score', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->sc_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Score', 'url'=>array('admin')),
);
?>

<h1>View Score #<?php echo $model->sc_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'sc_id',
		'sc_sid',
		'sc_sjid',
		'sc_thanswer',
		'sc_kgmark',
		'sc_zgmark',
		'sc_status',
		'sc_readerid',
		'sc_remark',
		'sc_sdt',
		'sc_ldt',
		'sc_source',
		'sc_isdel',
	),
)); ?>
