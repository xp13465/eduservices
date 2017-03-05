<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'managemenu-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'m_name'); ?>
		<?php echo $form->textField($model,'m_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'m_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'m_link'); ?>
		<?php echo $form->textField($model,'m_link',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'m_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'m_parentid'); ?>
		<?php echo $form->textField($model,'m_parentid'); ?>
		<?php echo $form->error($model,'m_parentid');
        /* if($model->isNewRecord){?>
        <input type="checkbox" name="auto_to_authitem" id="authitem" /><label for="authitem" style="display: inline">自动添加到权限认证操作项</label>
        <?php } */?>
	</div>
    <div class="row">
        <?php  
        $manage=array();
        $Manages=User::model()->findAll("user_role =4 and user_status='1' and user_isdel='1'");
		foreach($Manages as $val)$manage[$val->user_id]=$val->user_name;
        
        ?>
		<?php echo $form->labelEx($model,'m_role'); ?>
        <?php echo $form->checkBoxList($model,'m_role',$manage,array('separator'=>'&nbsp;','template'=>'{input} {label}')); ?>
	
		<?php echo $form->error($model,'m_role');?>
        
	</div>
    <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->