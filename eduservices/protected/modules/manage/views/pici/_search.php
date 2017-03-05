<?php
/* @var $this PiciController */
/* @var $model Pici */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'p_id'); ?>
		<?php echo $form->textField($model,'p_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_value'); ?>
		<?php echo $form->textField($model,'p_value',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_status'); ?>
		<?php echo $form->textField($model,'p_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_isdel'); ?>
		<?php echo $form->textField($model,'p_isdel'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->