<?php
/* @var $this SchoolaboutController */
/* @var $model Schoolabout */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'sa_id'); ?>
		<?php echo $form->textField($model,'sa_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sa_label'); ?>
		<?php echo $form->textField($model,'sa_label',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sa_title'); ?>
		<?php echo $form->textField($model,'sa_title',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sa_pic'); ?>
		<?php echo $form->textField($model,'sa_pic',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sa_con'); ?>
		<?php echo $form->textArea($model,'sa_con',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sa_click'); ?>
		<?php echo $form->textField($model,'sa_click'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sa_bool'); ?>
		<?php echo $form->textField($model,'sa_bool'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sa_submitdate'); ?>
		<?php echo $form->textField($model,'sa_submitdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sa_updatetime'); ?>
		<?php echo $form->textField($model,'sa_updatetime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->