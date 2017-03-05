<?php
/* @var $this ExamController */
/* @var $model Score */

// $this->breadcrumbs=array(
	// 'Scores'=>array('index'),
	// 'Create',
// );

// $this->menu=array(
	// array('label'=>'List Score', 'url'=>array('index')),
	// array('label'=>'Manage Score', 'url'=>array('admin')),
// );
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'sjmodel'=>$sjmodel,'scoremodel'=>$scoremodel)); ?>