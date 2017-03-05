<?php
/* @var $this StudentsController  */
/* @var $model Students */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jsdate/WdatePicker.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
$inputType='';
if($model->mk_sid){
    $inputType='readonly';
}

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mk_form',
	"htmlOptions"=>array('class'=>'form-horizontal mkform'),
	'enableAjaxValidation'=>false,
)); ?>
<?php //echo $form->errorSummary($model);?>
<script>
function checkselect(value){
if(value&&value!=""){
document.getElementById('mkyy').style.display='';
document.getElementById('mkyy').style.visibility='';
}
if(!value||value==''){
document.getElementById('mkyy').style.display='none';
document.getElementById('mkyy').style.visibility='hidden';
}
if(value){
    var showStr=value==2?"计算机证书":"英语证书";
    $("#showStr").html(showStr);
}else{
    $("#showStr").html("附件上传");
}
hidevalue=value==2?1:2;
$('input[name="mk_reason[]"]').each(function(){  
$(this).attr("checked", false);
});
$(".reason").show()
$(".reason"+value).show()
$(".reason"+hidevalue).hide()
}

</script>
<table class="table table-bordered">
<tbody>
<tr><td><span class="marl10">请仔细核对后提交信息</span></td></tr>
<?php if(Yii::app()->user->role==5||in_array(Yii::app()->user->id,array(1,2))){?>
<tr>
    <td>
        <div class="control-group">
            <label class="control-label" for="verify">审核状态 </label>
            <div class="controls " id='mk_status'>
            <div class='pull-left'>
            <label class="radio inline" style='width:40px'>
            <input type="radio" name="mk_status" id="mk_status_0" <?=$model->mk_status=="2"?"checked":""?> value="2">通过
            </label>
            <label class="radio inline" style='width:60px'>
            <input type="radio" name="mk_status" id="mk_status_1" <?=$model->mk_status=="1"?"checked":""?> value="1">待审核
            </label>
            </div>
            <p class="error  pull-left pl8">待审核后重审!</p>
            </div>
        </div> 
    </td>
</tr>
<tr>
  <td>
        <div class="control-group">
        <label class="control-label" for="mk_statusabout">审核备注修改 </label>
        <div class="controls">
        <?php echo $form->textAREA($model,'mk_statusabout',array('class'=>'input-large pull-left','maxlength'=>200,'name'=>"mk_statusabout",'style'=>"width:400px;height:100px")); ?>
        <p class="error  pull-left pl8"></p>               
        </div>
        </div>
  </td>
</tr>  
<?php }?>
      
