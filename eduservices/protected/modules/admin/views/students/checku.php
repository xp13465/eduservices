<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员审核'=>array("index"),
	'学员查看',
);

$url=isset($_COOKIE['xyckreturnurl'])?$_COOKIE['xyckreturnurl']:array("index");
$this->menu=array(
	array('label'=>'返回', 'url'=>$url),
);

?>

<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/layout.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/zoomimage.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/custom.css" />
<script type="text/javascript" src="/js/zoomimage.jquery/js/jquery.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/eye.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/utils.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/zoomimage.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/layout.js"></script>

			
<div>
    
    
<div class="form-horizontal userform">
<table class="table table-bordered">
  <tbody>
  	<tr>
      <td>
		<p class="pull-left lineh30 margin0  marl10 " >
        <?php 
            $usermodel=User::model()->findByPk($model->s_addid);
            $Omodel=Organization::model()->findByPk($usermodel->user_organization);
            $OName=$Omodel->o_name;
            if($usermodel->user_role==1){
                $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                $OName=$POmodel->o_name;
            }
        ?>
        <b>录入编号：</b><span class='blcolor1 '><?="{$model->s_rpc}-{$OName}".str_pad($model->s_insertid,6,0,STR_PAD_LEFT)?></span>
        <b>录入员：</b>	
		<span class="blcolor1"><?=User::model()->getUserName($model->s_addid)?></span>
		<span class='hcolor marl5'><?=date("Y-m-d H:i:s",$model->s_addtime)?></span>
        
        <b>最后修改：</b>	
		<span class="blcolor1"><?=User::model()->getUserName($model->s_editid)?></span>
		<span class='hcolor marl5'><?=$model->s_edittime?date("Y-m-d H:i:s",$model->s_edittime):""?></span>
        <br/>
		<b>录入批次：</b><span class='blcolor1 '><?=$model->s_rpc?$model->s_rpc:"未安排"?></span>
         <?php $rxkPcArr=Pici::model()->getAllPC(false,false);?>
        <b>排考批次：</b><span class='blcolor1 '><?=isset($rxkPcArr[$model->s_pc])?$rxkPcArr[$model->s_pc]:$model->s_pc."未安排"?></span>
		<b>审核状态：</b>
		<span class="blcolor1"><?=@Students::$status[$model->s_status]?></span>
		<?php if(in_array($model->s_status,array(2,3))){?>
			<b class='marl5'>审核员：</b><span class="blcolor1"><?=User::model()->getUserName($model->s_statusid)."{$model->s_statusid}"?></span>
			
			<span class='hcolor marl5'><?=date("Y-m-d H:i:s",$model->s_statustime)?></span>
		<?php }?>
		</p>
          <div class="btn-group pull-right marr10">
            <a title="一栏显示" class="btn btnbg1"  href="javascript:showList(1,this)" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"":"background:#ddd"?>'><i class="icon-align-justify"></i></a>
            <a title="二栏显示"  class="btn btnbg2" href="javascript:showList(2,this)" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"background:#ddd":""?>'><i class=" icon-th-large"></i></a>
            <a title="打印预览学生信息" class="btn" href="<?=Yii::app()->createUrl("admin/students/allprint",array("id"=>$model->s_id))?>" target="_blank"><i class="icon-print"></i></a>	
            </div>
      </td>
    </tr>
    <tr>
<td class=" <?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"linebg":"nolinebg"?>" width="100%">
<?php 
    // $array=Students::model()->getCardInfoByWeb($model->s_credentialsnumber);
    
    $id=$model->s_addid;
    $user=User::model()->findByPk($id);
    $checkArr=$user->user_bddm?explode(",",$user->user_bddm):array();
    $sfcode=substr(strtolower(trim($model->s_credentialsnumber)),0,2);
    $valid=false;
    if(in_array($sfcode,$checkArr)){
        $valid = true;
    }
    
	if($valid){
		$CardDate=Students::model()->getIDCardInfo($model->s_credentialsnumber);	
		$SFCardNum=$model->s_credentialsnumber;
		if($model->s_credentialstype==1&&$CardDate!=date("Ymd",$model->s_birthdate)){
			$SFCardNum=str_replace($CardDate,"<span style='color:red;'>{$CardDate}</span>",$model->s_credentialsnumber);	
		}
	}else{
		$SFCardNum="<span style='color:red;'>{$model->s_credentialsnumber}</span>";
	}
	
