<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->breadcrumbs=array(
	'Students'=>array('index'),
	$model->s_id,
);

$this->menu=array(
	array('label'=>'List Students', 'url'=>array('index')),
	array('label'=>'Create Students', 'url'=>array('create')),
	array('label'=>'Update Students', 'url'=>array('update', 'id'=>$model->s_id)),
	array('label'=>'Delete Students', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->s_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Students', 'url'=>array('admin')),
);
?>

<h1>View Students #<?php echo $model->s_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		's_id',
		's_pc',
		's_status',
		's_statusid',
		's_statustime',
		's_statusabout',
		's_userid',
		's_name',
		's_sex',
		's_headerimg',
		's_credentialstype',
		's_credentialsnumber',
		's_credentialsimg1',
		's_credentialsimg2',
		's_birthdate',
		's_birthaddress',
		's_nationality',
		's_politicalstatus',
		's_highesteducation',
		's_phone',
		's_email',
		's_isdel',
		's_baokaocengci',
		's_baokaozhuanye',
		's_zhiyezhuangkuang',
		's_hunyinzhuangkuang',
		's_familyaddress',
		's_gongzuodanwei',
		's_youbian',
		's_contactaddress',
		's_tel',
		's_sfromaddress',
		's_sfromtype',
		's_cjgztime',
		's_oldschool',
		's_oldschoolcode',
		's_oldzhuanye',
		's_oldtime',
		's_zsbzm',
		's_oldimg',
		's_oldimgnumber',
		's_file',
		's_beizhu',
		's_enrollment',
		's_study',
		's_addid',
		's_addtime',
		's_editid',
		's_edittime',
	),
)); ?>
