<?php
/* @var $this PiciController */
/* @var $model Pici */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pici-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'p_value'); ?>
		<?php echo $form->textField($model,'p_value',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'p_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'p_status'); ?>
		<?php echo $form->textField($model,'p_status'); ?>
		<?php echo $form->error($model,'p_status'); ?>
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