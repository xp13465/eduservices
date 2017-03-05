<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
?>


  <div class="modal-body">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inputlimits-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php 
	$OModel=array();
	$oid=$usermodel->user_organization;
	for($i=0;$i<3;$i++){
		$omodel1=array();
		$omodel1=Organization::model()->findByPk($oid);
		$OModel[$i]=$omodel1;
		if(!$omodel1||$omodel1->o_pid=="0"||!$omodel1->o_pid)break;
		else $oid=$omodel1->o_pid;
	}
	
	?>

		
		
    <div>
       <div class="control-group">
        <label class="control-label" for=""><b>限制用户</b></label>
        <div class="controls">
        <dl class="dl-horizontal">
			<dt>帐号</dt><dd><?=$usermodel->user_name?$usermodel->user_name:'&nbsp;'?></dd>
			<dt>负责人</dt><dd><?=$usermodel->user_nkname?$usermodel->user_nkname:'&nbsp;'?></dd>
			<dt>联系电话</dt><dd><?=$usermodel->user_tel?$usermodel->user_tel:'&nbsp;'?></dd>
			<dt>手机号码</dt><dd><?=$usermodel->user_phone?$usermodel->user_phone:'&nbsp;'?></dd>
            <dt>所属学习中心</dt><dd><?=isset($OModel[count($OModel)-1])?$OModel[count($OModel)-1]['o_name']:'&nbsp;'?></dd>
			<dt>所属报名点</dt><dd><?=isset($OModel[count($OModel)-2])?$OModel[count($OModel)-2]['o_name']:'&nbsp;'?></dd>
			<dt>所属机构</dt><dd><?=isset($OModel[count($OModel)-3])?$OModel[count($OModel)-3]['o_name']:"&nbsp;"?></dd>
            <dt>帐号状态</dt><dd><span class="blcolor1"><?=$usermodel->user_status==1?"启用":"禁用"?></span></dd>
          </dl>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>限制批次</b></label>
        <div class="controls">
          <div class="input-append">
            <?php   echo $form->DropDownList($model, 'il_pc',Inputlimits::model()->getPiCi($usermodel->user_id,$model->isNewRecord?"":$model->il_pc), array(
					"name"=>"il_pc",
					'class'=>"pull-left"
			  )); ?>
          </div>
		  <span for="il_pc" class="error" style=""><?php echo $form->error($model,'il_pc'); ?></span>
          <span class="help-inline" id=""></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for=""><b>限制数量</b></label>
        <div class="controls">
			<div class="input-append">
			<?php echo $form->textField($model,'il_limit',array('name'=>"il_limit",'class'=>'width270')); ?>	
			</div>
			<span for="il_limit" class="error" style=""><?=isset($model->errors['il_limit'])?join('',$model->errors['il_limit']):""?></span>
			<span class="help-inline" id="Tuser_error"></span>
        </div>
      </div>
    </div>

</div>
  <div class="form-actions">
	<button type="submit" class="btn btn-primary"  name="addsubmit" value="add"><?=$model->isNewRecord ? '添加' : '修改'?></button>&nbsp;
	<a href="<?=Yii::app()->createUrl("admin/account/view",array("id"=>$usermodel->user_id))?>" class="btn" closeTime">返回</a>
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
			
				
		},
		messages: {
			
		}
	});

})
</script>
