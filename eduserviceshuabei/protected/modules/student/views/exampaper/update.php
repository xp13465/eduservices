<?php
/* @var $this ExampaperController */
/* @var $model Exampaper */

$this->breadcrumbs=array(
	'Exampapers'=>array('index'),
	$model->e_id=>array('view','id'=>$model->e_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Exampaper', 'url'=>array('index')),
	array('label'=>'Create Exampaper', 'url'=>array('create')),
	array('label'=>'View Exampaper', 'url'=>array('view', 'id'=>$model->e_id)),
	array('label'=>'Manage Exampaper', 'url'=>array('admin')),
);
?>

<h1>Update Exampaper <?php echo $model->e_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>