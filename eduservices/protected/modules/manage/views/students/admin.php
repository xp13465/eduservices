<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->breadcrumbs=array(
	'Students'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Students', 'url'=>array('index')),
	array('label'=>'Create Students', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#students-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Students</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'students-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		's_id',
		's_pc',
		's_status',
		's_statusid',
		's_statustime',
		's_statusabout',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
