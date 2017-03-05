<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_nkname'); ?>
		<?php echo $form->textField($model,'user_nkname',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_headimg'); ?>
		<?php echo $form->textField($model,'user_headimg',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_webset'); ?>
		<?php echo $form->textField($model,'user_webset',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_tel'); ?>
		<?php echo $form->textField($model,'user_tel',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_tel2'); ?>
		<?php echo $form->textField($model,'user_tel2',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_phone'); ?>
		<?php echo $form->textField($model,'user_phone',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_msn'); ?>
		<?php echo $form->textField($model,'user_msn',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_adderss'); ?>
		<?php echo $form->textField($model,'user_adderss',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_qq'); ?>
		<?php echo $form->textField($model,'user_qq',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_pwd'); ?>
		<?php echo $form->textField($model,'user_pwd',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_role'); ?>
		<?php echo $form->textField($model,'user_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_regtime'); ?>
		<?php echo $form->textField($model,'user_regtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_loginnum'); ?>
		<?php echo $form->textField($model,'user_loginnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_lasttime'); ?>
		<?php echo $form->textField($model,'user_lasttime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_lastip'); ?>
		<?php echo $form->textField($model,'user_lastip',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_online'); ?>
		<?php echo $form->textField($model,'user_online'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_status'); ?>
		<?php echo $form->textField($model,'user_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_organization'); ?>
		<?php echo $form->textField($model,'user_organization'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_isdel'); ?>
		<?php echo $form->textField($model,'user_isdel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_authorize'); ?>
		<?php echo $form->textField($model,'user_authorize',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->