?>
<div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
	<div>
		<dl class="dl-horizontal">
			<dt>姓名</dt><dd><?=$model->s_name?>&nbsp;</dd>
			<dt>性别</dt><dd><?=Students::$sex[$model->s_sex]?>&nbsp;</dd>
			<dt>个人照片</dt><dd class="gr-photo"><a class="bwGal" title="个人照片" rel="gal" target='_blank' href='<?=$model->s_headerimg?>'><img src="<?=$model->s_headerimg?>" /></a>&nbsp;</dd>
			<dt>证件号码</dt><dd><?=Students::$credentialstype[$model->s_credentialstype]."：".$SFCardNum?>&nbsp;</dd>
			<dt>证件扫描件</dt><dd class="smj-photo">
				<a class="bwGal" title="身份证扫描件正面" rel="gal"  target='_blank' href='<?=$model->s_credentialsimg1?>'><img src="<?=$model->s_credentialsimg1?>" /></a>
				<a class="bwGal" title="身份证扫描件反面" rel="gal"  target='_blank' href='<?=$model->s_credentialsimg2?>'><img src="<?=$model->s_credentialsimg2?>	" /></a>
			&nbsp;</dd>
			<dt>出生日期</dt><dd><?=date("Ymd",$model->s_birthdate)?>&nbsp;</dd>
			<dt>出生地</dt><dd><?=$model->s_birthaddress?>&nbsp;</dd>
			<dt>民族</dt><dd><?=Lookup::model()->getValueName($model->s_nationality,"nationality")?>&nbsp;</dd>
			<dt>政治面貌</dt><dd><?=Lookup::model()->getValueName($model->s_politicalstatus,"politicalstatus")?>&nbsp;</dd>
			<dt>最高学历</dt><dd><?=Students::$highesteducation[$model->s_highesteducation]?>&nbsp;</dd>
			<dt>手机</dt><dd><?=$model->s_phone?>&nbsp;</dd>
			<dt>邮箱</dt><dd><?=$model->s_email?>&nbsp;</dd>
			<dt>报考层次</dt><dd><?=Lookup::model()->getValueName($model->s_baokaocengci,"professionallevel")?>&nbsp;</dd>
			<dt>报考专业</dt><dd><?=Professional::model()->getZyName($model->s_baokaozhuanye)?>&nbsp;</dd>
			<dt>职业状况</dt><dd><?=Students::$profession[$model->s_zhiyezhuangkuang]?>&nbsp;</dd>
			<dt>婚姻状况</dt><dd><?=Students::$marital[$model->s_hunyinzhuangkuang]?>&nbsp;</dd>
		</dl>
	</div>
</div>
<div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
	<div>
		<dl class="dl-horizontal">
			<dt>家庭地址</dt><dd><?=$model->s_familyaddress?$model->s_familyaddress:"&nbsp;"?>&nbsp;</dd>
			<dt>工作单位</dt><dd><?=$model->s_gongzuodanwei?$model->s_gongzuodanwei:"&nbsp;"?>&nbsp;</dd>
			<dt>邮编</dt><dd><?=$model->s_youbian?$model->s_youbian:"&nbsp;"?>&nbsp;</dd>
			<dt>通讯地址</dt><dd><?=$model->s_contactaddress?$model->s_contactaddress:"&nbsp;"?>&nbsp;</dd>
			<dt>联系电话</dt><dd><?=$model->s_tel?$model->s_tel:"&nbsp;"?>&nbsp;</dd>
			<dt>生源地</dt><dd><?=Lookup::model()->getValueName($model->s_sfromaddress,"studentsfrom")?>&nbsp;</dd>
			<dt>生源状况</dt><dd><?=Lookup::model()->getValueName($model->s_sfromtype,"studentsfromstatus")?>&nbsp;</dd>
			<dt>参加工作时间</dt><dd><?=date("Y-m",$model->s_cjgztime)?>&nbsp;</dd>
			<?php if(in_array($model->s_highesteducation,array(2,3,4,5))){?>
			<dt>原毕业院校</dt><dd><?=$model->s_oldschool?>&nbsp;</dd>
			<dt>原毕业院校代码</dt><dd><?=$model->s_oldschoolcode?$model->s_oldschoolcode:"&nbsp;"?>&nbsp;</dd>
			<dt>原毕业专业</dt><dd><?=$model->s_oldzhuanye?>&nbsp;</dd>
			<dt>原毕业时间</dt><dd><?=date("Y-m",$model->s_oldtime)?>&nbsp;</dd>
			<?php }?>
			<dt>原毕业证书编号</dt><dd><?=$model->s_oldimgnumber?>&nbsp;</dd>
			
			<dt>原毕业证书扫描件</dt><dd class="smj-photo">
           
			<a  class="bwGal" title="原毕业证书扫描件" rel="gal"  target='_blank' href='<?=$model->s_oldimg?>'><img src="<?=$model->s_oldimg?>	" /></a>
			&nbsp;</dd>
             <?php if(in_array($model->s_baokaocengci,array(2))){?>
			<dt>专升本证明</dt><dd class="smj-photo">
			<a class="bwGal" title="专升本证明" rel="gal" target='_blank' href='<?=$model->s_zsbzm?>'><img src="<?=$model->s_zsbzm?>	" /></a>&nbsp;</dd>
			<?php }?>
			<dt>入学方式</dt><dd><?=Students::$enrollment[$model->s_enrollment]?>&nbsp;</dd>
			<dt>学习类型</dt><dd><?=Students::$study[$model->s_study]?>&nbsp;</dd>
			<dt>其他证明材料</dt><dd><a target='_blank' href='<?=$model->s_file?>'><?=$model->s_file?></a>&nbsp;</dd>
			<dt>生源类型</dt><dd><?=Students::$bdtype[$model->s_idbd]?></a>&nbsp;</dd>
		</dl>
	</div>
