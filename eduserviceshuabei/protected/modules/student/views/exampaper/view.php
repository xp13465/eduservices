<?php
/* @var $this ExampaperController */
/* @var $model Exampaper */

$this->breadcrumbs=array(
	'Exampapers'=>array('index'),
	$model->e_id,
);

$this->menu=array(
	array('label'=>'List Exampaper', 'url'=>array('index')),
	array('label'=>'Create Exampaper', 'url'=>array('create')),
	array('label'=>'Update Exampaper', 'url'=>array('update', 'id'=>$model->e_id)),
	array('label'=>'Delete Exampaper', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->e_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Exampaper', 'url'=>array('admin')),
);
?>

<h1>View Exampaper #<?php echo $model->e_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'e_id',
		'e_name',
		'e_cat',
		'e_display',
		'e_maxenum',
		'e_btime',
		'e_etime',
		'e_timecat',
		'e_treap',
		'e_tsecurity',
		'e_esecurity',
		'e_edescription',
		'e_snum',
		'e_scat',
		'e_rpeople',
		'e_scoreset',
		'e_pstrategy',
		'e_totals',
		'e_passs',
		'e_use',
		'e_isdel',
	),
)); ?>