<tr>
<td>
<div>
	
	<div class="control-group">
		<label class="control-label">证件类型 <span class="rcolor">*</span></label>
		<div class="controls">
            <?php 
            $modelArr=Emapp::$credentialstype;
            if($inputType){
                foreach($modelArr as $key=>$val){
                    if($key!=$model->mk_cardtype)unset($modelArr[$key]);
                }
            
            }?>
			<?php echo CHtml::dropDownList('mk_cardtype',$model->mk_cardtype,$modelArr,array('name'=>"mk_cardtype","empty"=>"请选择证件类型", 'class'=>"input-large pull-left",'readonly'=>$inputType)); ?>
			<p class="error help-block pull-left pl8"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">证件号码 <span class="rcolor">*</span></label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_cardnumber',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"mk_cardnumber",'readonly'=>$inputType)); ?>
			<p class="error pull-left pl8">必填!数字型</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">学号 <span class="rcolor">*</span></label>
			<div class="controls">
			<?php echo $form->textField($model,'mk_xh',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"mk_xh",'readonly'=>$inputType)); ?>
			<p class="error pull-left pl8">必填!数字型</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">学员姓名 <span class="rcolor">*</span></label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_sname',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"mk_sname",'readonly'=>$inputType)); ?>
			<p class="error pull-left pl8">必填!</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">性别 <span class="rcolor">*</span></label>
		<div class="controls">
			<div class='pull-left'>
				<label class="radio inline" style='width:30px;' ><input type="radio" name="mk_sex" id="mk_sex_1" <?=$model->mk_sex=="1"?"checked":""?> <?=$inputType?"readonly='readonly' onclick='return false' ":""?> value="1">男</label>
				<label class="radio inline" style='width:30px;' ><input type="radio" name="mk_sex" id="mk_sex_0" <?=$model->mk_sex=="0"?"checked":""?> <?=$inputType?"readonly='readonly' onclick='return false' ":""?> value="0">女</label>
			</div>
			<p class="error pull-left pl8">必选!</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="mk_ethnic">民族 <span class="rcolor">*</span></label>
		<div class="controls">
            <?php 
            $model->mk_ethnic=$model->mk_ethnic?$model->mk_ethnic:"1";
            $modelArr=Lookup::model()->getClassInfo("nationality");
            if($inputType){
                foreach($modelArr as $key=>$val){
                    if($key!=$model->mk_ethnic)unset($modelArr[$key]);
                }
            
            }?>
            
			<?php echo $form->dropDownList($model,'mk_ethnic',$modelArr,$htmlOptions=array ('name'=>"mk_ethnic","empty"=>"请选择民族", 'class'=>"pull-left",'readonly'=>$inputType)); ?>
			<p class="error pull-left pl8">必选!</p>
		</div>
	</div>
	<div class="control-group" style="display:none;">
		<label class="control-label">就读试点高校 <span class="rcolor">*</span></label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_sdgx',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"mk_sdgx",'value'=>'北京航空航天大学')); ?>
			<p class="error pull-left pl8">必填!</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">专业 <span class="rcolor">*</span></label>
		<div class="controls">
		<?php echo $form->dropDownList($model,'mk_specialty',Professional::model()->getKCInfo(2),$htmlOptions=array ('empty'=>"请选择专业",'name'=>"mk_specialty",'class'=>"input-large pull-left",'readonly'=>$inputType)); ?>
		<p class="error pull-left pl8">必填!</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">手机号码<span class="rcolor">*</span></label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_moblie',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"mk_moblie",'readonly'=>$inputType)); ?>
			<p class="error pull-left pl8">必填!数字型</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">联系电话 </label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_tel',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"mk_tel",'readonly'=>$inputType)); ?>
			<p class="error pull-left pl8"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">申请免考科目<span class="rcolor">*</span> </label>
		<div class="controls">
		<?php echo $form->dropDownList($model,'mk_subject',Emapp::$subject,$htmlOptions=array ('empty'=>"请选择免考科目",'name'=>"mk_subject",'class'=>"input-large pull-left","onchange"=>"checkselect(this.value)")); ?>
		<p for="mk_subject" class="error" style=""><?=isset($model->errors['mk_subject'])?join('',$model->errors['mk_subject']):""?></p>
		</div>
	</div>
	<div id='mkyy' class="control-group" style="<?=$model&&$model->mk_subject?"display:block":"display:none;visibility:hidden;"?>">
		<label class="control-label"><font color="#003399">申请免考原因</font><span class="rcolor">*</span></label>
		<div class="controls">
			<div class="pull-left">
				<?php $e_trip = unserialize($model->mk_reason);?>
				<label class='reason reasonselect' style="padding-top:5px;<?=$model&&$model->mk_subject?"display:block":"display:none"?>">
					<input type="checkbox" name="mk_reason[]" value="1" <?=$e_trip[1]==1?"checked":"";?> >&nbsp;&nbsp;已具有国民教育系列本科以上学历（含本科）
				</label>
				<label class='reason2 reasonselect'  style="padding-top:5px;<?=$model&&$model->mk_subject==2?"display:block":"display:none"?>">
					<input type="checkbox" name="mk_reason[]" value="2" onchange="checkdiv(this)" <?=$e_trip[2]==1?"checked":"";?> >&nbsp;&nbsp;非计算机类专业,获得全国计算机等级考试一级B或以上级别证书
				</label>
				<label class='reason1 reasonselect'  style="padding-top:5px;<?=$model&&$model->mk_subject==1?"display:block":"display:none"?>">
					<input type="checkbox" name="mk_reason[]" value="3" <?=$e_trip[3]==1?"checked":"";?> />&nbsp;&nbsp;非英语专业,获得大学英语等级考试CET四级或以上级别证书
				</label>
				<label class='reason1 reasonselect'  style="padding-top:5px;<?=$model&&$model->mk_subject==1?"display:block":"display:none"?>">
					<input type="checkbox" name="mk_reason[]" value="4" onchange="checkdiv(this)" <?=$e_trip[4]==1?"checked":"";?> />&nbsp;&nbsp;非英语专业,获得全国公共英语等级考试PETS三级或以上级别证书
				</label>
				<label class='reason1 reasonselect'  style="padding-top:5px;<?=$model&&$model->mk_subject==1?"display:block":"display:none"?>">
					<input type="checkbox" name="mk_reason[]" value="5" <?=$e_trip[5]==1?"checked":"";?> />&nbsp;&nbsp;非英语专业,省级教育行政部门组织的成人教育学位英语考试合格证书
				</label>
				<label class='reason1 reasonselect'  style="padding-top:5px;<?=$model&&$model->mk_subject==1?"display:block":"display:none"?>">
					<input type="checkbox" name="mk_reason[]" value="6" onchange="checkdiv(this)" <?=$e_trip[6]==1?"checked":"";?> />&nbsp;&nbsp;非英语专业,入学注册时年龄满40周岁
				</label>
				<label class='reason1 reasonselect'  style="padding-top:5px;<?=$model&&$model->mk_subject==1?"display:block":"display:none"?>">
					<input type="checkbox" name="mk_reason[]" value="7" <?=$e_trip[7]==1?"checked":"";?> />&nbsp;&nbsp;非英语专业,户籍(以身份证的为准)在少数民族聚居地区的少数民族学生
				</label>
			</div>
			<p class="error pull-left pl8">必选!</p><p for="mk_reason[]" class="error"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" id='showStr' for="iphoto"><?=$model->mk_subject?$model->mk_subject==1?"英语证书":"计算机证书":"附件上传"?></label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_file',array('class'=>'input-large pull-left wauto','name'=>"mk_file","readonly"=>"readonly")); ?>
			<div class="pull-left">
				<a class="btn btn-mini btn-danger"   onclick="openUpload('mk_file')">附件<?=!$model->mk_file?"上传":"修改"?></a>&nbsp;
				<a class="btn btn-mini btn-success"  onclick="if($('#mk_file').val()){　window.open ($('#mk_file').val()) }else{alert('请先上传')}">查看</a>
			</div>
			<p for="mk_file" class="error" style=""><?=isset($model->errors['mk_file'])?join('',$model->errors['mk_file']):""?></p>
			<p class="error pull-left pl8" >附件格式必须为zip、rar、jpg、gif、png且1M以下!</p>
		</div>
	</div>
	<div class="control-group sfcardimgdiv" style="<?=$e_trip[6]==1?"":"display:none";?>">
		<label class="control-label" for="iphoto">身份证图片</label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_cardimg',array('class'=>'input-large pull-left wauto','name'=>"mk_cardimg","readonly"=>"readonly")); ?>	
			<div class="pull-left">
				<a class="btn btn-mini btn-danger 	"  onclick="openUploadMK('mk_cardimg','cardimg','cardimgshowbtn')">证件<?=!$model->mk_file?"上传":"修改"?></a>&nbsp;
				<a class="btn btn-mini btn-success" style='<?=$model->mk_cardimg?"":"display:none"?>'id="cardimgshowbtn">证件预览</a>
				<img src='<?=$model->mk_cardimg?>' class='hide showimg'  id="cardimg">
			</div>
			<p class="error pull-left pl8" >证件尺寸150*210，200k以下!</p>
			<p for="mk_cardimg" class="error" style=""><?=isset($model->errors['mk_cardimg'])?join('',$model->errors['mk_cardimg']):""?></p>
		</div>
	</div>
	<div class="control-group hide">
		<div class="controls"><img src="../img/photo.jpg" /></div>
	</div>
	<div class="control-group mkxxdiv" style="<?=$e_trip[4]==1||$e_trip[2]==1?"":"display:none";?>">
		<label class="control-label" for="verify">请选择考试时间</label>
		<div class="controls">
			<?php echo $form->dropDownList($model,'mk_ksnf',Emapp::$arrjsjksnf,$htmlOptions=array ('empty'=>"请选择证书报考时间",'name'=>"mk_ksnf",'class'=>"input-large pull-left")); ?>
			<p for="mk_ksnf" class="error"><?=isset($model->errors['mk_ksnf'])?join('',$model->errors['mk_ksnf']):""?></p>
		</div>
	</div>
	<div class="control-group mkxxdiv" style="<?=$e_trip[4]==1||$e_trip[2]==1?"":"display:none";?>">
		<label class="control-label" for="verify">免考证书报考省分</label>
		<div class="controls">
			<?php echo $form->dropDownList($model,'mk_ksadder',Emapp::$arrmkadder,$htmlOptions=array ('empty'=>"请选择证书报考省份",'name'=>"mk_ksadder",'class'=>"input-large pull-left")); ?>
			<p for="mk_ksadder" class="error" style=""><?=isset($model->errors['mk_ksadder'])?join('',$model->errors['mk_ksadder']):""?></p>
		</div>
	</div>
    <div class="control-group mkxxdiv" style="<?=$e_trip[4]==1||$e_trip[2]==1?"":"display:none";?>">
		<label class="control-label" for="verify">免考证书类别</label>
		<div class="controls">
			<?php echo $form->dropDownList($model,'mk_zstype',Emapp::$arrzstype,$htmlOptions=array ('empty'=>"请选择证书",'name'=>"mk_zstype",'class'=>"input-large pull-left")); ?>
			<p for="mk_zstype" class="error" style=""><?=isset($model->errors['mk_zstype'])?join('',$model->errors['mk_zstype']):""?></p>
		</div>
	</div>
	<div class="control-group mkxxdiv" style="<?=$e_trip[4]==1||$e_trip[2]==1?"":"display:none";?>">
		<label class="control-label" for="">免考准考证号 </label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_zkznum',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"mk_zkznum")); ?>
		</div>
	</div>
	<div class="control-group mkxxdiv" style="<?=$e_trip[4]==1||$e_trip[2]==1?"":"display:none";?>">
		<label class="control-label" for="">免考证件号 </label>
		<div class="controls">
			<?php echo $form->textField($model,'mk_zjnum',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"mk_zjnum")); ?>
			<p class="error pull-left pl8">必填!</p>
		</div>
	</div>


