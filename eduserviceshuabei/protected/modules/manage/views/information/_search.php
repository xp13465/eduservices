<?php
/* @var $this InformationController */
/* @var $model Information */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'i_id'); ?>
		<?php echo $form->textField($model,'i_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_class'); ?>
		<?php echo $form->textField($model,'i_class'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_label'); ?>
		<?php echo $form->textField($model,'i_label',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_title'); ?>
		<?php echo $form->textField($model,'i_title',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_pic'); ?>
		<?php echo $form->textField($model,'i_pic',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_con'); ?>
		<?php echo $form->textArea($model,'i_con',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_click'); ?>
		<?php echo $form->textField($model,'i_click'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_bool'); ?>
		<?php echo $form->textField($model,'i_bool'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_submitdate'); ?>
		<?php echo $form->textField($model,'i_submitdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_updatetime'); ?>
		<?php echo $form->textField($model,'i_updatetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_form'); ?>
		<?php echo $form->textField($model,'i_form',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'i_author'); ?>
		<?php echo $form->textField($model,'i_author',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->