<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
?>


  <div class="modal-header">
  
    <h3><?=$show?>管理-编辑</h3>
  </div>
  <div class="modal-body">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'Questions-form',
	'enableAjaxValidation'=>false,
)); 
$baomingArr=Questions::model()->getAlltikujiId();
if($model->q_pid=="0"){?>


    <div>
      <div class="control-group">
        <label class="control-label" for=""><b>题库集名称</b></label>
        <div class="controls">
          <div class="input-append">
			<?php echo $form->textField($model,'q_name',array('name'=>"q_name",'class'=>'width270')); ?>	
          </div>
		  <span for="q_name" class="error" style=""><?=isset($model->errors['q_name'])?join('',$model->errors['q_name']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
    </div>

<?php }else if(in_array($model->q_pid,$baomingArr)){?>

    <div>
      <div class="control-group">
      <label class="control-label" for=""><b>所属题库集</b></label>
      <div class="controls">
        <div class="input-append">
          <?php   echo CHtml::activeDropDownList($model, 'q_pid',Questions::model()->getQrByPid(0), array(
					'empty'=>'请选择题库集',
					"name"=>"q_pid",
					'class'=>"pull-left"
			  )); ?>	
          </div>
		   <span for="q_pid" class="error" style=""><?=isset($model->errors['q_pid'])?join('',$model->errors['q_pid']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>报名点名称</b></label>
        <div class="controls">
          <div class="input-append">
			<?php echo $form->textField($model,'q_name',array('name'=>"q_name",'class'=>'width270')); ?>	
          </div>
		  <span for="q_name" class="error" style=""><?=isset($model->errors['q_name'])?join('',$model->errors['q_name']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
    </div>
  
<?php }
?>
</div>
  <div class="form-actions">
	<button type="submit" class="btn btn-primary"  name="addsubmit" value="add">确认修改</button>&nbsp;
	<a href="<?=isset($_COOKIE['questionreturnurl'])?$_COOKIE['questionreturnurl']:""?>" class="btn" closeTime">返回</a>
	</div>

<?php $this->endWidget(); ?>
<script>
$(function(){
	$("#Questions-form").validate({
		// debug: true,
		autoCreateRanges:true	,
		errorClass: "error",
		errorElement: "span",
		rules: {
			<?php if($show=='题库'){?>
			q_pid:'required',
			<?php }?>	
			q_name:'required'
				
		},
		messages: {
			<?php if($show=='题库'){?>
			q_pid:'请选择题库集',
			<?php }?>
			q_name:'请输入<?=$show?>名称'
		}
	});

})
</script>