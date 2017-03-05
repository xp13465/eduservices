<?php
/* @var $this ExamController */
/* @var $model Score */

// $this->breadcrumbs=array(
	// 'Scores'=>array('index'),
	// $model->sc_id=>array('view','id'=>$model->sc_id),
	// 'Update',
// );

// $this->menu=array(
	// array('label'=>'List Score', 'url'=>array('index')),
	// array('label'=>'Create Score', 'url'=>array('create')),
	// array('label'=>'View Score', 'url'=>array('view', 'id'=>$model->sc_id)),
	// array('label'=>'Manage Score', 'url'=>array('admin')),
// );
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'scoremodel'=>$scoremodel,)); ?>