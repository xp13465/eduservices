<?php
/* @var $this ProfessionalController */
/* @var $model Professional */

$this->breadcrumbs=array(
	'Professionals'=>array('index'),
	$model->p_id=>array('view','id'=>$model->p_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Professional', 'url'=>array('index')),
	array('label'=>'Create Professional', 'url'=>array('create')),
	array('label'=>'View Professional', 'url'=>array('view', 'id'=>$model->p_id)),
	array('label'=>'Manage Professional', 'url'=>array('admin')),
);
?>

<h1>Update Professional <?php echo $model->p_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>