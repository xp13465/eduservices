<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>View User #<?php echo $model->user_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'user_name',
		'user_nkname',
		'user_headimg',
		'user_email',
		'user_webset',
		'user_tel',
		'user_tel2',
		'user_phone',
		'user_msn',
		'user_adderss',
		'user_qq',
		'user_pwd',
		'user_role',
		'user_regtime',
		'user_loginnum',
		'user_lasttime',
		'user_lastip',
		'user_online',
		'user_status',
		'user_organization',
		'user_isdel',
		'user_authorize',
	),
)); ?>
