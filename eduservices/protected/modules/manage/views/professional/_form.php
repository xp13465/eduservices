<?php
/* @var $this ProfessionalController */
/* @var $model Professional */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'professional-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'p_code'); ?>
		<?php echo $form->textField($model,'p_code',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'p_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'p_name'); ?>
		<?php echo $form->textField($model,'p_name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'p_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'p_pid'); ?>
		<?php echo $form->textField($model,'p_pid'); ?>
		<?php echo $form->error($model,'p_pid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'p_isdel'); ?>
		<?php echo $form->textField($model,'p_isdel'); ?>
		<?php echo $form->error($model,'p_isdel'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->