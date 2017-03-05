<?php
/* @var $this LookupController */
/* @var $model Lookup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lookup-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lu_key'); ?>
		<?php echo $form->textField($model,'lu_key'); ?>
		<?php echo $form->error($model,'lu_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lu_value'); ?>
		<?php echo $form->textField($model,'lu_value',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'lu_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lu_class'); ?>
		<?php echo $form->textField($model,'lu_class',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'lu_class'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lu_info'); ?>
		<?php echo $form->textField($model,'lu_info',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'lu_info'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lu_code'); ?>
		<?php echo $form->textField($model,'lu_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'lu_code'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->