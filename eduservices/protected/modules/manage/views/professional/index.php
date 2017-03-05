<?php
/* @var $this ProfessionalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Professionals',
);

$this->menu=array(
	array('label'=>'Create Professional', 'url'=>array('create')),
	array('label'=>'Manage Professional', 'url'=>array('admin')),
);
?>

<h1>Professionals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
