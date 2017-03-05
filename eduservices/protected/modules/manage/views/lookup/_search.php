<?php
/* @var $this LookupController */
/* @var $model Lookup */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'lu_id'); ?>
		<?php echo $form->textField($model,'lu_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lu_key'); ?>
		<?php echo $form->textField($model,'lu_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lu_value'); ?>
		<?php echo $form->textField($model,'lu_value',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lu_class'); ?>
		<?php echo $form->textField($model,'lu_class',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lu_info'); ?>
		<?php echo $form->textField($model,'lu_info',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lu_code'); ?>
		<?php echo $form->textField($model,'lu_code',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->