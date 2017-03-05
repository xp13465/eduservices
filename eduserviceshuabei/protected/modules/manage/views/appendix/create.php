<?php
/* @var $this AppendixController */
/* @var $model Appendix */

$this->breadcrumbs=array(
	'Appendixes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Appendix', 'url'=>array('index')),
	array('label'=>'Manage Appendix', 'url'=>array('admin')),
);
?>

<h1>Create Appendix</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>