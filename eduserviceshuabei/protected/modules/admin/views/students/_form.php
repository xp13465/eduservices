<?php
if(!isset($_GET['type'])){
$_GET['type']=1;
}
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jsdate/WdatePicker.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
$id=Yii::app()->user->id;
$usermodel=User::model()->getUserInfoById($id);
$authArr= unserialize($usermodel->user_authorize);
$inputType='readonly';
$other=false;
if(Yii::app()->user->role=='4'||(isset($authArr['diyinsert'])&&$authArr['diyinsert']==1)){
    $inputType='';
}
if(isset($_GET['type'])&&$_GET['type']=='other'){
    $inputType='';
    $other=true; 
}
if(!$other){ ?>
<?php if($_GET['type']==1){?>
    <div class='hide'>
    <OBJECT
          classid="clsid:F1317711-6BDE-4658-ABAA-39E31D3704D3"
          codebase="SDRdCard.cab#version=1,3,5,0"
          width=0
          height=0
          align=center
          hspace=0
          vspace=0
          id=idcard
          name=rdcard >
    </OBJECT>
    </div>
<?php }else{?>
        <OBJECT Name="GT2ICROCX" width="0" height="0"  
            CLASSID="CLSID:220C3AD1-5E9D-4B06-870F-E34662E2DFEA"
            CODEBASE="IdrOcx.cab#version=1,0,1,2">			
        </OBJECT>
        <SCRIPT LANGUAGE=javascript FOR=GT2ICROCX EVENT=GetData>//设置回调函数
            MyGetData()
        </SCRIPT>

        <SCRIPT LANGUAGE=javascript FOR=GT2ICROCX EVENT=GetErrMsg>//设置回调函数
            MyGetErrMsg()
        </SCRIPT>
<?php }
}
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'students-form',
	"htmlOptions"=>array('class'=>'form-horizontal userform'),
	'enableAjaxValidation'=>false,
)); ?>
<?php  //echo $form->errorSummary($model); ?>


<fieldset>
<table class="table table-bordered">
  <tbody>
  	<tr>
      <td >
	  <?php if($model->s_status==3){?>
		<p class="pull-left lineh30 margin0  marl10 " ><b>录入员：</b>	
		<span class="blcolor1"><?=User::model()->getUserName($model->s_addid)?></span>
		<span class='hcolor marl5'><?=date("Y-m-d H:i:s",$model->s_addtime)?></span>
		<b>审核状态：</b>
		<span class="blcolor1"><?=@Students::$status[$model->s_status]?></span>
		
			<b class='marl5'>审核员：</b><span class="blcolor1"><?=User::model()->getUserName($model->s_statusid)?></span>
			
			<span class='hcolor marl5'><?=date("Y-m-d H:i:s",$model->s_statustime)?></span>
	 
		</p>
			<?php }?>
          <div class="btn-group pull-right marr10">
          <?php /*?>
            <a class="btn btn-inverse" href="javascript:void(0)" onclick="return checkqh('<?=isset($_GET['type'])&&$_GET['type']==1?2:1?>')" >
                <i class="icon-share-alt icon-white"></i> <?=isset($_GET['type'])&&$_GET['type']=='1'?"国腾读卡器":"神思读卡器"?>身份证录入
            </a>
            <a class="btn btn-inverse" href="javascript:void(0)" onclick="return checkqh('<?=isset($_GET['type'])&&$_GET['type']=='other'?"2":"other"?>')" >
                <i class="icon-share-alt icon-white"></i><?=isset($_GET['type'])&&$_GET['type']=='other'?"国腾读卡器身份证录入":"其他证件手动录入"?>
            </a>
            <?php */?>
            <a title="一栏显示" class="btn btnbg1"  onclick="unbindunbeforunload();showList(1,this)" href="javascript:bindunbeforunload()" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"":"background:#ddd"?>'><i class="icon-align-justify"></i></a>
			<a title="二栏显示"  class="btn btnbg2" onclick="unbindunbeforunload();showList(2,this)" href="javascript:bindunbeforunload()" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"background:#ddd":""?>'><i class=" icon-th-large"></i></a>
		</div>
      </td>
    </tr>
	<?php if($model->s_status==3){?>
	<tr>
      <td>
		<dl class='dl-beizhu margin0'>
			<dt><b class='marl5'>审核备注:</b></dt>
			<dd><?=nl2br($model->s_statusabout)?></dd>
		</dl>
      </td>
    </tr>
	<?php }?>
    <?php if(!$other){?>
	<tr>
	<td>
    <?php if(isset($_GET['type'])&&$_GET['type']==1){?>
        <input type="button" value="神思读卡器读取身份证信息" name="handread" class='btn ' onclick="handread_onclick()" >
    <?php }else if(isset($_GET['type'])&&$_GET['type']==2){?>
        <input type="button" value="国腾读卡器读取身份证信息" name="handread" class='btn ' onclick="StartRead()" >
    <?php }?>
	<span id='TSmessage'>把身份证放在感应区读卡，点击《读取身份证信息》，为每点击一次读一张卡。</span>
	</td>
	</tr>
    <?php }?>
    <tr>
      <td class=" <?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"linebg":"nolinebg"?>" width="100%">

