<?php
/* @var $this TopicController */
/* @var $model Topic */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'topic-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'t_qid'); ?>
		<?php echo $form->textField($model,'t_qid'); ?>
		<?php echo $form->error($model,'t_qid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_know'); ?>
		<?php echo $form->textField($model,'t_know',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'t_know'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_level'); ?>
		<?php echo $form->textField($model,'t_level'); ?>
		<?php echo $form->error($model,'t_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_score'); ?>
		<?php echo $form->textField($model,'t_score'); ?>
		<?php echo $form->error($model,'t_score'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_type'); ?>
		<?php echo $form->textField($model,'t_type'); ?>
		<?php echo $form->error($model,'t_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_validity'); ?>
		<?php echo $form->textField($model,'t_validity'); ?>
		<?php echo $form->error($model,'t_validity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_con'); ?>
		<?php echo $form->textArea($model,'t_con',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'t_con'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_daxx'); ?>
		<?php echo $form->textArea($model,'t_daxx',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'t_daxx'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_answer'); ?>
		<?php echo $form->textField($model,'t_answer',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'t_answer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'t_leaflet'); ?>
		<?php echo $form->textField($model,'t_leaflet',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'t_leaflet'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->