<?php
$this->currentMenu =82;
$this->breadcrumbs=array(
	'SEO优化管理',
    '基本信息管理'
);

$this->menu=array(
	array('label'=>'新建SEO优化', 'url'=>array('create')),
);
?>

<h1>基本信息</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
