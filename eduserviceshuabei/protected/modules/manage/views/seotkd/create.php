<?php
$this->currentMenu = 82;
$this->breadcrumbs=array(
	'SEO管理'=>array('index'),
	'新建',
);

$this->menu=array(
	array('label'=>'查看所有SEO优化', 'url'=>array('index'))
);
?>

<h1>新建SEO优化</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>