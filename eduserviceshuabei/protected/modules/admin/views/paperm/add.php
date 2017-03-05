<?php
/* @var $this ExampaperController */
/* @var $model Exampaper */

$this->breadcrumbs=array(
	'试卷管理'=>array('index'),
	'新增试卷',
);

$this->menu=array(
	// array('label'=>'List Exampaper', 'url'=>array('index')),
	// array('label'=>'Manage Exampaper', 'url'=>array('admin')),
);

?>
<div class="bs-docs-example">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#home">基本信息</a></li>
		<li class="hide"><a data-toggle="tab" href="#profile">高级设置</a></li>
		<li class=""><a data-toggle="tab" href="#dropdown">试卷策略</a></li>
	</ul>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
