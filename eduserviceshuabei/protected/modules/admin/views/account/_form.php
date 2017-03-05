<?php
/* @var $this StudentsController  */
/* @var $model Students */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jsdate/WdatePicker.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
?>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	"htmlOptions"=>array('class'=>'form-horizontal userform'),
	'enableAjaxValidation'=>false,
)); ?>
<?php  //echo $form->errorSummary($model); ?>



<fieldset>
<table class="table table-bordered">
  <tbody>
    <tr>
      <td>
        <h5 class="pull-left">请仔细核对后提交信息</h5>
      </td>
    </tr>
    <tr>
      <td class="nolinebg" width="100%">

<div class="nocolumn">

<div class="control-group">
<label class="control-label" for="">帐号 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'user_name',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_name")); ?>
<p class="error pull-left pl8">请用英文字母，不能少于6个字符!</p>
<p for="user_name" class="error" style=""><?=isset($model->errors['user_name'])?join('',$model->errors['user_name']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">密码 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->passwordField($model,'user_pwd',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_pwd")); ?>
<p class="error pull-left pl8">不能少于6个字符!</p>
<p for="user_pwd" class="error" style=""><?=isset($model->errors['user_pwd'])?join('',$model->errors['user_pwd']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">重复密码 <span class="rcolor">*</span></label>
<div class="controls">
<input class="input-large pull-left" maxlength="100" name="user_repwd" id="user_repwd" type="password">
<p class="error pull-left pl8">不能少于6个字符!</p>
<p for="user_repwd" class="error" style=""></p>
</div>

</div>
<div class="control-group">
<label class="control-label" for="">负责人 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'user_nkname',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_nkname")); ?>
<p class="error pull-left pl8">不能为空!</p>
<p for="user_nkname" class="error" style=""><?=isset($model->errors['user_nkname'])?join('',$model->errors['user_nkname']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="iphoto">负责人照片</label>
<div class="controls">
<?php echo $form->hiddenField($model,'user_headimg',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_headimg")); ?>	
<div class="pull-left">
<a class="btn btn-mini btn-danger 	"  onclick="openUploadZP('user_headimg','headerimg','headerimgshowbtn')">照片<?=!$model->user_headimg?"上传":"修改"?></a>&nbsp;
<a class="btn btn-mini btn-success" style='<?=$model->user_headimg?"":"display:none"?>'id="headerimgshowbtn">照片预览</a>
<img src='<?=$model->user_headimg?>' class='hide showimg'  id="headerimg">
</div>
<p for="user_headimg" class="error" style=""><?=isset($model->errors['user_headimg'])?join('',$model->errors['user_headimg']):""?></p>
<p class="pull-left pl8" style="<?=isset($model->errors['user_headimg'])?"":""?>">个人照片尺寸150*210，20k以下!</p>
</div>
</div>
<div class="control-group hide">
<div class="controls">
<img src="../img/photo.jpg" />
</div>
</div>
<div class="control-group">
<label class="control-label" for="">联系电话 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'user_tel',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_tel")); ?>
<p class="error pull-left pl8">不能为空!</p>
<p for="user_tel" class="error" style=""><?=isset($model->errors['user_tel'])?join('',$model->errors['user_tel']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">手机号码</label>
<div class="controls">
<?php echo $form->textField($model,'user_phone',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_phone")); ?>
<p class="error pull-left pl8"></p>
<p for="user_phone" class="error" style=""><?=isset($model->errors['user_phone'])?join('',$model->errors['user_phone']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="">邮箱</label>
<div class="controls">
<?php echo $form->textField($model,'user_email',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_email")); ?>
<p class="error pull-left pl8"></p>
<p for="user_email" class="error" style=""><?=isset($model->errors['user_email'])?join('',$model->errors['user_email']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">通讯地址 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'user_adderss',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_adderss")); ?>
<p class="error pull-left pl8"></p>
<p for="user_adderss" class="error" style=""><?=isset($model->errors['user_adderss'])?join('',$model->errors['user_adderss']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">网址</label>
<div class="controls">
<?php echo $form->textField($model,'user_webset',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_webset")); ?>
<p class="error pull-left pl8">请使用http://格式!</p>
<p for="user_webset" class="error" style=""><?=isset($model->errors['user_webset'])?join('',$model->errors['user_webset']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">所属学习中心 <span class="rcolor">*</span></label>
<div class="controls">
<?php 	$zxtmp=$model->user_role==3?$model->user_organization:"";
		$bmtmp=$model->user_role==2?$model->user_organization:"";
		$jgtmp=$model->user_role==1?$model->user_organization:"";
		$JGmodel=$BMmodel=array();
		if($jgtmp){
			$JGmodel=Organization::model()->findByPk($jgtmp);
			$bmtmp=$JGmodel->o_pid;
			$BMmodel=Organization::model()->findByPk($JGmodel->o_pid);
			$zxtmp=$BMmodel->o_pid;
		}
		if($bmtmp){
			$BMmodel=Organization::model()->findByPk($bmtmp);
			$zxtmp=$BMmodel->o_pid;
		}
		echo CHtml::dropDownList('zhongxin',$zxtmp, Organization::model()->getOrByPid(0),
		array(
			'name'=>'zhongxin',
			'empty'=>'请选择所属学习中心',
			'class'=>"wauto pull-left",
			'ajax' => array(
			'type'=>'GET', 
			'url'=>CController::createUrl('admin/getorganization'),
			'update'=>'#baomingdian', 
			'data'=>array('pid'=>"js:this.value",'typeid'=>1)
		)));
		
		?>
<p for="zhongxin" class="error" style=""><?=isset($model->errors['zhongxin'])?join('',$model->errors['zhongxin']):""?></p>
</div>

</div>
<div class="control-group">
<label class="control-label" for="">所属报名点</label>
<div class="controls">
<?php

		
		$datas=$zxtmp?Organization::model()->getOrByPid($zxtmp):array();
		echo CHtml::dropDownList('baomingdian',$bmtmp, $datas,
		array(	
			'name'=>'baomingdian',
			'empty'=>'请选择报名点',
			'class'=>"wauto",
			'ajax' => array(
			'type'=>'GET', 
			'url'=>CController::createUrl('admin/getorganization'),
			'update'=>'#jigou', 
			'data'=>array('pid'=>"js:this.value",'typeid'=>2)
			)
		));

?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">所属机构</label>
<div class="controls">
<?php 
		
		$datas=$bmtmp?Organization::model()->getOrByPid($bmtmp):array();
		echo CHtml::dropDownList('jigou',$jgtmp, $datas,
		array(	
			'name'=>'jigou',
			'empty'=>'请选择机构',
			'class'=>"wauto",
		));
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">帐号状态 <span class="rcolor">*</span></label>
<div class="controls">

<div class='pull-left'>
<?php //echo $form->radioButtonList($model,'user_status',User::$Status,array('name'=>"user_status",'template'=>'<label class="pull-left radio inline">{input}{label}</label>','separator'=>'&nbsp;')); ?>

<label class="radio inline" style='width: 30px;' >
<input type="radio" name="user_status" id="user_status_0" <?=$model->user_status=="0"?"checked":""?> value="0">禁用
</label>
<label class="radio inline" style='width: 30px;' >
<input type="radio" name="user_status" id="user_status_1" <?=$model->user_status=="1"?"checked":""?> value="1">启用
</label>
</div>
<p for="user_status" class="error" style=""><?=isset($model->errors['user_status'])?join('',$model->errors['user_status']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">允许录入区号</label>
<div class="controls">
<?php echo $form->textField($model,'user_sfqz',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_sfqz")); ?>
<p class="error pull-left pl8">不填则可录全部，区号前2位 如 31 如设置多个区号  用（，）号分割如 31，32</p>
<p for="user_sfqz" class="error" style=""><?=isset($model->errors['user_sfqz'])?join('',$model->errors['user_sfqz']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">本地区号</label>
<div class="controls">
<?php echo $form->textField($model,'user_bddm',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_bddm")); ?>
<p class="error pull-left pl8">不填则判定为未归类，区号前2位 如 31 如设置多个区号  用（，）号分割如 31，32</p>
<p for="user_bddm" class="error" style=""><?=isset($model->errors['user_bddm'])?join('',$model->errors['user_bddm']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">权限备注</label>
<div class="controls">
<?php echo $form->textField($model,'user_rolebz',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_rolebz")); ?>
<p class="error pull-left pl8">不填则按默认权限显示。</p>
<p for="user_rolebz" class="error" style=""><?=isset($model->errors['user_rolebz'])?join('',$model->errors['user_rolebz']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">API开放授权</label>
<div class="controls">
<?php $Arr= unserialize($model->user_authorize);?>
<label class="checkbox inline" style='width:100px;'>
  <input type="checkbox" name='auth[synlogin]' onclick='selectOne(this,"auth[synlogin]")' <?=isset($Arr['synlogin'])&&$Arr['synlogin']==1?"checked='checked'":""?> value="1"> 同步登录
</label>
<label class="checkbox inline" style='width:100px;'>
  <input type="checkbox" name='auth[synlogin]' onclick='selectOne(this,"auth[synlogin]")' <?=isset($Arr['synlogin'])&&$Arr['synlogin']==2?"checked='checked'":""?> value="2"> 无条件同步登录
</label>
<br/>
<label class="checkbox inline" style='width:100px;'>
  <input type="checkbox" name='auth[synlogout]' <?=isset($Arr['synlogout'])&&$Arr['synlogout']?"checked='checked'":""?> value="1"> 同步登出
</label>
<br/>
<label class="checkbox inline" style='width:100px;'>
  <input type="checkbox" name='auth[changepwd]' <?=isset($Arr['changepwd'])&&$Arr['changepwd']?"checked='checked'":""?> value="1"> 同步修改密码
</label>
<br/>
<label class="checkbox inline" style='width:100px;'>
  <input type="checkbox" name='auth[diyinsert]' <?=isset($Arr['diyinsert'])&&$Arr['diyinsert']?"checked='checked'":""?> value="1"> 学员高级录入
</label>
<br/>
<label class="checkbox inline" style='width:100px;'>
  <input type="checkbox" name='auth[synbeihang]' <?=isset($Arr['synbeihang'])&&$Arr['synbeihang']?"checked='checked'":""?> value="1"> 北航同步帐号
</label>
<br/>
<p for="user_rolebz" class="error" style=""><?=isset($model->errors['user_rolebz'])?join('',$model->errors['user_rolebz']):""?></p>
</div>
</div>



      </td>
    </tr>
    <tr>
      <td>
<div class="form-actions">
<button type="submit" class="btn btn-primary" name="addsubmit" value="add"><?=!$model->isNewRecord?"修改":"添加"?>数据</button>&nbsp;
<?php if($model->isNewRecord){?>
<button type="reset" class="btn">重新填写</button>
<?php }?>
</div>
      </td>
    </tr>



  </tbody>

</table>
</fieldset>


<?php $this->endWidget(); ?>	
 </div>
<script>

$(document).ready(function() {
/*]]>*/
	jQuery('body').on('change','#zhongxin',function(){
		jQuery.ajax({'type':'GET','url':'/admin/admin/getorganization.html','data':{'pid':0,'typeid':2},'cache':false,'success':function(html){jQuery("#jigou").html(html)}});return false;
	});
		jQuery.validator.addMethod("alnum", function(value, element) {
		return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
		}, "只能包括英文字母和数字");
		jQuery.validator.addMethod("cnCharset", function(value, element) {   
		return this.optional(element) || /^[\u0391-\uFFE5]+$/.test(value);   
		});
		jQuery.validator.addMethod("cndate", function(value, element) {   
		return this.optional(element) || /^[1-2][0-9][0-9][0-9][0-1][0-9][0-3][0-9]$/.test(value);   
		});
		jQuery.validator.addMethod("cndatenoday", function(value, element) {   
		return this.optional(element) || /^[1-2][0-9][0-9][0-9]-[0-1][0-9]$/.test(value);   
		});
		jQuery.validator.addMethod("isIdCardNo", function(value, element) { 
		return this.optional(element) || isIdCardNo(value); 
		}, "请正确输入您的身份证号码");
		$(".controls").find("input").change(function(){
		// alert($(this).parent('div.controls').find("p.pl8"))
			if($(this).parent('div.controls').find("p.pl8").css("display")=="block"){
				$(this).parent('div.controls').find("p.pl8").hide()
			}
		})
		$("a.btn-success").mouseover(function(){
			$(this).next("img").show();
			
		}).mouseout(function(){
			$(this).next("img").hide();
			
		})
		
        $("#user-form").validate({
            // debug: true,
			autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
                user_name: {
                    required: true,
					alnum:true,
                    minlength: 6,
                   
					<?php if($model->isNewRecord){?>
                    remote: "/site/isused",
					<?php }?>
					 maxlength: 20
                },
				user_pwd: {
				<?php if($model->isNewRecord){?>
                    required: true,
				<?php }?>
                    minlength: 6,
                    maxlength: 20
                },
				user_repwd: {
					<?php if($model->isNewRecord){?>
                    required: true,
					<?php }?>
                    equalTo: "#user_pwd" 
                },
				user_nkname: 'required',
				user_tel: {
                    required: true
                },
				user_adderss: {
                    required:true
                },
				zhongxin: 'required'
            },
            messages: {
                user_name: {
                    required: "请用英文字母，不能少于6个字符!",
					alnum:'必须是英文字母',
                    minlength: "不能少于6个字符",
					<?php if($model->isNewRecord){?>
					remote: "该名称已经存在",
					<?php }?>
                    maxlength: "不能大于20个字符"
					
                },
				user_pwd: {
					<?php if($model->isNewRecord){?>
                    required: '请输入密码',
					<?php }?>
                    minlength: "长度不能小于6",
                    maxlength: "长度不能大于20"
                },
				user_repwd: {
					<?php if($model->isNewRecord){?>
                    required: '请输入重复密码',
					<?php }?>
                    equalTo: "重复密码与密码不匹配" 
                },
				user_nkname: '请输入负责人',
				user_tel: {
                    required: '请输入联系电话'
                },
				user_adderss: {
                    required: '请输入联系地址'
                },
				zhongxin: '请选择学习中心'
            }
        });
    });

</script>
