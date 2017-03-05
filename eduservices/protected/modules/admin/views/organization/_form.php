<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
?>


  <div class="modal-header">
  
    <h3><?=$show?>管理-编辑</h3>
  </div>
  <div class="modal-body">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organization-form',
	'enableAjaxValidation'=>false,
)); 
$jigouArr=Organization::model()->getAlljigouId();
$baomingArr=Organization::model()->getAllbaomingdianId();
if($model->o_pid=="0"){?>


    <div>
      <div class="control-group">
        <label class="control-label" for=""><b>学习中心名称</b></label>
        <div class="controls">
          <div class="input-append">
			<?php echo $form->textField($model,'o_name',array('name'=>"o_name",'class'=>'width270')); ?>	
          </div>
		  <span for="o_name" class="error" style=""><?=isset($model->errors['o_name'])?join('',$model->errors['o_name']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>学习中心代码</b></label>
        <div class="controls">
			<div class="input-append">
			<?php echo $form->textField($model,'o_code',array('name'=>"o_code",'class'=>'width270')); ?>	
			</div>
			<span for="o_code" class="error" style=""><?=isset($model->errors['o_code'])?join('',$model->errors['o_code']):""?></span>
			<span class="help-inline" id="Tuser_error"></span>
        </div>
      </div>
    </div>

<?php }else if(in_array($model->o_pid,$baomingArr)){?>

    <div>
      <div class="control-group">
      <label class="control-label" for=""><b>所属学习中心</b></label>
      <div class="controls">
        <div class="input-append">
          <?php   echo CHtml::activeDropDownList($model, 'o_pid',Organization::model()->getOrByPid(0), array(
					'empty'=>'请选择学习中心',
					"name"=>"o_pid",
					'class'=>"pull-left"
			  )); ?>	
          </div>
		   <span for="o_pid" class="error" style=""><?=isset($model->errors['o_pid'])?join('',$model->errors['o_pid']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>报名点名称</b></label>
        <div class="controls">
          <div class="input-append">
			<?php echo $form->textField($model,'o_name',array('name'=>"o_name",'class'=>'width270')); ?>	
          </div>
		  <span for="o_name" class="error" style=""><?=isset($model->errors['o_name'])?join('',$model->errors['o_name']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>报名点代码</b></label>
        <div class="controls">
			<div class="input-append">
			<?php echo $form->textField($model,'o_code',array('name'=>"o_code",'class'=>'width270')); ?>	
			</div>
			<span for="o_code" class="error" style=""><?=isset($model->errors['o_code'])?join('',$model->errors['o_code']):""?></span>
			<span class="help-inline" id="Tuser_error"></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>报名点本地区号</b></label>
        <div class="controls">
			<div class="input-append">
			<?php echo $form->textField($model,'o_zone',array('name'=>"o_zone",'class'=>'width270')); ?>	
			</div>
			<span for="o_zone" class="error" style=""><?=isset($model->errors['o_zone'])?join('',$model->errors['o_zone']):""?></span>
			<span class="help-inline" id="Tuser_error"></span>
        </div>
      </div>
    </div>
  
<?php }else if(in_array($model->o_pid,$jigouArr)){
$POmodel=Organization::model()->find("o_id ='{$model->o_pid}'");
$POid=$POmodel?$POmodel->o_pid:"";
?>

    <div>
      <div class="control-group">
      <label class="control-label" for=""><b>所属学习中心</b></label>
      <div class="controls">
        <div class="input-append">
          <?php echo CHtml::DropDownList('zhongxin',$POid, Organization::model()->getOrByPid(0), array(
							"name"=>"zhongxin",
							'empty'=>'请选择学习中心',
							'class'=>"pull-left",
							'ajax'=>array(

									  'type'=>'GET',

									  'url'=>CController::createUrl('admin/getorganization'),

									  'update'=>'#o_pid',

									  'data'=>array('pid'=>"js:this.value",'typeid'=>1)

							))); ?>
          </div>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
      <label class="control-label" for=""><b>所属报名点</b></label>
      <div class="controls">
        <div class="input-append">
         <?php   echo CHtml::activeDropDownList($model, 'o_pid',Organization::model()->getOrByPid($POid), array(
					'empty'=>'请选择报名点名称',
					"name"=>"o_pid",
					'class'=>"pull-left"
			  )); ?>
          </div>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>机构名称</b></label>
        <div class="controls">
          <div class="input-append">
			<?php echo $form->textField($model,'o_name',array('name'=>"o_name",'class'=>'width270')); ?>	
          </div>
		  <span for="o_name" class="error" style=""><?=isset($model->errors['o_name'])?join('',$model->errors['o_name']):""?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
    </div>

    <?php }?>
</div>
  <div class="form-actions">
	<button type="submit" class="btn btn-primary"  name="addsubmit" value="add">确认修改</button>&nbsp;
	<a href="<?=isset($_COOKIE['organreturnurl'])?$_COOKIE['organreturnurl']:""?>" class="btn" closeTime">返回</a>
	</div>

<?php $this->endWidget(); ?>
<script>
$(function(){
	$("#organization-form").validate({
		// debug: true,
		autoCreateRanges:true	,
		errorClass: "error",
		errorElement: "span",
		rules: {
			<?php if($show=='机构'){?>
			zhongxin:'required',
			<?php }?>
			<?php if($show!='学习中心'){?>
			o_pid: 'required',
			<?php }?>
			<?php if($show!='机构'){?>
			o_code:'required',
			<?php }?>
			o_name:'required'
				
		},
		messages: {
			<?php if($show=='机构'){?>
			zhongxin:'请选择学习中心',
			<?php }?>
			<?php if($show!='学习中心'){?>
			o_pid:'请选择<?=$show=='报名点'?"学习中心":"报名点"?>',
			<?php }?>
			<?php if($show!='机构'){?>
			o_code:'请输入<?=$show?>代码',
			<?php }?>
			o_name:'请输入<?=$show?>名称'
		}
	});

})
</script>