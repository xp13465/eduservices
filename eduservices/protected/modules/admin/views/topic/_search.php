<?php
/* @var $this TopicController */
/* @var $model Topic */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'t_id'); ?>
		<?php echo $form->textField($model,'t_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_qid'); ?>
		<?php echo $form->textField($model,'t_qid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_know'); ?>
		<?php echo $form->textField($model,'t_know',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_level'); ?>
		<?php echo $form->textField($model,'t_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_score'); ?>
		<?php echo $form->textField($model,'t_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_type'); ?>
		<?php echo $form->textField($model,'t_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_validity'); ?>
		<?php echo $form->textField($model,'t_validity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_con'); ?>
		<?php echo $form->textArea($model,'t_con',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_daxx'); ?>
		<?php echo $form->textArea($model,'t_daxx',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_answer'); ?>
		<?php echo $form->textField($model,'t_answer',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'t_leaflet'); ?>
		<?php echo $form->textField($model,'t_leaflet',array('size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->