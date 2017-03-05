<?php
/* @var $this ExampaperController */
/* @var $model Exampaper */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'exampaper-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'e_name'); ?>
		<?php echo $form->textField($model,'e_name',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'e_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_cat'); ?>
		<?php echo $form->textField($model,'e_cat',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'e_cat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_display'); ?>
		<?php echo $form->textField($model,'e_display'); ?>
		<?php echo $form->error($model,'e_display'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_maxenum'); ?>
		<?php echo $form->textField($model,'e_maxenum'); ?>
		<?php echo $form->error($model,'e_maxenum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_btime'); ?>
		<?php echo $form->textField($model,'e_btime'); ?>
		<?php echo $form->error($model,'e_btime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_etime'); ?>
		<?php echo $form->textField($model,'e_etime'); ?>
		<?php echo $form->error($model,'e_etime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_timecat'); ?>
		<?php echo $form->textField($model,'e_timecat',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'e_timecat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_treap'); ?>
		<?php echo $form->textField($model,'e_treap',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'e_treap'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_tsecurity'); ?>
		<?php echo $form->textField($model,'e_tsecurity',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'e_tsecurity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_esecurity'); ?>
		<?php echo $form->textField($model,'e_esecurity',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'e_esecurity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_edescription'); ?>
		<?php echo $form->textField($model,'e_edescription',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'e_edescription'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_snum'); ?>
		<?php echo $form->textField($model,'e_snum'); ?>
		<?php echo $form->error($model,'e_snum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_scat'); ?>
		<?php echo $form->textField($model,'e_scat'); ?>
		<?php echo $form->error($model,'e_scat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_rpeople'); ?>
		<?php echo $form->textField($model,'e_rpeople',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'e_rpeople'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_scoreset'); ?>
		<?php echo $form->textArea($model,'e_scoreset',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'e_scoreset'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_pstrategy'); ?>
		<?php echo $form->textArea($model,'e_pstrategy',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'e_pstrategy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_totals'); ?>
		<?php echo $form->textField($model,'e_totals',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'e_totals'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_passs'); ?>
		<?php echo $form->textField($model,'e_passs',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'e_passs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_use'); ?>
		<?php echo $form->textField($model,'e_use'); ?>
		<?php echo $form->error($model,'e_use'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'e_isdel'); ?>
		<?php echo $form->textField($model,'e_isdel'); ?>
		<?php echo $form->error($model,'e_isdel'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->