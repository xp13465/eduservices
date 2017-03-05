<?php
/* @var $this FilesController */
/* @var $model Files */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'f_id'); ?>
		<?php echo $form->textField($model,'f_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'f_uid'); ?>
		<?php echo $form->textField($model,'f_uid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'f_url'); ?>
		<?php echo $form->textField($model,'f_url',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'f_type'); ?>
		<?php echo $form->textField($model,'f_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->