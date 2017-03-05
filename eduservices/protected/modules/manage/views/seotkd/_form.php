<script src="<?=Yii::app()->request->baseUrl;?>/js/dateinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl;?>/css/dateinput.css"/>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'seotkd-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标注 <span class="required">*</span> 号的为必填项.</p>
    <?php if($model->isNewRecord == '新建'){?>
    <div class="row">
		<?php echo $form->labelEx($model,'stkd_id'); ?>
		<?php echo $form->textField($model,'stkd_id'); ?>
		<?php echo $form->error($model,'stkd_id'); ?>
	</div>
    <?php }?>
    <div class="row">
		<?php echo $form->labelEx($model,'stkd_title'); ?>
		<?php echo $form->textArea($model,'stkd_title',array('rows'=>8, 'cols'=>50)); ?>
		<?php echo $form->error($model,'stkd_title'); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'stkd_keyword'); ?>
		<?php echo $form->textArea($model,'stkd_keyword',array('rows'=>8, 'cols'=>50)); ?>
		<?php echo $form->error($model,'stkd_keyword'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'stkd_dec'); ?>
		<?php echo $form->textArea($model,'stkd_dec',array('rows'=>8, 'cols'=>50)); ?>
		<?php echo $form->error($model,'stkd_dec'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '新建' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
