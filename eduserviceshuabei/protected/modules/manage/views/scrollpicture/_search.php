<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'sp_id'); ?>
		<?php echo $form->textField($model,'sp_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sp_title'); ?>
		<?php echo $form->textField($model,'sp_title',array('size'=>60,'maxlength'=>200)); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'sp_link'); ?>
		<?php echo $form->textField($model,'sp_link',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sp_order'); ?>
		<?php echo $form->textField($model,'sp_order'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->