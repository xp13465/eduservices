<?php
/* @var $this TopicController */
/* @var $model Topic */

$this->breadcrumbs=array(
	'Topics'=>array('index'),
	$model->t_id=>array('view','id'=>$model->t_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Topic', 'url'=>array('index')),
	array('label'=>'Create Topic', 'url'=>array('create')),
	array('label'=>'View Topic', 'url'=>array('view', 'id'=>$model->t_id)),
	array('label'=>'Manage Topic', 'url'=>array('admin')),
);
?>

<h1>Update Topic <?php echo $model->t_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>