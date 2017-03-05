<?php
/* @var $this StudentsController */
/* @var $model Students */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'s_id'); ?>
		<?php echo $form->textField($model,'s_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_userid'); ?>
		<?php echo $form->textField($model,'s_userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_name'); ?>
		<?php echo $form->textField($model,'s_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_sex'); ?>
		<?php echo $form->textField($model,'s_sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_headerimg'); ?>
		<?php echo $form->textField($model,'s_headerimg',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_credentialstype'); ?>
		<?php echo $form->textField($model,'s_credentialstype'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_credentialsnumber'); ?>
		<?php echo $form->textField($model,'s_credentialsnumber',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_credentialsimg1'); ?>
		<?php echo $form->textField($model,'s_credentialsimg1',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_credentialsimg2'); ?>
		<?php echo $form->textField($model,'s_credentialsimg2',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_birthdate'); ?>
		<?php echo $form->textField($model,'s_birthdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_birthaddress'); ?>
		<?php echo $form->textField($model,'s_birthaddress',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_nationality'); ?>
		<?php echo $form->textField($model,'s_nationality'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_politicalstatus'); ?>
		<?php echo $form->textField($model,'s_politicalstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_highesteducation'); ?>
		<?php echo $form->textField($model,'s_highesteducation'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_baokaocengci'); ?>
		<?php echo $form->textField($model,'s_baokaocengci'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_baokaozhuanye'); ?>
		<?php echo $form->textField($model,'s_baokaozhuanye'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_zhiyezhuangkuang'); ?>
		<?php echo $form->textField($model,'s_zhiyezhuangkuang'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_hunyinzhuangkuang'); ?>
		<?php echo $form->textField($model,'s_hunyinzhuangkuang'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_familyaddress'); ?>
		<?php echo $form->textField($model,'s_familyaddress',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_gongzuodanwei'); ?>
		<?php echo $form->textField($model,'s_gongzuodanwei',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_youbian'); ?>
		<?php echo $form->textField($model,'s_youbian',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_contactaddress'); ?>
		<?php echo $form->textField($model,'s_contactaddress',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_tel'); ?>
		<?php echo $form->textField($model,'s_tel',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_sfromaddress'); ?>
		<?php echo $form->textField($model,'s_sfromaddress',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_sfromtype'); ?>
		<?php echo $form->textField($model,'s_sfromtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_cjgztime'); ?>
		<?php echo $form->textField($model,'s_cjgztime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_oldschool'); ?>
		<?php echo $form->textField($model,'s_oldschool',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_oldzhuanye'); ?>
		<?php echo $form->textField($model,'s_oldzhuanye',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_oldtime'); ?>
		<?php echo $form->textField($model,'s_oldtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_oldimg'); ?>
		<?php echo $form->textField($model,'s_oldimg',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_file'); ?>
		<?php echo $form->textField($model,'s_file',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s_beizhu'); ?>
		<?php echo $form->textArea($model,'s_beizhu',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->