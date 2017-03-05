<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'o_id'); ?>
		<?php echo $form->textField($model,'o_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'o_name'); ?>
		<?php echo $form->textField($model,'o_name',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'o_contacts'); ?>
		<?php echo $form->textField($model,'o_contacts',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'o_tel'); ?>
		<?php echo $form->textField($model,'o_tel',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'o_web'); ?>
		<?php echo $form->textField($model,'o_web',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'o_address'); ?>
		<?php echo $form->textField($model,'o_address',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'o_code'); ?>
		<?php echo $form->textField($model,'o_code',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'o_pid'); ?>
		<?php echo $form->textField($model,'o_pid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->