<div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
<?php if(Yii::app()->user->role=='4'){?>
<div class="control-group">
<label class="control-label" for="verify">审核状态 </label>

<div class="controls " id='s_status'>
<div class='pull-left'>
<label class="radio inline" style='width:40px'>
<input type="radio" name="s_status" id="s_status_0" <?=$model->s_status=="2"?"checked":""?> value="2">通过
</label>
<label class="radio inline" style='width:60px'>
<input type="radio" name="s_status" id="s_status_1" <?=$model->s_status=="1"?"checked":""?> value="1">待审核
</label>
</div>
<p class="error  pull-left pl8">待审核后重审!</p>
<p for="s_status" htmlfor='s_status' class="error" style=""><?=isset($model->errors['s_status'])?join('',$model->errors['s_status']):""?></p>

</div>
	
    
</div> 

<div class="control-group">
<label class="control-label" for="s_statusabout">审核备注修改 </label>
<div class="controls">
<?php echo $form->textAREA($model,'s_statusabout',array('class'=>'input-large pull-left','maxlength'=>200,'name'=>"s_statusabout",'style'=>"width:400px;height:100px")); ?>
<p class="error  pull-left pl8">监管中心才有此权限!</p>
<p for="s_statusabout" class="error" style=""><?=isset($model->errors['s_statusabout'])?join('',$model->errors['s_statusabout']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_rpc">证件类型分配 </label>
<div class="controls">
<?php echo $form->dropDownList($model,'s_zjtype',Students::$zjtype,$htmlOptions=array ('name'=>"s_zjtype",'class'=>"pull-left")); ?>
<p class="error  pull-left pl8">监管中心才有此权限!</p>
<p for="s_zjtype" class="error" style=""><?=isset($model->errors['s_zjtype'])?join('',$model->errors['s_zjtype']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="s_rpc">入学批次 </label>
<div class="controls">
<?php echo $form->textField($model,'s_rpc',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_rpc")); ?>
<p class="error  pull-left pl8">监管中心才有此权限!</p>
<p for="s_rpc" class="error" style=""><?=isset($model->errors['s_rpc'])?join('',$model->errors['s_rpc']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="s_rpc">入学考批次 </label>
<div class="controls">
<?php 
$piciArr=Pici::model()->getAllPC(false);
arsort($piciArr);
echo $form->dropDownList($model,'s_pc',$piciArr,$htmlOptions=array ('empty'=>"选择入学考批次",'name'=>"s_pc",'class'=>"pull-left")); ?>
<p class="error  pull-left pl8">监管中心才有此权限!</p>
<p for="s_pc" class="error" style=""><?=isset($model->errors['s_pc'])?join('',$model->errors['s_pc']):""?></p>
</div>
</div>

<?php }?>

<div class="control-group">
<label class="control-label" for="s_name">姓名 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_name',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_name",'readonly'=>$inputType)); ?>
<p class="error  pull-left pl8">姓名必须为汉字!</p>
<p for="s_name" class="error" style=""><?=isset($model->errors['s_name'])?join('',$model->errors['s_name']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_sex">性别 <span class="rcolor">*</span></label>
<div class="controls " id='s_sex'>
<div class='pull-left'>
<?php // echo $form->radioButtonList($model,'s_sex',Students::$sex,array('name'=>"s_sex",'template'=>'{input}{label}','separator'=>'&nbsp;')); ?>

<label class="radio inline">
<input type="radio" name="s_sex" id="s_sex_0" <?=$model->s_sex=="1"?"checked":""?>  <?=$inputType?"readonly='readonly' onclick='return false' ":""?>    value="1">男
</label>
<label class="radio inline">
<input type="radio" name="s_sex" id="s_sex_1" <?=$model->s_sex=="0"?"checked":""?>  <?=$inputType?"readonly='readonly' onclick='return false' ":""?>  value="0">女
</label>
</div>
<p for="s_sex" class="error  pull-left" style=""><?=isset($model->errors['s_sex'])?join('',$model->errors['s_sex']):""?></p>

</div>

</div>
<div class="control-group">

<label class="control-label" for="s_headerimg">个人照片 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->hiddenField($model,'s_headerimg',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_headerimg")); ?>	
<div class="pull-left">
<?php if(!$inputType){?>
<a class="btn btn-mini btn-danger 	"  id='headerimgeditbtn' onclick="openUploadZP('s_headerimg','headerimg','headerimgshowbtn')">照片<?=!$model->s_headerimg?"上传":"修改"?></a>
<a class="btn btn-mini btn-success" style='<?=$model->s_headerimg?"":"display:none"?>' id="headerimgshowbtn">照片预览</a>
<?php }?>
<img src='<?=$model->s_headerimg?>' class='hide showimg' style='<?=$model->s_headerimg?"display:block;position:relative":""?>' id="headerimg">
</div>
<p for="s_headerimg" class="error" style=""><?=isset($model->errors['s_headerimg'])?join('',$model->errors['s_headerimg']):""?></p>

<p class="readcardmsg pull-left pl8" style="">
<?php if(!$inputType){?>
个人照片尺寸102*126，10k以下!
<?php }else{?>
读卡器自动提取...
<?php }?>
</p>

</div>
</div>
<div class="control-group hide">
<div class="controls">
<img src="../img/photo.jpg" />
</div>
</div>

<div class="control-group">
<label class="control-label" for="s_credentialstype">证件类型 <span class="rcolor">*</span></label>
<div class="controls">
<?php
if($inputType){
    echo $form->dropDownList($model,'s_credentialstype',array("1"=>"身份证"),$htmlOptions=array ('name'=>"s_credentialstype", 'class'=>"pull-left"));
}else{
    $StudentType=Students::$credentialstype;
    if($other){
        unset($StudentType[1]);
    }
    echo $form->dropDownList($model,'s_credentialstype',$StudentType,$htmlOptions=array ('name'=>"s_credentialstype","empty"=>"请选择证件类型", 'class'=>"pull-left"));
}
 ?>
<p for="s_credentialstype" class="error" style=""><?=isset($model->errors['s_credentialstype'])?join('',$model->errors['s_credentialstype']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_credentialsnumber">证件号码 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_credentialsnumber',array('readonly'=>$inputType,'name'=>"s_credentialsnumber",'class'=>'input-large pull-left','maxlength'=>100,"onfocus"=>"checkSFCARD()",'onchange'=>"checksfcode(this)")); ?>
<p for="s_credentialsnumber" class="error" style=""><?=isset($model->errors['s_credentialsnumber'])?join('',$model->errors['s_credentialsnumber']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_credentialsimg1">证件扫描件上传(正面) <span class="rcolor">*</span></label>
<div class="controls ">
<?php echo $form->hiddenField($model,'s_credentialsimg1',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_credentialsimg1")); ?>
<div class="pull-left">
<?php if(!$inputType){?>
<a class="btn btn-mini btn-danger 	"  onclick="openUploadSF('s_credentialsimg1','credentialsimg1','credentialsimg1btn')">证件<?=!$model->s_credentialsimg1?"上传":"修改"?></a>&nbsp;
<a class="btn btn-mini btn-success" style='<?=$model->s_credentialsimg1?"":"display:none"?>' id="credentialsimg1btn">证件正面预览</a>
<?php }?>
<img src='<?=$model->s_credentialsimg1?>' class='hide showimg' style='<?=$model->s_credentialsimg1?"display:block;position:relative":""?>' id="credentialsimg1">

</div>

<p class="readcardmsg pull-left pl8" style="">
<?php if(!$inputType){?>
身份证扫描件20K以下
<?php }else{?>
读卡器自动提取...
<?php }?>


</p>
<p for="s_credentialsimg1" class="error" style=""><?=isset($model->errors['s_credentialsimg1'])?join('',$model->errors['s_credentialsimg1']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_credentialsimg2">证件扫描件上传(反面) <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->hiddenField($model,'s_credentialsimg2',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_credentialsimg2")); ?>
<div class="pull-left">
<?php if(!$inputType){?>
<a class="btn btn-mini btn-danger 	"  onclick="openUploadSF('s_credentialsimg2','credentialsimg2','credentialsimg2btn')">证件<?=!$model->s_credentialsimg2?"上传":"修改"?></a>&nbsp;
<a class="btn btn-mini btn-success" style='<?=$model->s_credentialsimg2?"":"display:none"?>' id="credentialsimg2btn">证件正面预览</a>
<?php }?>
<img src='<?=$model->s_credentialsimg2?>' class='hide showimg' style='<?=$model->s_credentialsimg2?"display:block;position:relative":""?>' id="credentialsimg2">
</div>

<p class="readcardmsg pull-left pl8" style="">
<?php if(!$inputType){?>
身份证扫描件20K以下
<?php }else{?>
读卡器自动提取...
<?php }?>

</p>
<p for="s_credentialsimg2" class="error" style=""><?=isset($model->errors['s_credentialsimg2'])?join('',$model->errors['s_credentialsimg2']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_birthdate">出生日期 <span class="rcolor">*</span></label>
<div class="controls">
	<div class="input-prepend pull-left">
      <span class="add-on pointer" onclick='$("#s_birthdate").focus()'><i class="icon-calendar" ></i></span>
	  <?php 
        if($inputType){
      echo $form->textField($model,'s_birthdate',array('name'=>"s_birthdate",'class'=>'width1 input-large','maxlength'=>100,'readonly'=>$inputType));
        }else{
            echo $form->textField($model,'s_birthdate',array('name'=>"s_birthdate",'class'=>'width1 input-large','maxlength'=>100,"onclick"=>"WdatePicker()"));
        }
      ?>
    </div>
<p for="s_birthdate" class="error" style=""><?=isset($model->errors['s_birthdate'])?join('',$model->errors['s_birthdate']):""?></p>

<p class="error  pull-left pl8">填写的时候请按照19800101的格式填写!</p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="s_birthaddress">出生地 <span class="rcolor">*</span></label>
<div class="controls">
 <?php echo $form->textField($model,'s_birthaddress',array('name'=>"s_birthaddress",'class'=>'input-large pull-left','maxlength'=>200,'readonly'=>$inputType)); ?>
<p for="s_birthaddress" class="error" style=""><?=isset($model->errors['s_birthaddress'])?join('',$model->errors['s_birthaddress']):""?></p>

 <p class="error  pull-left pl8">出生地必须为汉字!</p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="s_nationality">民族 <span class="rcolor">*</span></label>
<div class="controls">
<?php 
$model->s_nationality=$model->s_nationality?$model->s_nationality:"1"?>
<?php echo $form->dropDownList($model,'s_nationality',Lookup::model()->getClassInfo("nationality"),$htmlOptions=array ('name'=>"s_nationality","empty"=>"请选择民族", 'class'=>"pull-left")); ?>
<p for="s_nationality" class="error" style=""><?=isset($model->errors['s_nationality'])?join('',$model->errors['s_nationality']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_politicalstatus">政治面貌 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->dropDownList($model,'s_politicalstatus',Lookup::model()->getClassInfo("politicalstatus"),$htmlOptions=array ('name'=>"s_politicalstatus","empty"=>"请选择政治面貌", 'class'=>"pull-left")); ?>
<p for="s_politicalstatus" class="error" style=""><?=isset($model->errors['s_politicalstatus'])?join('',$model->errors['s_politicalstatus']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_highesteducation">入学前最高学历 <span class="rcolor">*</span></label>
<div class="controls ">
<div class='pull-left'>
<?php echo CHtml::activeDropDownList($model, 's_highesteducation', Students::$highesteducation, array(
		"name"=>"s_highesteducation",
		'empty'=>'请选择入学前最高学历',
		'class'=>"pull-left",
		'ajax'=>array(

                  'type'=>'GET',

                  'url'=>CController::createUrl('admin/getbk'),

                  'update'=>'#s_baokaocengci',

                  'data'=>array('mid'=>"js:this.value",'typeid'=>1)

        ))); ?>
</div>
<p for="s_highesteducation" class="error pull-left" style=""><?=isset($model->errors['s_highesteducation'])?join('',$model->errors['s_highesteducation']):""?></p>

</div>

</div>	
<div class="control-group">
<label class="control-label" for="s_phone">手机 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_phone',array('name'=>"s_phone",'class'=>'input-large pull-left','maxlength'=>100)); ?>
<p for="s_phone" class="error" style=""><?=isset($model->errors['s_phone'])?join('',$model->errors['s_phone']):""?></p>

<p class="error  pull-left pl8">填写数字：11位!</p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="s_email">邮箱 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_email',array('name'=>"s_email",'class'=>'input-large pull-left','maxlength'=>100)); ?>
<p for="s_email" class="error" style=""><?=isset($model->errors['s_email'])?join('',$model->errors['s_email']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_baokaocengci">报考层次 <span class="rcolor">*</span></label>
<div class="controls">
<?php 
$tmp=array();
if($model->s_highesteducation){
	if($model->s_highesteducation==1)$tmp=Lookup::model()->getClassInfo('professionallevel','3');
	else$tmp=Lookup::model()->getClassInfo('professionallevel');
} 
echo CHtml::activeDropDownList($model, 's_baokaocengci', $tmp, array(
					"name"=>"s_baokaocengci",
					'empty'=>'选择最高学历加载层次...',
					'class'=>"pull-left",
					'ajax'=>array(
					  'type'=>'GET',

					  'url'=>CController::createUrl('admin/getbk'),

					  'update'=>'#s_baokaozhuanye',

					  'data'=>array('mid'=>"js:this.value",'typeid'=>2)
              )));?>
<p for="s_baokaocengci" class="error" style=""><?=isset($model->errors['s_baokaocengci'])?join('',$model->errors['s_baokaocengci']):""?></p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="s_baokaozhuanye">报考专业 <span class="rcolor">*</span></label>
<div class="controls">
 <?php
$tmp=array();
if($model->s_baokaocengci){
	$tmp=	Professional::model()->getKCInfo($model->s_baokaocengci);
}
 echo CHtml::activeDropDownList($model, 's_baokaozhuanye', $tmp, array(
			'empty'=>'选择层次加载专业...',
			"name"=>"s_baokaozhuanye",
			'class'=>"pull-left"
	  )); ?>
<p for="s_baokaozhuanye" class="error" style=""><?=isset($model->errors['s_baokaozhuanye'])?join('',$model->errors['s_baokaozhuanye']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_zhiyezhuangkuang">职业状况 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->dropDownList($model,'s_zhiyezhuangkuang',Students::$profession,$htmlOptions=array ('name'=>"s_zhiyezhuangkuang","empty"=>"请选择职业状况", 'class'=>"pull-left")); ?>
<p for="s_zhiyezhuangkuang" class="error" style=""><?=isset($model->errors['s_zhiyezhuangkuang'])?join('',$model->errors['s_zhiyezhuangkuang']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_hunyinzhuangkuang ">婚姻状况<span class="rcolor">*</span> </label>
<div class="controls " id='s_hunyinzhuangkuang'>	
<div class='pull-left '>
<?php //echo $form->radioButtonList($model,'s_hunyinzhuangkuang',Students::$marital,array('name'=>"s_hunyinzhuangkuang",'template'=>'<label class="pull-left radio inline">{input}{label}</label>','separator'=>'&nbsp;')); ?>
<label class="radio inline" style='width: 30px;'>
<input type="radio" name="s_hunyinzhuangkuang" id="s_hunyinzhuangkuang_0" <?=$model->s_hunyinzhuangkuang=="1"?"checked":""?> value="1">已婚
</label>
<label class="radio inline" style='width: 30px;'>
<input type="radio" name="s_hunyinzhuangkuang" id="s_hunyinzhuangkuang_1" <?=$model->s_hunyinzhuangkuang=="2"?"checked":""?> value="2">未婚
</label>
</div>
<p for="s_hunyinzhuangkuang" class="error  pull-left" style=""><?=isset($model->errors['s_hunyinzhuangkuang'])?join('',$model->errors['s_hunyinzhuangkuang']):""?></p>

</div>

</div>

</div>
<div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">

<div class="control-group">
<label class="control-label" for="s_familyaddress">家庭地址 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_familyaddress',array('class'=>'input-large pull-left','maxlength'=>60,'name'=>"s_familyaddress")); ?>
<p for="s_familyaddress" class="error" style=""><?=isset($model->errors['s_familyaddress'])?join('',$model->errors['s_familyaddress']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_gongzuodanwei">工作单位 </label>
<div class="controls">
<?php echo $form->textField($model,'s_gongzuodanwei',array('class'=>'input-large pull-left','maxlength'=>60,'name'=>"s_gongzuodanwei")); ?>
<p for="s_gongzuodanwei" class="error" style=""><?=isset($model->errors['s_gongzuodanwei'])?join('',$model->errors['s_gongzuodanwei']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_youbian">邮编 </label>
<div class="controls">
<?php echo $form->textField($model,'s_youbian',array('class'=>'input-large pull-left','maxlength'=>20,'name'=>"s_youbian")); ?>
<p for="s_youbian" class="error" style=""><?=isset($model->errors['s_youbian'])?join('',$model->errors['s_youbian']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_contactaddress">通讯地址 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_contactaddress',array('class'=>'input-large pull-left','maxlength'=>60,'name'=>"s_contactaddress")); ?>
<p for="s_contactaddress" class="error" style=""><?=isset($model->errors['s_contactaddress'])?join('',$model->errors['s_contactaddress']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_tel">联系电话 </label>
<div class="controls">
<?php echo $form->textField($model,'s_tel',array('class'=>'input-large pull-left','maxlength'=>50,'name'=>"s_tel")); ?>
<p for="s_tel" class="error" style=""><?=isset($model->errors['s_tel'])?join('',$model->errors['s_tel']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_sfromaddress">生源地 <span class="rcolor">*</span></label>
<div class="controls">

<?php echo $form->dropDownList($model,'s_sfromaddress',Lookup::model()->getClassInfo("studentsfrom"),$htmlOptions=array ('name'=>"s_sfromaddress","empty"=>"请选择生源地", 'class'=>"pull-left")); ?>
<p for="s_sfromaddress" class="error" style=""><?=isset($model->errors['s_sfromaddress'])?join('',$model->errors['s_sfromaddress']):""?></p>

</div>
</div>
<div class="control-group">
<label class="control-label" for="s_sfromtype">生源状况 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->dropDownList($model,'s_sfromtype',Lookup::model()->getClassInfo("studentsfromstatus"),$htmlOptions=array ('name'=>"s_sfromtype", 'class'=>"pull-left")); ?>
<p for="s_sfromtype" class="error" style=""><?=isset($model->errors['s_sfromtype'])?join('',$model->errors['s_sfromtype']):""?></p>


</div>
</div>
<div class="control-group">
<label class="control-label" for="s_cjgztime">参加工作时间 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_cjgztime',array('class'=>'input-large pull-left','maxlength'=>50,'name'=>"s_cjgztime")); ?>
<p for="s_cjgztime" class="error" style=""><?=isset($model->errors['s_cjgztime'])?join('',$model->errors['s_cjgztime']):""?></p>

<p class="error pull-left pl8">填写的时候请按照1980-01的格式填写!</p>
</div>
</div>
<div class="control-group oldshoworhide hide">
    <label class="control-label" for="s_oldschool">原毕业院校 <span class="rcolor">*</span></label>
  <div class="controls">
    <div class="input-prepend pull-left">
      <span class="add-on pointer" onclick='openSearchschool()'><i class="icon-zoom-in"></i></span>
	  <?php
                $this->widget('CAutoComplete',
                        array(
                        "id"=>"s_oldschool",
                        'name'=>'s_oldschool',
						"value"=>$model->s_oldschool,
                        'url'=>array('admin/ajaxautocomplete'),
                        'max'=>8,//显示最大数
                        'minChars'=>1,//最小输入多少开始匹配
                        'delay'=>500, //两次按键间隔小于此值，则启动等待
                        'scrollHeight'=>200,
                        "extraParams"=>array("type"=>"1"),//表示是楼盘、商业广场还是小区
                        'htmlOptions'=>array("class"=>"width1 input-large",'onblur'=>'selectCode(this)'),
						// 'resultsClass'=>"bh_results"
                ));
                ?>
   </div>
   <p for="s_oldschool" class="error" style=""><?=isset($model->errors['s_oldschool'])?join('',$model->errors['s_oldschool']):""?></p>
   <p class="error pull-left pl8">可通过左侧按钮搜索院校沿革</p>
  </div>
</div>
<div class="control-group  oldshoworhide hide">
<label class="control-label" for="s_oldschoolcode">原毕业学校代码 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_oldschoolcode',array('class'=>'input-large pull-left','maxlength'=>50,'name'=>"s_oldschoolcode")); ?>
 <p for="s_oldschoolcode" class="error" style=""><?=isset($model->errors['s_oldschoolcode'])?join('',$model->errors['s_oldschoolcode']):""?></p>
 <p class="error pull-left pl8">自动加载，空代表服务器无匹配院校</p>
</div>
</div>
<div class="control-group oldshoworhide hide">
<label class="control-label" for="s_oldzhuanye">原毕业专业 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_oldzhuanye',array('class'=>'input-large pull-left','maxlength'=>50,'name'=>"s_oldzhuanye")); ?>
 <p for="s_oldzhuanye" class="error" style=""><?=isset($model->errors['s_oldzhuanye'])?join('',$model->errors['s_oldzhuanye']):""?></p>
 
</div>
</div>
<div class="control-group oldshoworhide hide">
<label class="control-label" for="s_oldtime">原毕业时间 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_oldtime',array('class'=>'input-large pull-left','maxlength'=>50,'name'=>"s_oldtime")); ?>
 <p for="s_oldtime" class="error" style=""><?=isset($model->errors['s_oldtime'])?join('',$model->errors['s_oldtime']):""?></p>
 
<p class="error pull-left pl8">填写的时候请按照1980-01的格式填写!</p>
</div>

</div>
<div class="control-group oldshoworhide hide">
<label class="control-label" for="s_oldimgnumber">原毕业证书编号 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_oldimgnumber',array('class'=>'input-large pull-left','maxlength'=>50,'name'=>"s_oldimgnumber")); ?>
 <p for="s_oldimgnumber" class="error" style=""><?=isset($model->errors['s_oldimgnumber'])?join('',$model->errors['s_oldimgnumber']):""?></p>
 
</div>
</div>

<div class="control-group ">
<label class="control-label" for="s_oldimg">毕业证书扫描件 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->hiddenField($model,'s_oldimg',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_oldimg")); ?>
<div class="pull-left">
<a class="btn btn-mini btn-danger 	"  onclick="openUploadZJ('s_oldimg','oldimg','oldimgbtn')">毕业证书扫描件<?=!$model->s_oldimg?"上传":"修改"?></a>&nbsp;
<a class="btn btn-mini btn-success" style='<?=$model->s_oldimg?"":"display:none"?>'id="oldimgbtn">毕业证书扫描件预览</a>
<img src='<?=$model->s_oldimg?>' class='hide showimg' style='width:500px;' id="oldimg">

</div>
 <p for="s_oldimg" class="error" style=""><?=isset($model->errors['s_oldimg'])?join('',$model->errors['s_oldimg']):""?></p>
<p class="error  pull-left pl8" style='<?=isset($model->errors['s_zsbzm'])?"display:none":""?>'>毕业证书扫描件250K以下!</p>
</div>
</div>
<div class="control-group oldshoworhide1 hide">
<label class="control-label" for="s_zsbzm">专升本学历证明 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_zsbzm',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_zsbzm","class"=>"hide")); ?>
<div class="pull-left">
<a class="btn btn-mini btn-danger 	"  onclick="openUploadZJ('s_zsbzm','zsbzm','zsbzmbtn')">学历证明扫描件<?=!$model->s_zsbzm?"上传":"修改"?></a>&nbsp;
<a class="btn btn-mini btn-success" style='<?=$model->s_zsbzm?"":"display:none"?>'id="zsbzmbtn">学历证明扫描件预览</a>
<img src='<?=$model->s_zsbzm?>' class='hide showimg' style='width:500px;' id="zsbzm">

</div>
<p for="s_zsbzm" class="error" style=""><?=isset($model->errors['s_zsbzm'])?join('',$model->errors['s_zsbzm']):""?></p>
<p class="error  pull-left pl8" style='<?=isset($model->errors['s_zsbzm'])?"display:none":""?>'>学历证明扫描件250K以下!</p>
</div>
</div>
<div class="control-group ">
<label class="control-label" for="s_enrollment">入学方式 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->dropDownList($model,'s_enrollment',Students::$enrollment,$htmlOptions=array ('name'=>"s_enrollment",'class'=>"pull-left")); ?>
<p for="s_enrollment" class="error" style=""><?=isset($model->errors['s_enrollment'])?join('',$model->errors['s_enrollment']):""?></p>
</div>
</div>
<div class="control-group hide">
<label class="control-label" for="s_study">学习类型 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->dropDownList($model,'s_study',Students::$study,$htmlOptions=array ('name'=>"s_study",'class'=>"pull-left")); ?>
<p for="s_study" class="error" style=""><?=isset($model->errors['s_study'])?join('',$model->errors['s_study']):""?></p>

</div>
</div>
<div class="control-group">	
<label class="control-label" for="s_file">其他证明材料 </label>
<div class="controls">
<div class="pull-left">
<?php echo $form->textField($model,'s_file',array('readonly'=>'readonly',	'class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_file")); ?>

<a class="btn btn-mini btn-danger"  onclick="openUpload('s_file')">材料<?=!$model->s_file?"上传":"修改"?></a>
<a class="btn btn-mini btn-success"  onclick="if($('#s_file').val()){　window.open ($('#s_file').val()) }else{alert('请先上传')}">查看</a>
</div>
<p for="s_file" class="error" style=""><?=isset($model->errors['s_file'])?join('',$model->errors['s_file']):""?></p>

<p class=" pull-left pl8">材料格式必须为zip、rar、jpg、gif、png，且1M以下!</p>
</div>
</div>
</div>

      </td>
    </tr>
    <tr>
      <td>
<div class="form-actions">
<button type="submit" class="btn btn-primary"  name="addsubmit" value="add" onclick='unbindunbeforunload()' ><?=!$model->isNewRecord?$model->s_statustime?"重新提交":"修改":"添加"?>数据<?=$model->s_isdel==2?"并恢复到学员列表":""?></button>&nbsp;
</div>
      </td>
    </tr>
  </tbody>
</table>
</fieldset>

<?php $this->endWidget(); ?>	
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/studentinput.js",CClientScript::POS_BEGIN);?>
<script>
    $(document).ready(function() {
        bindunbeforunload()	
        <?php if(in_array($model->s_highesteducation,array(2,3,4,5))){ ?>
        $(".oldshoworhide").show()
        <?php }?>
        <?php if(in_array($model->s_baokaocengci,array(2))){ ?>
        $(".oldshoworhide1").show()
        <?php }?>
	// 自定义手机号码验证       
        jQuery.validator.addMethod("isMobile", function(value, element) {       
        var length = value.length;          
        var mobile = /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;   
        return this.optional(element) || (length == 11 && mobile.test(value));       
        }, "请正确填写您的手机号码"); 
        $("#students-form").validate({
            // debug: true,
            autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
                s_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 20
                    // remote: "/user/isused"
                },
                s_sex: 'required',
                s_credentialstype: 'required',
                s_credentialsnumber:{
                    remote: "/user/isused/id/<?=$model->s_id?>",
                    required:true
                },
                s_birthdate: {
                    required:true,
                    remote: "/user/isused/",
                    cndate:true
                },
                s_birthaddress: {
                    required:true
                    // cnCharset:true,
                    // maxlength: 20
                },
                s_nationality: 'required',
                s_politicalstatus: 'required',
                s_highesteducation: 'required',
                s_phone: {
                remote: "/user/isused/id/<?=$model->s_id?>",
                required:true,
                isMobile:true
                },
                s_email:{ 
                    required:true,
                    email:true
                },
                s_baokaocengci: 'required',
                s_baokaozhuanye: 'required',
                s_zhiyezhuangkuang: 'required',
                s_hunyinzhuangkuang: 'required',
                s_sfromaddress: 'required',
                s_cjgztime: {
                    required:true,
                    cndatenoday:true
                },
                s_oldschool: 'required',
                s_oldzhuanye: 'required',
                s_zsbzm: 'required',
                s_oldtime: {
                    required:true,
                    cndatenoday:true
                },
                s_oldimg: 'required',
                s_oldimgnumber: 'required',
                s_headerimg:'required',
                s_credentialsimg1:'required',
                s_contactaddress:'required',
                s_familyaddress:'required',
                s_oldschoolcode: {
                    chkoldcode:true
                },
                s_credentialsimg2:'required'
                    
            },
            messages: {
                s_name: {
                    required: "请填写您的真实姓名,长度2-20个字符或汉字",
                    minlength: "长度2-20个字符或汉字",
                    maxlength: "长度2-20个字符或汉字"
                   // remote: "该名称已经存在"
                },
                s_sex: "　请选择性别",
                s_credentialstype: '请选择证件类型',
                s_credentialsnumber	:{
                    remote: "身份证号已存在或没有录入该地生源权限",
                    required:'请输入证件号码'
                },	
                s_birthdate: {
                    required:'请输入出生日期',
                    remote: "该学生小于18周岁",
                    cndate:'格式错误 例：19800101'
                },
                s_birthaddress: {
                    required:'请输入出生地'
                    // cnCharset:'　必须为汉字',
                    // maxlength: '　长度不能大于20'
                },
                s_nationality: '请选择民族',
                s_politicalstatus: '请选择政治面貌',
                s_highesteducation: '请选择最高学历',
                s_phone: {
                    remote: "该手机号已经存在",
                    required:'请输入手机号码'
                },
                s_email:{ 
                    required:'请输入邮箱',
                    email:'邮箱格式不正确'
                },
                s_baokaocengci: '请选择报考层次',
                s_baokaozhuanye: '请选择报考专业',
                s_zhiyezhuangkuang: '请选择职业状况',
                s_hunyinzhuangkuang: '　请选择婚姻状况',
                s_sfromaddress: '　请选择生源地',
                s_cjgztime: {
                    required:'请输入参加工作时间',
                    cndatenoday:'格式错误 例：1980-01'
                },
                s_oldschool: '请输入原毕业院校',
                s_oldzhuanye: '请输入原毕业专业',
                s_oldtime: {
                    required:'请输入院毕业时间',
                    cndatenoday:'格式错误 例：1980-01'
                },
                s_zsbzm: '请上传毕业证书扫描件',
                s_oldimg: '请上传毕业证书扫描件',
                s_oldimgnumber: '请输入毕业证书编号',
                s_headerimg:'请上传个人照片',
                s_credentialsimg1:'请上传证件扫描件（正面）',
                s_contactaddress:'请输入通讯地址',
                s_familyaddress:'请输入家庭地址',
                s_oldschoolcode: {
                    chkoldcode:'请输入原毕业院校代码'
                },
                s_credentialsimg2:'请上传证件扫描件（反面）'
            }
        });
    });
<?php if(!$other){
    if(isset($_GET['type'])&&$_GET['type']=="1"){?>
        function handread_onclick(){
            //ReadsNum_onclick()
            var pPhotoBuffer=rdcard.JPGBuffer; 
                rdcard.readcard();
            if (rdcard.bHaveCard){
                document.getElementById("s_name").value=rdcard.NameL;
                if(rdcard.Sex==1){
                    document.getElementById("s_sex_0").checked=true;
                }else if(rdcard.Sex==2){
                    document.getElementById("s_sex_1").checked=true;
                }
                document.getElementById("s_birthdate").value=rdcard.Born;
                document.getElementById("s_credentialsnumber").value=rdcard.CardNo;
                document.getElementById("s_birthaddress").value=rdcard.newAddress?rdcard.newAddress:rdcard.Address;
                rdcard.newSaveCardPic();
                
                $(".readcardmsg").html("读卡器提取中...");
                $.ajax({
                    'type':'POST',
                    'url':'/site/saveheadimgbybase64.html',
                    'data':{'jpgbase64':rdcard.JPGBuffer,"zhengbase64":rdcard.FrontJpgPic,"fanbase64":rdcard.BackJpgPic},
                    'async':false,
                    'success':function(msg){
                        if(msg){
                            if( data=eval("("+msg+")")){
                                $("#s_headerimg").val(data.zp_name);
                                $("#headerimg").attr("src",data.zp_name);
                                $("#s_credentialsimg1").val(data.sfz_name);
                                $("#credentialsimg1").attr("src",data.sfz_name);
                                $("#s_credentialsimg2").val(data.sff_name);
                                $("#credentialsimg2").attr("src",data.sff_name);
                                <?php if($inputType){?> 
                                    $("#headerimg").css("display",'block').css("position",'relative');
                                    $("#credentialsimg1").css("display",'block').css("position",'relative');
                                    $("#credentialsimg2").css("display",'block').css("position",'relative');
                                    $(".readcardmsg").html("图片提取成功");
                                <?php }else{?>
                                 $("#credentialsimg1btn").css("display",'inline-block')
                                 $("#credentialsimg2btn").css("display",'inline-block')
                                 $("#headerimgshowbtn").css("display",'inline-block')
                                
                                
                                <?php }?>
                            }
                            return false;
                            <?php /*$("#headerimgshowbtn").css("display",'none')
                            $("#headerimgeditbtn").css("display",'none')*/ ?>
                        }
                }
                });
                $('#s_credentialstype').val('1');
                $('#s_nationality').val(rdcard.Nation/1);
                rdcard.bHaveCard=false;
            }
            if(rdcard.sResultMsg=='读卡成功，请放下一张'||rdcard.sResultMsg=='保存成功!'){
                rdcard.DeleteOutputFile(); 
                rdcard.DeletePicture("c:\\temp\\zheng.jpg"); 
                rdcard.DeletePicture("c:\\temp\\fan.jpg"); 
                document.getElementById("TSmessage").innerHTML='读卡成功!';
            }else{
                document.getElementById("TSmessage").innerHTML=rdcard.sResultMsg;
            }
        }
<?php }else if(isset($_GET['type'])&&$_GET['type']=="2"){?>
        function MyGetData()//OCX读卡成功后的回调函数
        {	
                document.getElementById("s_name").value=GT2ICROCX.NameL;
                    if(GT2ICROCX.Sex==1){
                        document.getElementById("s_sex_0").checked=true;
                    }else if(GT2ICROCX.Sex==2){
                        document.getElementById("s_sex_1").checked=true;
                    }
                    document.getElementById("s_birthdate").value=GT2ICROCX.Born;
                    document.getElementById("s_credentialsnumber").value=GT2ICROCX.CardNo;
                    document.getElementById("s_birthaddress").value=GT2ICROCX.newAddress?GT2ICROCX.newAddress:GT2ICROCX.Address;
                    $(".readcardmsg").html("读卡器提取中...");
                     $.ajax({
                        'type':'POST',
                        'url':'/site/saveheadimgbybase64.html',
                        'data':{'jpgbase64':GT2ICROCX.GetPhotoBuffer(),"zhengbase64":GT2ICROCX.GetFaceJpgBase64(1),"fanbase64":GT2ICROCX.GetFaceJpgBase64(2)},
                        'async':false,
                        'success':function(msg){
                            if(msg){
                                if( data=eval("("+msg+")")){
                                    $("#s_headerimg").val(data.zp_name);
                                    $("#headerimg").attr("src",data.zp_name);
                                    $("#s_credentialsimg1").val(data.sfz_name);
                                    $("#credentialsimg1").attr("src",data.sfz_name);
                                    $("#s_credentialsimg2").val(data.sff_name);
                                    $("#credentialsimg2").attr("src",data.sff_name);
                                    <?php if($inputType){?> 
                                        $("#headerimg").css("display",'block').css("position",'relative');
                                        $("#credentialsimg1").css("display",'block').css("position",'relative');
                                        $("#credentialsimg2").css("display",'block').css("position",'relative');
                                        $(".readcardmsg").html("图片提取成功");
                                    <?php }else{?>
                                     $("#credentialsimg1btn").css("display",'inline-block')
                                     $("#credentialsimg2btn").css("display",'inline-block')
                                     $("#headerimgshowbtn").css("display",'inline-block')
                                    
                                    
                                    <?php }?>
                                }
                                return false;
                               
                                <?php /*$("#headerimgshowbtn").css("display",'none')
                                $("#headerimgeditbtn").css("display",'none')*/ ?>
                               
                            }
                             
                             
                    }
                    });
                    $('#s_credentialstype').val('1');
                    $('#s_nationality').val(GT2ICROCX.Nation/1);
        }
        function MyGetErrMsg()//OCX读卡消息回调函数
        {
            TSmessage.value = GT2ICROCX.ErrMsg;	   
        }

        function StartRead()//开始读卡
        {  
            if (GT2ICROCX.GetState() == 0){
                GT2ICROCX.ReadCard()	
            }
        }
    <?php 
        }
    }?>
</script>