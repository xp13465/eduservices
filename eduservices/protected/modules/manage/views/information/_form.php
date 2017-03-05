<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/kindeditor-4.1.2/kindeditor.js",CClientScript::POS_END ); 

?>
<script type="text/javascript">
$(document).ready(function(){
	KindEditor.ready(function(K) {
	
				var editor = K.create('textarea[id="Information_i_con"]', {
						allowFileManager : false,
						afterBlur: function(){this.sync();}
					});

	});
	})
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'information-form',
	'enableAjaxValidation'=>false,
    "htmlOptions"=>array("enctype"=>"multipart/form-data")
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'i_class'); ?>
        <?php echo $form->dropDownList($model,'i_class',Information::$class); ?>
		<?php echo $form->error($model,'i_class'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'i_label'); ?>
		<?php echo $form->textField($model,'i_label',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'i_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'i_title'); ?>
		<?php echo $form->textField($model,'i_title',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'i_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'i_pic'); ?>
		<?php echo $form->fileField($model,'i_pic'); ?>
		<?php echo $form->error($model,'i_pic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'i_con'); ?>
		<?php echo $form->textArea($model,'i_con',array('style'=>"width:700px;height:700px")); ?>
		<?php echo $form->error($model,'i_con'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'i_click'); ?>
		<?php echo $form->textField($model,'i_click'); ?>
		<?php echo $form->error($model,'i_click'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'i_bool'); ?>
		<?php echo $form->dropDownList($model,'i_bool',Information::$isbool); ?>
		<?php echo $form->error($model,'i_bool'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'i_form'); ?>
		<?php echo $form->textField($model,'i_form',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'i_form'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'i_author'); ?>
		<?php echo $form->textField($model,'i_author',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'i_author'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->