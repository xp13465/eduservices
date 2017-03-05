<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_nkname'); ?>
		<?php echo $form->textField($model,'user_nkname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_nkname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_headimg'); ?>
		<?php echo $form->textField($model,'user_headimg',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_headimg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'user_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_webset'); ?>
		<?php echo $form->textField($model,'user_webset',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_webset'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_tel'); ?>
		<?php echo $form->textField($model,'user_tel',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_tel2'); ?>
		<?php echo $form->textField($model,'user_tel2',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_tel2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_phone'); ?>
		<?php echo $form->textField($model,'user_phone',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_msn'); ?>
		<?php echo $form->textField($model,'user_msn',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_msn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_adderss'); ?>
		<?php echo $form->textField($model,'user_adderss',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_adderss'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_qq'); ?>
		<?php echo $form->textField($model,'user_qq',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_qq'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_pwd'); ?>
		<?php echo $form->textField($model,'user_pwd',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_pwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_role'); ?>
		<?php echo $form->textField($model,'user_role'); ?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_regtime'); ?>
		<?php echo $form->textField($model,'user_regtime'); ?>
		<?php echo $form->error($model,'user_regtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_loginnum'); ?>
		<?php echo $form->textField($model,'user_loginnum'); ?>
		<?php echo $form->error($model,'user_loginnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_lasttime'); ?>
		<?php echo $form->textField($model,'user_lasttime'); ?>
		<?php echo $form->error($model,'user_lasttime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_lastip'); ?>
		<?php echo $form->textField($model,'user_lastip',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_lastip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_online'); ?>
		<?php echo $form->textField($model,'user_online'); ?>
		<?php echo $form->error($model,'user_online'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_status'); ?>
		<?php echo $form->textField($model,'user_status'); ?>
		<?php echo $form->error($model,'user_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_organization'); ?>
		<?php echo $form->textField($model,'user_organization'); ?>
		<?php echo $form->error($model,'user_organization'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_isdel'); ?>
		<?php echo $form->textField($model,'user_isdel'); ?>
		<?php echo $form->error($model,'user_isdel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_authorize'); ?>
		<?php echo $form->textField($model,'user_authorize',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'user_authorize'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->