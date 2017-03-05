<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organization-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'o_name'); ?>
		<?php echo $form->textField($model,'o_name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'o_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'o_contacts'); ?>
		<?php echo $form->textField($model,'o_contacts',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'o_contacts'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'o_tel'); ?>
		<?php echo $form->textField($model,'o_tel',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'o_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'o_web'); ?>
		<?php echo $form->textField($model,'o_web',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'o_web'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'o_address'); ?>
		<?php echo $form->textField($model,'o_address',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'o_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'o_code'); ?>
		<?php echo $form->textField($model,'o_code',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'o_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'o_pid'); ?>
		<?php echo $form->textField($model,'o_pid'); ?>
		<?php echo $form->error($model,'o_pid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'o_isdel'); ?>
		<?php echo $form->textField($model,'o_isdel'); ?>
		<?php echo $form->error($model,'o_isdel'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->