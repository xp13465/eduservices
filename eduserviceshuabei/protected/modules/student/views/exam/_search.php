<?php
/* @var $this ExamController */
/* @var $model Score */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'sc_id'); ?>
		<?php echo $form->textField($model,'sc_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_sid'); ?>
		<?php echo $form->textField($model,'sc_sid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_sjid'); ?>
		<?php echo $form->textField($model,'sc_sjid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_thanswer'); ?>
		<?php echo $form->textArea($model,'sc_thanswer',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_kgmark'); ?>
		<?php echo $form->textField($model,'sc_kgmark'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_zgmark'); ?>
		<?php echo $form->textField($model,'sc_zgmark'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_status'); ?>
		<?php echo $form->textField($model,'sc_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_readerid'); ?>
		<?php echo $form->textField($model,'sc_readerid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_remark'); ?>
		<?php echo $form->textArea($model,'sc_remark',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_sdt'); ?>
		<?php echo $form->textField($model,'sc_sdt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_ldt'); ?>
		<?php echo $form->textField($model,'sc_ldt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_source'); ?>
		<?php echo $form->textField($model,'sc_source',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sc_isdel'); ?>
		<?php echo $form->textField($model,'sc_isdel'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->