</div>	

      </td>
    </tr>
	    <tr>
      <td width='50%'>
<div class="pull-left">
	  	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'students-form',
	"htmlOptions"=>array('class'=>'form-horizontal userform'),
	'enableAjaxValidation'=>false,
)); ?>
<div class="control-group">
<label class="control-label" for="verify">审核状态 <span class="rcolor">*</span></label>

<div class="controls " id='s_status'>
<div class='pull-left'>
<label class="radio inline" style='width:40px'>
<input type="radio" name="s_status" id="s_status_0" <?=$model->s_status=="2"?"checked":""?> value="2">通过
</label>
<label class="radio inline" style='width:40px'>
<input type="radio" name="s_status" id="s_status_1" <?=$model->s_status=="3"?"checked":""?> value="3">驳回
</label>
</div>
<p for="s_status" htmlfor='s_status' class="error" style=""><?=isset($model->errors['s_status'])?join('',$model->errors['s_status']):""?></p>

</div>
	
    
</div> 
<div class="control-group">
<label class="control-label" for="verify">审核备注 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textAREA($model,'s_statusabout',array('class'=>'input-large pull-left','maxlength'=>200,'name'=>"s_statusabout",'style'=>"width:400px;height:100px")); ?>
<p for="s_statusabout" class="error" style=""><?=isset($model->errors['s_statusabout'])?join('',$model->errors['s_statusabout']):""?></p>

</div>
	
</div> 

<div class="control-group">
<label class="control-label" for="s_rpc">其他证明材料类型分配 </label>
<div class="controls">
<?php echo $form->dropDownList($model,'s_zjtype',Students::$zjtype,$htmlOptions=array ('name'=>"s_zjtype",'class'=>"pull-left")); ?>
<p for="s_zjtype" class="error" style=""><?=isset($model->errors['s_zjtype'])?join('',$model->errors['s_zjtype']):""?></p>
</div>
</div>

<div class="control-group">
<label class="control-label" for="verify">入学考批次 </label>
<div class="controls">
<?php echo $form->dropDownList($model,'s_pc',Pici::model()->getAllPC(true),$htmlOptions=array ('empty'=>"选择入学考批次",'name'=>"s_pc",'class'=>"pull-left")); ?>
<p for="s_pc" class="error" style=""><?=isset($model->errors['s_pc'])?join('',$model->errors['s_pc']):""?></p>
</div>


</div> 
<?php if(Yii::app()->user->role=='4'){?>
<div class="control-group">
<label class="control-label" for="s_rpc">入学批次 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textField($model,'s_rpc',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_rpc")); ?>
<p class="error help-block pull-left pl8">监管中心才有此权限!</p>
<p for="s_rpc"  class="error" style=""><?=isset($model->errors['s_rpc'])?join('',$model->errors['s_rpc']):""?></p>
</div>
</div>
<?php }?>
<div class="form-actions">
	<button type="submit" class="btn btn-primary" name="addsubmit" value="add">确&nbsp;定</button>&nbsp;
	<a class="btn" href='<?=$url?>'  >返&nbsp;回</a>&nbsp;
    <a title="打印预览学生信息" class="btn " href="<?=Yii::app()->createUrl("admin/students/allprint",array("id"=>$model->s_id))?>" target="_blank">打印预览学生信息</a>	
            
	</div>    
	
<?php $this->endWidget(); ?>


</div>

<div class="pull-left app-verify">
<h4>常用审核备注列表</h4>
<ul class="app-verify-list" id='fastselect'>
<?php $models=Lookup::model()->getClassInfo("fastcheck");
foreach($models as $key=>$val){ ?>
<li><?=$key?>`<span><?=$val?></span></li>
<?php } ?>
</ul>
</div>



      </td>

    </tr>
  </tbody>

</table>
</div>
</div>
<script>
jQuery(document).ready(function(){
    jQuery("#fastselect").find("li").find("span").mouseover(function(){
        jQuery(this).css({"background":"#008aff","color":"#fff"})
    }).mouseout(function(){
        jQuery(this).css({"background":"#fff","color":"#666"})
    }).click(function(){
       jQuery('#s_statusabout').val(jQuery('#s_statusabout').val()+jQuery(this).html()+"\n")
    })
    jQuery.validator.addMethod("ckisgo", function(value, element) {   
        if(jQuery("#s_status_0").attr('checked')){
            if(jQuery("#s_pc").val()){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    });
    jQuery("#students-form").validate({
            // debug: true,
			autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
				s_statusabout:{ 
					maxlength:200
				},
                s_status: 'required',            
				s_pc:{ 
                    ckisgo:true 
                }
            },
            messages: {
				s_statusabout:{ 
					maxlength:'不得超过200个字'
				},
                s_status: '　请选择！',
                s_pc:{ 
                    ckisgo:'　请选择！' 
                }
            }
        });
})
</script>