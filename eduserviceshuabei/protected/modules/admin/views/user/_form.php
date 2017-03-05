<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note"><span class="required">*</span>号是必填项</p>
<table class='table1'>
	<?php // echo $form->errorSummary($model); ?>
<tr>
	<td class="row"><?php echo $form->labelEx($model,'user_name'); ?></td>
	<td><?php echo $form->textField($model,'user_name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $form->labelEx($model,'user_nkname'); ?></td>
	<td><?php echo $form->textField($model,'user_nkname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_nkname'); ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $form->labelEx($model,'user_email'); ?></td>
	<td><?php echo $form->textField($model,'user_email',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'user_email'); ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $form->labelEx($model,'user_tel'); ?></td>
	<td><?php echo $form->textField($model,'user_tel',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_tel'); ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $model->isNewRecord?$form->labelEx($model,'user_pwd'):"密码"; ?></td>
	<td><input size="50" maxlength="50" name="User[user_pwd]" id="User_user_pwd" type="text" value="">
		<?=$model->isNewRecord?"":"不填则不修改密码"?>
		<?php echo $form->error($model,'user_pwd'); ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $form->labelEx($model,'user_role'); ?></td>
	<td><?php echo $form->dropDownList($model,'user_role',User::$RoleName); ?>
		<?php echo $form->error($model,'user_role'); ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $form->labelEx($model,'user_status'); ?></td>
	<td><?php echo $form->dropDownList($model,'user_status',User::$Status); ?>
		<?php echo $form->error($model,'user_status'); ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $form->labelEx($model,'user_corporation'); ?></td>
	<td><?php echo $form->textField($model,'user_corporation'); ?>
		<?php echo $form->error($model,'user_corporation'); ?>
	</td>
</tr>
<tr>
	<td class="row buttons"></td>
	<td><?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存'); ?>
	</td>
</tr>
</table>
<?php $this->endWidget(); ?>
</div><!-- form -->