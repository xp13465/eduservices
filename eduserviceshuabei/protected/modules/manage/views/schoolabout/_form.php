<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/kindeditor-4.1.2/kindeditor.js",CClientScript::POS_END ); 

?>
<script type="text/javascript">
$(document).ready(function(){
	KindEditor.ready(function(K) {
	
				var editor = K.create('textarea[id="Schoolabout_sa_con"]', {
						allowFileManager : false,
						afterBlur: function(){this.sync();}
					});

	});
	})
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'Schoolabout-form',
	'enableAjaxValidation'=>false,
    "htmlOptions"=>array("enctype"=>"multipart/form-data")
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'sa_label'); ?>
		<?php echo $form->textField($model,'sa_label',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sa_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sa_title'); ?>
		<?php echo $form->textField($model,'sa_title',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'sa_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sa_pic'); ?>
		<?php echo $form->fileField($model,'sa_pic'); ?>
		<?php echo $form->error($model,'sa_pic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sa_con'); ?>
		<?php echo $form->textArea($model,'sa_con',array('style'=>"width:700px;height:700px")); ?>
		<?php echo $form->error($model,'sa_con'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sa_click'); ?>
		<?php echo $form->textField($model,'sa_click'); ?>
		<?php echo $form->error($model,'sa_click'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sa_bool'); ?>
		<?php echo $form->dropDownList($model,'sa_bool',Schoolabout::$isbool); ?>
		<?php echo $form->error($model,'sa_bool'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->