<?php
/* @var $this ExampaperController */
/* @var $model Exampaper */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'e_id'); ?>
		<?php echo $form->textField($model,'e_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_name'); ?>
		<?php echo $form->textField($model,'e_name',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_cat'); ?>
		<?php echo $form->textField($model,'e_cat',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_display'); ?>
		<?php echo $form->textField($model,'e_display'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_maxenum'); ?>
		<?php echo $form->textField($model,'e_maxenum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_btime'); ?>
		<?php echo $form->textField($model,'e_btime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_etime'); ?>
		<?php echo $form->textField($model,'e_etime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_timecat'); ?>
		<?php echo $form->textField($model,'e_timecat',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_treap'); ?>
		<?php echo $form->textField($model,'e_treap',array('size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_tsecurity'); ?>
		<?php echo $form->textField($model,'e_tsecurity',array('size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_esecurity'); ?>
		<?php echo $form->textField($model,'e_esecurity',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_edescription'); ?>
		<?php echo $form->textField($model,'e_edescription',array('size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_snum'); ?>
		<?php echo $form->textField($model,'e_snum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_scat'); ?>
		<?php echo $form->textField($model,'e_scat'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_rpeople'); ?>
		<?php echo $form->textField($model,'e_rpeople',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_scoreset'); ?>
		<?php echo $form->textArea($model,'e_scoreset',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_pstrategy'); ?>
		<?php echo $form->textArea($model,'e_pstrategy',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_totals'); ?>
		<?php echo $form->textField($model,'e_totals',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_passs'); ?>
		<?php echo $form->textField($model,'e_passs',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_use'); ?>
		<?php echo $form->textField($model,'e_use'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'e_isdel'); ?>
		<?php echo $form->textField($model,'e_isdel'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->