<?php
/* @var $this PiciController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Picis',
);

$this->menu=array(
	array('label'=>'Create Pici', 'url'=>array('create')),
	array('label'=>'Manage Pici', 'url'=>array('admin')),
);
?>

<h1>Picis</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
