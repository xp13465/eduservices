<?php
/* @var $this StudentsController */
/* @var $model Students */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'students-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'s_pc'); ?>
		<?php echo $form->textField($model,'s_pc',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'s_pc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_status'); ?>
		<?php echo $form->textField($model,'s_status'); ?>
		<?php echo $form->error($model,'s_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_statusid'); ?>
		<?php echo $form->textField($model,'s_statusid'); ?>
		<?php echo $form->error($model,'s_statusid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_statustime'); ?>
		<?php echo $form->textField($model,'s_statustime'); ?>
		<?php echo $form->error($model,'s_statustime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_statusabout'); ?>
		<?php echo $form->textField($model,'s_statusabout',array('size'=>60,'maxlength'=>600)); ?>
		<?php echo $form->error($model,'s_statusabout'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_userid'); ?>
		<?php echo $form->textField($model,'s_userid'); ?>
		<?php echo $form->error($model,'s_userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_name'); ?>
		<?php echo $form->textField($model,'s_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'s_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_sex'); ?>
		<?php echo $form->textField($model,'s_sex'); ?>
		<?php echo $form->error($model,'s_sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_headerimg'); ?>
		<?php echo $form->textField($model,'s_headerimg',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_headerimg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_credentialstype'); ?>
		<?php echo $form->textField($model,'s_credentialstype'); ?>
		<?php echo $form->error($model,'s_credentialstype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_credentialsnumber'); ?>
		<?php echo $form->textField($model,'s_credentialsnumber',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'s_credentialsnumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_credentialsimg1'); ?>
		<?php echo $form->textField($model,'s_credentialsimg1',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_credentialsimg1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_credentialsimg2'); ?>
		<?php echo $form->textField($model,'s_credentialsimg2',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_credentialsimg2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_birthdate'); ?>
		<?php echo $form->textField($model,'s_birthdate'); ?>
		<?php echo $form->error($model,'s_birthdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_birthaddress'); ?>
		<?php echo $form->textField($model,'s_birthaddress',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_birthaddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_nationality'); ?>
		<?php echo $form->textField($model,'s_nationality'); ?>
		<?php echo $form->error($model,'s_nationality'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_politicalstatus'); ?>
		<?php echo $form->textField($model,'s_politicalstatus'); ?>
		<?php echo $form->error($model,'s_politicalstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_highesteducation'); ?>
		<?php echo $form->textField($model,'s_highesteducation'); ?>
		<?php echo $form->error($model,'s_highesteducation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_phone'); ?>
		<?php echo $form->textField($model,'s_phone',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'s_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_email'); ?>
		<?php echo $form->textField($model,'s_email',array('size'=>60,'maxlength'=>80)); ?>
		<?php echo $form->error($model,'s_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_isdel'); ?>
		<?php echo $form->textField($model,'s_isdel'); ?>
		<?php echo $form->error($model,'s_isdel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_baokaocengci'); ?>
		<?php echo $form->textField($model,'s_baokaocengci'); ?>
		<?php echo $form->error($model,'s_baokaocengci'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_baokaozhuanye'); ?>
		<?php echo $form->textField($model,'s_baokaozhuanye'); ?>
		<?php echo $form->error($model,'s_baokaozhuanye'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_zhiyezhuangkuang'); ?>
		<?php echo $form->textField($model,'s_zhiyezhuangkuang'); ?>
		<?php echo $form->error($model,'s_zhiyezhuangkuang'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_hunyinzhuangkuang'); ?>
		<?php echo $form->textField($model,'s_hunyinzhuangkuang'); ?>
		<?php echo $form->error($model,'s_hunyinzhuangkuang'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_familyaddress'); ?>
		<?php echo $form->textField($model,'s_familyaddress',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'s_familyaddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_gongzuodanwei'); ?>
		<?php echo $form->textField($model,'s_gongzuodanwei',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'s_gongzuodanwei'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_youbian'); ?>
		<?php echo $form->textField($model,'s_youbian',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'s_youbian'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_contactaddress'); ?>
		<?php echo $form->textField($model,'s_contactaddress',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'s_contactaddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_tel'); ?>
		<?php echo $form->textField($model,'s_tel',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'s_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_sfromaddress'); ?>
		<?php echo $form->textField($model,'s_sfromaddress',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'s_sfromaddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_sfromtype'); ?>
		<?php echo $form->textField($model,'s_sfromtype'); ?>
		<?php echo $form->error($model,'s_sfromtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_cjgztime'); ?>
		<?php echo $form->textField($model,'s_cjgztime'); ?>
		<?php echo $form->error($model,'s_cjgztime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_oldschool'); ?>
		<?php echo $form->textField($model,'s_oldschool',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_oldschool'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_oldschoolcode'); ?>
		<?php echo $form->textField($model,'s_oldschoolcode',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'s_oldschoolcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_oldzhuanye'); ?>
		<?php echo $form->textField($model,'s_oldzhuanye',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'s_oldzhuanye'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_oldtime'); ?>
		<?php echo $form->textField($model,'s_oldtime'); ?>
		<?php echo $form->error($model,'s_oldtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_zsbzm'); ?>
		<?php echo $form->textField($model,'s_zsbzm',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_zsbzm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_oldimg'); ?>
		<?php echo $form->textField($model,'s_oldimg',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_oldimg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_oldimgnumber'); ?>
		<?php echo $form->textField($model,'s_oldimgnumber',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'s_oldimgnumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_file'); ?>
		<?php echo $form->textField($model,'s_file',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'s_file'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_beizhu'); ?>
		<?php echo $form->textArea($model,'s_beizhu',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'s_beizhu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_enrollment'); ?>
		<?php echo $form->textField($model,'s_enrollment'); ?>
		<?php echo $form->error($model,'s_enrollment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_study'); ?>
		<?php echo $form->textField($model,'s_study'); ?>
		<?php echo $form->error($model,'s_study'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_addid'); ?>
		<?php echo $form->textField($model,'s_addid'); ?>
		<?php echo $form->error($model,'s_addid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_addtime'); ?>
		<?php echo $form->textField($model,'s_addtime'); ?>
		<?php echo $form->error($model,'s_addtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_editid'); ?>
		<?php echo $form->textField($model,'s_editid'); ?>
		<?php echo $form->error($model,'s_editid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s_edittime'); ?>
		<?php echo $form->textField($model,'s_edittime'); ?>
		<?php echo $form->error($model,'s_edittime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->