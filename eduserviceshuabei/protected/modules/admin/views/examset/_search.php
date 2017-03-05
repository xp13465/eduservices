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
		<?php echo $form->label($model,'q_id'); ?>
		<?php echo $form->textField($model,'q_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'q_name'); ?>
		<?php echo $form->textField($model,'q_name',array('size'=>60,'maxlength'=>200)); ?>
	</div>
    
	<div class="row">
		<?php echo $form->label($model,'q_pid'); ?>
		<?php echo $form->textField($model,'q_pid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->