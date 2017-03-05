<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'scrollpicture-form',
	'enableAjaxValidation'=>false,
    "htmlOptions"=>array("enctype"=>"multipart/form-data")
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'sp_title'); ?>
		<?php echo $form->textField($model,'sp_title',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'sp_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sp_picture'); ?>
		<?php echo $form->fileField($model,'sp_picture'); ?>大小：585px*185px
		<?php echo $form->error($model,'sp_picture'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sp_link'); ?>
		<?php echo $form->textField($model,'sp_link',array('size'=>60,'maxlength'=>200)); ?>请包涵http://
		<?php echo $form->error($model,'sp_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sp_order'); ?>
		<?php echo $form->textField($model,'sp_order'); ?>1-99 数字越小，显示越靠前
		<?php echo $form->error($model,'sp_order'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'sp_type'); ?>
		<?php echo $form->dropDownList($model,'sp_type',Scrollpicture::$sp_type); ?>
		<?php echo $form->error($model,'sp_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->