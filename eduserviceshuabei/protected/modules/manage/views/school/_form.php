<?php
/* @var $this SchoolController */
/* @var $model School */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'school-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'s_code'); ?>
		<?php echo $form->textField($model,'s_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'s_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_name'); ?>
		<?php echo $form->textField($model,'s_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'s_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_province'); ?>
		<?php echo $form->textField($model,'s_province'); ?>
		<?php echo $form->error($model,'s_province'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_history'); ?>
		<?php echo $form->textField($model,'s_history',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'s_history'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_pinyinsuoxie'); ?>
		<?php echo $form->textField($model,'s_pinyinsuoxie',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_pinyinsuoxie'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_pinyinlongname'); ?>
		<?php echo $form->textField($model,'s_pinyinlongname',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_pinyinlongname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_isdel'); ?>
		<?php echo $form->textField($model,'s_isdel'); ?>
		<?php echo $form->error($model,'s_isdel'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->