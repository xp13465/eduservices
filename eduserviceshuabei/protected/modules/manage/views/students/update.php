<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->breadcrumbs=array(
	'Students'=>array('index'),
	$model->s_id=>array('view','id'=>$model->s_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Students', 'url'=>array('index')),
	array('label'=>'Create Students', 'url'=>array('create')),
	array('label'=>'View Students', 'url'=>array('view', 'id'=>$model->s_id)),
	array('label'=>'Manage Students', 'url'=>array('admin')),
);
?>

<h1>Update Students <?php echo $model->s_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>