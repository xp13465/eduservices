<?php
/* @var $this ExampaperController */
/* @var $model Exampaper */

$this->breadcrumbs=array(
	'Exampapers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Exampaper', 'url'=>array('index')),
	array('label'=>'Manage Exampaper', 'url'=>array('admin')),
);
?>

<h1>Create Exampaper</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>