</div>
</td>
</tr>
<tr>
	<td>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="addsubmit" value="add"><?=!$model->isNewRecord?"修改":"申请"?></button>&nbsp;
			<button type="reset" class="btn">重新填写</button>
		</div>
	</td>
</tr>
</tbody>
</table>
<?php $this->endWidget(); ?>
<script>
function checkdiv(obj){
	if(obj.value==6){
		if($(obj).attr("checked")){
			$(".sfcardimgdiv").show();
		}else{
			$(".sfcardimgdiv").hide();
		}
		}else if(obj.value==2||obj.value==4){
		if($(obj).attr("checked")){
		$(".mkxxdiv").show();
		}else{
		$(".mkxxdiv").hide();
		}
	}
}

$(document).ready(function() {
$(".controls").find("input").change(function(){
if($(this).parent('div.controls').find("p.pl8").css("display")=="block"){
$(this).parent('div.controls').find("p.pl8").hide()
}
})
$("a.btn-success").mouseover(function(){
$(this).next("img").show();

}).mouseout(function(){
$(this).next("img").hide();

})

jQuery.validator.addMethod("ckmk", function(value, element) {
var aa=false;
var chk_value =[];  
var obj=document.getElementsByName('test');
$('input[name="mk_reason[]"]:checked').each(function(){
if($(this).val()==6){
aa=true;
}
});  
if(aa){
if(!value)return false;
}
return true;
});

jQuery.validator.addMethod("ckmk1", function(value, element) {
var aa=false;
var chk_value =[];  
var obj=document.getElementsByName('test');
$('input[name="mk_reason[]"]:checked').each(function(){
if($(this).val()==2||$(this).val()==4){
aa=true;
}
});  
if(aa){
if(!value)return false;
}
return true;
});


jQuery.validator.addMethod("isMobile", function(value, element) { 
var length = value.length; 
var mobile = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/; 
return this.optional(element) || (length == 11 && mobile.test(value)); 
}, "请正确填写您的手机号码"); 

$("#mk_form").validate({
autoCreateRanges:true	,
errorClass: "error",
errorElement: "p",
rules: {
mk_cardtype:'required',
mk_cardnumber:{
//remote: "/user/ismkuser/id/<?=$model->mk_id?>",
required: true,
minlength: 6,
maxlength: 20
},
mk_xh: {
required: true,
number:true,
maxlength: 12
},				
mk_sname: 'required',
mk_sex:'required',
mk_ethnic:'required',
mk_sdgx: {
required:true
},
mk_specialty: {
required: true
},
mk_moblie: {                
required:true,
number:true,
isMobile:true,
minlength:11,					
maxlength: 11
},
mk_subject: {
required: true
},
"mk_reason[]": {
required: true
}, 
mk_ksnf:{
ckmk1:true
},
mk_ksadder:{
ckmk1:true
},
mk_zstype:{
ckmk1:true
},
mk_zjnum:{
ckmk1:true
},
mk_cardimg:{
ckmk:   true
}
},
messages: {
mk_cardtype:{required:'请选择证件类型'},
mk_cardnumber: {
//remote: "已有学员",
required: "请输入证件号!",
minlength: "不能少于6个字符",					
maxlength: "不能大于20个字符"
},
mk_xh: {
required: '请输入学号',
number:'必须是数字',
maxlength: "不能大于12个字符"
},
mk_sname: '请输入学员姓名',
mk_sex:'请选择性别',
mk_ethnic:'请选择民族',

mk_sdgx: {
required: '请输入就读试点高校'
},
mk_specialty: {
required: '请选择专业'
},
mk_moblie: {
required:'请输入手机号码',
number:'必须是数字',
minlength: "不能少于11个字符",		
maxlength: "不能大于11个字符"
},
mk_subject:{
required:'请选择免考科目',
},
"mk_reason[]":{
required:'请选择免考原因'
},
mk_ksnf:{
ckmk1:'请选择证书报考时间'
},
mk_ksadder:{
ckmk1:'请选择报考省分'
},
mk_zstype:{
ckmk1:'请选择证书类别'
},
mk_zjnum:{
ckmk1:'请填写证件号'
},
mk_cardimg:{
ckmk:   '请上传身份证照片'
}
}
});

});
//checkselect($("#mk_subject").val());
</script>