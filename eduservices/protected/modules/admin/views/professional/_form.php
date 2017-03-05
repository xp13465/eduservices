<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
?>

  <div class="modal-header">
  
    <h3>专业管理-编辑</h3>
  </div>
  <div class="modal-body">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'professional-form',
	'enableAjaxValidation'=>false,
)); ?>

	  <div>
      <div class="control-group">
      <label class="control-label" for=""><b>所属专业层次</b></label>
      <div class="controls">
        <div class="input-append">
          <?php   echo CHtml::activeDropDownList($model, 'p_pid',Lookup::model()->getClassInfo('professionallevel'), array(
					'empty'=>'请选择学习中心',
					"name"=>"p_pid",
					'class'=>"pull-left width270"
			  )); ?>	
          </div>
		   <span for="p_pid" class="error" style=""><?=isset($model->errors['p_pid'])?join('',$model->errors['p_pid']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
      <label class="control-label" for=""><b>专业类型</b></label>
      <div class="controls">
        <div class="input-append">
          <?php   echo CHtml::activeDropDownList($model, 'p_type',Professional::$type, array(
					'empty'=>'请选择专业类型',
					"name"=>"p_type",
					'class'=>"pull-left width270"
			  )); ?>	
          </div>
		   <span for="p_type" class="error" style=""><?=isset($model->errors['p_type'])?join('',$model->errors['p_type']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>专业名称</b></label>
        <div class="controls">
          <div class="input-append">
			<?php echo $form->textField($model,'p_name',array('name'=>"p_name",'class'=>'width270')); ?>	
          </div>
		  <span for="p_name" class="error" style=""><?=isset($model->errors['p_name'])?join('',$model->errors['p_name']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>专业代码</b></label>
        <div class="controls">
			<div class="input-append">
			<?php echo $form->textField($model,'p_code',array('name'=>"p_code",'class'=>'width270')); ?>	
			</div>
			<span for="p_code" class="error" style=""><?=isset($model->errors['p_code'])?join('',$model->errors['p_code']):""?></span>
			<span class="help-inline" id="Tuser_error"></span>
        </div>
      </div>
    </div>
	
</div>
  <div class="form-actions">
	<button type="submit" class="btn btn-primary"  name="addsubmit" value="add">确认修改</button>&nbsp;
	<a href="<?=isset($_COOKIE['professionalreturnurl'])?$_COOKIE['professionalreturnurl']:""?>" class="btn" closeTime">返回</a>
	</div>
<?php $this->endWidget(); ?>

<script>
$(function(){
	$("#professional-form").validate({
		// debug: true,
		autoCreateRanges:true	,
		errorClass: "error",
		errorElement: "span",
		rules: {
			p_pid: 'required',
			p_code:'required',
			p_name:'required'
				
		},
		messages: {
			p_pid:'请选择专业层次',
			p_code:'请输入专业代码',
			p_name:'请输入专业名称'
		}
	});

})
</script>