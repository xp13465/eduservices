<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
?>


  <div class="modal-header">
  
    <h3>院校管理-编辑</h3>
  </div>
  <div class="modal-body" style='max-height:600px;'>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'school-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div>
	 <div class="control-group">
        <label class="control-label" for=""><b>院校名称</b></label>
        <div class="controls">
          <div class="input-append">
			<?php echo $form->textField($model,'s_name',array('name'=>"s_name",'class'=>'width270')); ?>	
          </div>
		  <span for="s_name" class="error" style=""><?=isset($model->errors['s_name'])?join('',$model->errors['s_name']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>院校代码</b></label>
        <div class="controls">
			<div class="input-append">
			<?php echo $form->textField($model,'s_code',array('name'=>"s_code",'class'=>'width270')); ?>	
			</div>
			<span for="s_code" class="error" style=""><?=isset($model->errors['s_code'])?join('',$model->errors['s_code']):""?></span>
			<span class="help-inline" id="Tuser_error"></span>
        </div>
      </div>
      <div class="control-group">
      <label class="control-label" for=""><b>院校省份</b></label>
      <div class="controls">
        <div class="input-append">
          <?php   echo CHtml::activeDropDownList($model, 's_province',Province::model()->getAllP(), array(
					'empty'=>'请选择所属省份',
					"name"=>"s_province",
					'class'=>"pull-left"
			  )); ?>	
          </div>
		   <span for="s_province" class="error" style=""><?=isset($model->errors['s_province'])?join('',$model->errors['s_province']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>院校沿革历史</b></label>
        <div class="controls">
          <div class="input-append">
			<?php echo $form->textField($model,'s_history',array('name'=>"s_history",'class'=>'width270')); ?>	
          </div>
		  <span for="s_history" class="error" style=""><?=isset($model->errors['s_history'])?join('',$model->errors['s_history']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>院校拼音简写</b></label>
        <div class="controls">
			<div class="input-append">
			<?php echo $form->textField($model,'s_pinyinsuoxie',array('name'=>"s_pinyinsuoxie",'class'=>'width270')); ?>	
			</div>
			<span for="s_pinyinsuoxie" class="error" style=""><?=isset($model->errors['s_pinyinsuoxie'])?join('',$model->errors['s_pinyinsuoxie']):""?></span>
			<span class="help-inline" id="Tuser_error"></span>
        </div>
      </div>
	   <div class="control-group">
        <label class="control-label" for=""><b>院校拼音全写</b></label>
        <div class="controls">
			<div class="input-append">
			<?php echo $form->textField($model,'s_pinyinlongname',array('name'=>"s_pinyinlongname",'class'=>'width270')); ?>	
			</div>
			<span for="s_pinyinlongname" class="error" style=""><?=isset($model->errors['s_pinyinlongname'])?join('',$model->errors['s_pinyinlongname']):""?></span>
			<span class="help-inline" id="Tuser_error"></span>
        </div>
      </div>
    </div>
	</div>
  <div class="form-actions">
	<button type="submit" class="btn btn-primary"  name="addsubmit" value="add">确认修改</button>&nbsp;
	<a href="<?=isset($_COOKIE['organreturnurl'])?$_COOKIE['organreturnurl']:""?>" class="btn" closeTime">返回</a>
	</div>

<?php $this->endWidget(); ?>
<script>
$(function(){
			$("#school-form").validate({
				// debug: true,
				autoCreateRanges:true	,
				errorClass: "error",
				errorElement: "span",
				rules: {
					s_name: 'required',
					s_province: 'required',
					s_code: 'required'
				},
				messages: {
					s_name: '请输入院校名称',
					s_province: '请选择院校省份',
					s_code: '请输入院校代码'
				}
			});
		
		})
</script>