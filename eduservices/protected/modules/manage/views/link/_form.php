<?php
/* @var $this LinkController */
/* @var $model Link */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'link-form',
	'enableAjaxValidation'=>false,
    "htmlOptions"=>array("enctype"=>"multipart/form-data")
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Link::$Status); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'listorder'); ?>
		<?php echo $form->textField($model,'listorder',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'listorder'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'logo'); ?>
		<?php echo $form->fileField($model,'logo'); ?>
		<?php echo $form->error($model,'logo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'siteurl'); ?>
		<?php echo $form->textField($model,'siteurl',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'siteurl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'typeid'); ?>
        <?php echo $form->dropDownList($model,'typeid',Link::$type); ?>
		<?php echo $form->error($model,'typeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'linktype'); ?>
        <?php echo $form->dropDownList($model,'linktype',Link::$linktype); ?>
		<?php echo $form->error($model,'linktype'); ?>
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