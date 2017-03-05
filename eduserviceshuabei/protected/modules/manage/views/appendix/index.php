<?php
/* @var $this AppendixController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Appendixes',
);

$this->menu=array(
	array('label'=>'Create Appendix', 'url'=>array('create')),
	array('label'=>'Manage Appendix', 'url'=>array('admin')),
);
?>

<h1>Appendixes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
