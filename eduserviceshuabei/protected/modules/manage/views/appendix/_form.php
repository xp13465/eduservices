<?php
/* @var $this AppendixController */
/* @var $model Appendix */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appendix-form',
	'enableAjaxValidation'=>false,
    "htmlOptions"=>array("enctype"=>"multipart/form-data")
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Appendix::$Status); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ishome'); ?>
		<?php echo $form->dropDownList($model,'ishome',Appendix::$ishome); ?>
		<?php echo $form->error($model,'ishome'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php echo $form->fileField($model,'pic'); ?>
		<?php echo $form->error($model,'pic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fileurl'); ?>
		<?php echo $form->fileField($model,'fileurl'); ?>
		<?php echo $form->error($model,'fileurl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'typeid'); ?>
        <?php echo $form->dropDownList($model,'typeid',Appendix::$type); ?>
		<?php echo $form->error($model,'typeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteinfo'); ?>
		<?php echo $form->textArea($model,'siteinfo',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'siteinfo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->