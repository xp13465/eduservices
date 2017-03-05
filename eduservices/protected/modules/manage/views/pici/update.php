<?php
/* @var $this PiciController */
/* @var $model Pici */

$this->breadcrumbs=array(
	'Picis'=>array('index'),
	$model->p_id=>array('view','id'=>$model->p_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pici', 'url'=>array('index')),
	array('label'=>'Create Pici', 'url'=>array('create')),
	array('label'=>'View Pici', 'url'=>array('view', 'id'=>$model->p_id)),
	array('label'=>'Manage Pici', 'url'=>array('admin')),
);
?>

<h1>Update Pici <?php echo $model->p_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>