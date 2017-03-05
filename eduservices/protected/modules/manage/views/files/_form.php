<?php
/* @var $this FilesController */
/* @var $model Files */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'files-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'f_uid'); ?>
		<?php echo $form->textField($model,'f_uid'); ?>
		<?php echo $form->error($model,'f_uid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'f_url'); ?>
		<?php echo $form->textField($model,'f_url',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'f_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'f_type'); ?>
		<?php echo $form->textField($model,'f_type'); ?>
		<?php echo $form->error($model,'f_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->