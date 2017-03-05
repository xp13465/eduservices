<?php
/* @var $this SchoolaboutController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Schoolabouts',
);

$this->menu=array(
	array('label'=>'Create Schoolabout', 'url'=>array('create')),
	array('label'=>'Manage Schoolabout', 'url'=>array('admin')),
);
?>

<h1>Schoolabouts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
