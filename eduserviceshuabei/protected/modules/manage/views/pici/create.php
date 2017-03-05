<?php
/* @var $this PiciController */
/* @var $model Pici */

$this->breadcrumbs=array(
	'Picis'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pici', 'url'=>array('index')),
	array('label'=>'Manage Pici', 'url'=>array('admin')),
);
?>

<h1>Create Pici</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>