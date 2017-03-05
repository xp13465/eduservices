<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);


$this->breadcrumbs=array(
	'个人设置'=>array("user/view"),
	'个人信息',
);
$this->menu=array(
	// array('label'=>'用户列表', 'url'=>array('index')),
	// array('label'=>'添加用户', 'url'=>array('create')),
	// array('label'=>'修改该用户', 'url'=>array('update', 'id'=>$model->user_id)),
	// array('label'=>'删除该用户', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'确定删除这条数据?')),
	// array('label'=>'用户管理', 'url'=>array('admin')),
);
?>
<style>p.error{padding-top: 0px;}</style>
<fieldset>
<table class="table table-bordered">
  <tbody>
    <tr>
      <td class="nolinebg" width="100%">


<div class="bs-docs-example">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#info" data-toggle="tab">个人信息</a></li>
              <li class=""><a href="#password" data-toggle="tab">修改密码</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
			
              <div class="tab-pane fade active in" id="info">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userinfo-form',
	"htmlOptions"=>array('class'=>'form-horizontal userform'),
	'enableAjaxValidation'=>false,
)); ?>
<div class="control-group">
<label class="control-label" for="">帐号 <span class="rcolor">*</span></label>
<div class="controls">
<input type="hidden"  name="type" value='info'  />
<span class="mar-top"><?=$model->user_name?></span>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">负责人 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'user_nkname',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_nkname")); ?>
<p class="help-block pull-left pl8"></p>
<p for="user_nkname" class="error" style=""><?=isset($model->errors['user_nkname'])?join('',$model->errors['user_nkname']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="iphoto">负责人照片</label>
<div class="controls">
<div class="pull-left">
<img src='<?=$model->user_headimg?$model->user_headimg:"/img/photo.jpg"?>'   id="headerimg"></div>
<?php echo $form->hiddenField($model,'user_headimg',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_headimg")); ?>	
<a class="btn btn-mini btn-danger"  onclick="openUploadZP('user_headimg','headerimg')">负责人照片<?=!$model->user_headimg?"上传":"修改"?></a>&nbsp;
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
<p class="error help-block pull-left pl8">不能为空!</p>
<p for="user_tel" class="error" style=""><?=isset($model->errors['user_tel'])?join('',$model->errors['user_tel']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="">手机号码</label>
<div class="controls">
<?php echo $form->textField($model,'user_phone',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_phone")); ?>
<p class="error help-block pull-left pl8"></p>
<p for="user_phone" class="error" style=""><?=isset($model->errors['user_phone'])?join('',$model->errors['user_phone']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="">邮箱</label>
<div class="controls">
<?php echo $form->textField($model,'user_email',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_email")); ?>
<p class="error help-block pull-left pl8"></p>
<p for="user_email" class="error" style=""><?=isset($model->errors['user_email'])?join('',$model->errors['user_email']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="">通讯地址 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'user_adderss',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_adderss")); ?>
<p class="error help-block pull-left pl8"></p>
<p for="user_adderss" class="error" style=""><?=isset($model->errors['user_adderss'])?join('',$model->errors['user_adderss']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">网址</label>
<div class="controls">
<?php echo $form->textField($model,'user_webset',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"user_webset")); ?>
<p class="error help-block pull-left pl8">请使用http://格式!</p>
<p for="user_webset" class="error" style=""><?=isset($model->errors['user_webset'])?join('',$model->errors['user_webset']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">所属<span class="rcolor">*</span></label>
<div class="controls">
<?php 
	$OModel=array();
	$oid=$model->user_organization;
	for($i=0;$i<3;$i++){
		$omodel1=array();
		$omodel1=Organization::model()->findByPk($oid);
		$OModel[$i]=$omodel1;
		if(!$omodel1||$omodel1->o_pid=="0"||!$omodel1->o_pid)break;
		else $oid=$omodel1->o_pid;
	}
	
	?>
	
<span class="mar-top"><?=isset($OModel[count($OModel)-1])?$OModel[count($OModel)-1]['o_name']:''?><?=isset($OModel[count($OModel)-2])?"-".$OModel[count($OModel)-2]['o_name']:''?><?=isset($OModel[count($OModel)-3])?"-".$OModel[count($OModel)-3]['o_name']:""?></span>
</div>
</div>
<div class="form-actions">
<button type="submit" class="btn btn-primary" value="add">保存</button>&nbsp;
</div>
 <?php $this->endWidget(); ?>	
              </div>
			 
			  		
              <div class="tab-pane fade" id="password">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userpwd-form',
	"htmlOptions"=>array('class'=>'form-horizontal userform'),
	'enableAjaxValidation'=>false,
)); ?>
<div class="control-group">
<label class="control-label" for="">帐号 <span class="rcolor">*</span></label>
<div class="controls">
<input type="hidden"  name="type" value='password'  />
<span class="mar-top"><?=$model->user_name?></span>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">原密码 <span class="rcolor">*</span></label>
<div class="controls">
<input type="password" class="input-large pull-left" name="oldpwd" id="oldpwd" />
<p class="help-block pull-left pl8"></p>
<p for="oldpwd" class="error" style=""><?=isset($model->errors['user_pwd'])?join('',$model->errors['user_pwd']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">新密码 <span class="rcolor">*</span></label>
<div class="controls">
<input type="password" class="input-large pull-left" name="newpwd" id="newpwd"/>
<p class="error help-block pull-left pl8">不能少于6个字符!</p>
<p for="newpwd" class="error" style=""></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="">重复新密码 <span class="rcolor">*</span></label>
<div class="controls">
<input type="password" class="input-large pull-left" name="renewpwd" id="renewpwd"/>
<p class="error help-block pull-left"><?=isset($model->errors['repwd'])?join('',$model->errors['repwd']):""?></p>
<p for="renewpwd" class="error" style=""></p>
</div>
</div>

<div class="form-actions">
<button type="submit" class="btn btn-primary" value="add">修改</button>&nbsp;
</div>
 <?php $this->endWidget(); ?>	
 </div>
			  
            </div>
</div>




      </td>
    </tr>



  </tbody>

</table>
</fieldset>
<script>

$(document).ready(function() {

		
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
		
        $("#userinfo-form").validate({
            // debug: true,
			autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
				user_nkname: 'required',
				user_tel: {
                    required: true
                },
				user_adderss: {
                    required:true
                }
            },
            messages: {
				user_nkname: '请输入负责人',
				user_tel: {
                    required: '请输入联系电话'
                },
				user_adderss: {
                    required: '请输入联系地址'
                }
            }
        });
		$("#userpwd-form").validate({
            // debug: true,
			autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
				newpwd: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
				renewpwd: {
                    required: true,
                    equalTo: "#newpwd" 
                },
				oldpwd: {
                    required: true,
                    remote: "/user/isused/",
                }
            },
            messages: {
				newpwd: {
                    required: '请输入新密码',
                    minlength: "长度不能小于6",
                    maxlength: "长度不能大于20"
                },
				renewpwd: {
                    required: '请输入重复密码',
                    equalTo: "重复密码与新密码不匹配" 
                },
				oldpwd: {
                    required:'请输入原密码',
                    remote: "原密码错误" 
                }
            }
        });
    });

</script>


