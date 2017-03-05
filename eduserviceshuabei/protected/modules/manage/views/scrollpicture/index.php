<?php
$this->breadcrumbs=array(
	'Scrollpictures',
);

$this->menu=array(
	array('label'=>'新建', 'url'=>array('create')),
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>Scrollpictures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
