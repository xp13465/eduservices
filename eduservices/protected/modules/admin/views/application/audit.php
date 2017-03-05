<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员审核'=>array("check"),
	'学员查看',
);
$url=isset($_COOKIE['xysqshreturnurl'])?$_COOKIE['xysqshreturnurl']:array("check");
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
            $usermodel=User::model()->findByPk($stuModel->s_addid);
            $Omodel=Organization::model()->findByPk($usermodel->user_organization);
            $OName=$Omodel->o_name;
            if($usermodel->user_role==1){
                $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                $OName=$POmodel->o_name;
            }
        ?>
        <b>录入编号：</b><span class='blcolor1 '><?="{$stuModel->s_rpc}-{$OName}".str_pad($stuModel->s_insertid,6,0,STR_PAD_LEFT)?></span>
        <b>录入员：</b>	
		<span class="blcolor1"><?=User::model()->getUserName($stuModel->s_addid)?></span>
		<span class='hcolor marl5'><?=date("Y-m-d H:i:s",$stuModel->s_addtime)?></span>
		<b>录入批次：</b><span class='blcolor1 '><?=$stuModel->s_rpc?$stuModel->s_rpc:"未安排"?></span>
         <?php $rxkPcArr=Pici::model()->getAllPC(false,false);?>
        <b>排考批次：</b><span class='blcolor1 '><?=isset($rxkPcArr[$stuModel->s_pc])?$rxkPcArr[$stuModel->s_pc]:$stuModel->s_pc."未安排"?></span>
		<b>审核状态：</b>
		<span class="blcolor1"><?=@Students::$status[$stuModel->s_status]?></span>
		<?php if(in_array($stuModel->s_status,array(2,3))){?>
			<b class='marl5'>审核员：</b><span class="blcolor1"><?=User::model()->getUserName($stuModel->s_statusid)."{$stuModel->s_statusid}"?></span>
			
			<span class='hcolor marl5'><?=date("Y-m-d H:i:s",$stuModel->s_statustime)?></span>
		<?php }?>
		</p>
          <div class="btn-group pull-right">
            <a title="一栏显示" class="btn btnbg1"  href="javascript:showList(1,this)" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"":"background:#ddd"?>'><i class="icon-align-justify"></i></a>
            <a title="二栏显示"  class="btn btnbg2" href="javascript:showList(2,this)" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"background:#ddd":""?>'><i class=" icon-th-large"></i></a>
            <a title="打印预览学生信息" class="btn" href="<?=Yii::app()->createUrl("admin/students/allprint",array("id"=>$stuModel->s_id))?>" target="_blank"><i class="icon-print"></i></a>	
            </div>
      </td>
    </tr>
    <tr>
<td class=" <?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"linebg":"nolinebg"?>" width="100%">
<?php 
    // $array=Students::model()->getCardInfoByWeb($stuModel->s_credentialsnumber);
    
    $id=$stuModel->s_addid;
    $user=User::model()->findByPk($id);
    $checkArr=$user->user_bddm?explode(",",$user->user_bddm):array();
    $sfcode=substr(strtolower(trim($stuModel->s_credentialsnumber)),0,2);
    $valid=false;
    if(in_array($sfcode,$checkArr)){
        $valid = true;
    }
    
	if($valid){
		$CardDate=Students::model()->getIDCardInfo($stuModel->s_credentialsnumber);	
		$SFCardNum=$stuModel->s_credentialsnumber;
		if($stuModel->s_credentialstype==1&&$CardDate!=date("Ymd",$stuModel->s_birthdate)){
			$SFCardNum=str_replace($CardDate,"<span style='color:red;font-weight:bold'>{$CardDate}</span>",$stuModel->s_credentialsnumber);	
		}
	}else{
		$SFCardNum="<span style='color:red;font-weight:bold'>{$stuModel->s_credentialsnumber}</span>";
	}
?>
<div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
	<div>
		<dl class="dl-horizontal">
			<dt>姓名</dt><dd><?=$stuModel->s_name?>&nbsp;</dd>
			<dt>性别</dt><dd><?=Students::$sex[$stuModel->s_sex]?>&nbsp;</dd>
			<dt>个人照片</dt><dd class="gr-photo"><a class="bwGal" title="个人照片" rel="gal" target='_blank' href='<?=$stuModel->s_headerimg?>'><img src="<?=$stuModel->s_headerimg?>" /></a>&nbsp;</dd>
			<dt>证件号码</dt><dd><?=Students::$credentialstype[$stuModel->s_credentialstype]."：".$SFCardNum?>&nbsp;</dd>
			<dt>证件扫描件</dt><dd class="smj-photo">
				<a class="bwGal" title="身份证扫描件正面" rel="gal"  target='_blank' href='<?=$stuModel->s_credentialsimg1?>'><img src="<?=$stuModel->s_credentialsimg1?>" /></a>
				<a class="bwGal" title="身份证扫描件反面" rel="gal"  target='_blank' href='<?=$stuModel->s_credentialsimg2?>'><img src="<?=$stuModel->s_credentialsimg2?>	" /></a>
			&nbsp;</dd>
			<dt>出生日期</dt><dd><?=date("Ymd",$stuModel->s_birthdate)?>&nbsp;</dd>
			<dt>出生地</dt><dd><?=$stuModel->s_birthaddress?>&nbsp;</dd>
			<dt>民族</dt><dd><?=Lookup::model()->getValueName($stuModel->s_nationality,"nationality")?>&nbsp;</dd>
			<dt>政治面貌</dt><dd><?=Lookup::model()->getValueName($stuModel->s_politicalstatus,"politicalstatus")?>&nbsp;</dd>
			<dt>最高学历</dt><dd><?=Students::$highesteducation[$stuModel->s_highesteducation]?>&nbsp;</dd>
			<dt>手机</dt><dd><?=$stuModel->s_phone?>&nbsp;</dd>
			<dt>邮箱</dt><dd><?=$stuModel->s_email?>&nbsp;</dd>
			<dt>报考层次</dt><dd><?=Lookup::model()->getValueName($stuModel->s_baokaocengci,"professionallevel")?>&nbsp;</dd>
			<dt>报考专业</dt><dd><?=Professional::model()->getZyName($stuModel->s_baokaozhuanye)?>&nbsp;</dd>
			<dt>职业状况</dt><dd><?=Students::$profession[$stuModel->s_zhiyezhuangkuang]?>&nbsp;</dd>
			<dt>婚姻状况</dt><dd><?=Students::$marital[$stuModel->s_hunyinzhuangkuang]?>&nbsp;</dd>
		</dl>
	</div>
</div>
<div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
	<div>
		<dl class="dl-horizontal">
			<dt>家庭地址</dt><dd><?=$stuModel->s_familyaddress?$stuModel->s_familyaddress:"&nbsp;"?>&nbsp;</dd>
			<dt>工作单位</dt><dd><?=$stuModel->s_gongzuodanwei?$stuModel->s_gongzuodanwei:"&nbsp;"?>&nbsp;</dd>
			<dt>邮编</dt><dd><?=$stuModel->s_youbian?$stuModel->s_youbian:"&nbsp;"?>&nbsp;</dd>
			<dt>通讯地址</dt><dd><?=$stuModel->s_contactaddress?$stuModel->s_contactaddress:"&nbsp;"?>&nbsp;</dd>
			<dt>联系电话</dt><dd><?=$stuModel->s_tel?$stuModel->s_tel:"&nbsp;"?>&nbsp;</dd>
			<dt>生源地</dt><dd><?=Lookup::model()->getValueName($stuModel->s_sfromaddress,"studentsfrom")?>&nbsp;</dd>
			<dt>生源状况</dt><dd><?=Lookup::model()->getValueName($stuModel->s_sfromtype,"studentsfromstatus")?>&nbsp;</dd>
			<dt>参加工作时间</dt><dd><?=date("Y-m",$stuModel->s_cjgztime)?>&nbsp;</dd>
			<?php if(in_array($stuModel->s_highesteducation,array(2,3,4,5))){?>
			<dt>原毕业院校</dt><dd><?=$stuModel->s_oldschool?>&nbsp;</dd>
			<dt>原毕业院校代码</dt><dd><?=$stuModel->s_oldschoolcode?$stuModel->s_oldschoolcode:"&nbsp;"?>&nbsp;</dd>
			<dt>原毕业专业</dt><dd><?=$stuModel->s_oldzhuanye?>&nbsp;</dd>
			<dt>原毕业时间</dt><dd><?=date("Y-m",$stuModel->s_oldtime)?>&nbsp;</dd>
			<?php }?>
			<dt>原毕业证书编号</dt><dd><?=$stuModel->s_oldimgnumber?>&nbsp;</dd>
			
			<dt>原毕业证书扫描件</dt><dd class="smj-photo">
           
			<a  class="bwGal" title="原毕业证书扫描件" rel="gal"  target='_blank' href='<?=$stuModel->s_oldimg?>'><img src="<?=$stuModel->s_oldimg?>	" /></a>
			&nbsp;</dd>
             <?php if(in_array($stuModel->s_baokaocengci,array(2))){?>
			<dt>专升本证明</dt><dd class="smj-photo">
			<a class="bwGal" title="专升本证明" rel="gal" target='_blank' href='<?=$stuModel->s_zsbzm?>'><img src="<?=$stuModel->s_zsbzm?>	" /></a>&nbsp;</dd>
			<?php }?>
			<dt>入学方式</dt><dd><?=Students::$enrollment[$stuModel->s_enrollment]?>&nbsp;</dd>
			<dt>学习类型</dt><dd><?=Students::$study[$stuModel->s_study]?>&nbsp;</dd>
			<dt>其他证明材料</dt><dd><a target='_blank' href='<?=$stuModel->s_file?>'><?=$stuModel->s_file?></a>&nbsp;</dd>
			<dt>生源类型</dt><dd><?=Students::$bdtype[$stuModel->s_idbd]?></a>&nbsp;</dd>
		</dl>
	</div>
</div>	
      </td>
    </tr>
    <tr>
        <td>
            <div>
                <dl class="dl-horizontal">
                    <dt>申请类型</dt><dd><?=isset(Application::$type[$model->sa_type])?Application::$type[$model->sa_type]:""?> &nbsp;</dd>
                    <dt>申请备注</dt><dd><?=nl2br($model->sa_remarks)?> &nbsp;</dd>
                    <dt>申请附件</dt><dd><?=!empty($model->sa_fileurl)?"<a href='".DOMAIN.$model->sa_fileurl."'>下载</a>":"无附件"?> &nbsp;</dd>
                    <dt>申请时间</dt><dd><?=date("Y-m-d H:i:s",$model->sa_sqtime)?></dd>
                    <?if($model->sa_type==5){?>
                    <dt>录入人数限制</dt><dd>
                                            <table style="width:500px;" class="table table-bordered specialtylist">
                                                <thead>
                                                    <tr>						
                                                        <th width="30%">入学批次[录入员]</th>
                                                        <th width="30%">录入上限</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $ilmits = Inputlimits::model()->find("il_uid = {$stuModel->s_addid} and il_pc = {$stuModel->s_rpc}"); 
                                                        $Tatol = Students::model()->count("s_rpc = {$ilmits->il_pc} and s_isdel = 1 and s_addid ={$stuModel->s_addid}");
                                                    ?>
                                                    <tr>
                                                        <td><?=$ilmits->il_pc?> 批次 [<?=User::model()->getUserName($stuModel->s_addid)?>]</td>
                                                        <td><?=$ilmits->il_limit?> 人 (已录<?=$Tatol?>人)</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                          </dd>
                    <?php }?>
                </dl>
            </div>
        </td>
    </tr>
	<tr>
        <td width='50%'>
<div class="pull-left">
	  	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'application-form',
	"htmlOptions"=>array('class'=>'form-horizontal userform'),
	'enableAjaxValidation'=>false,
)); ?>
<div class="control-group">
<label class="control-label" for="verify">审核状态 <span class="rcolor">*</span></label>
<div class="controls " id='sa_status'>
<div class='pull-left'>
<label class="radio inline" style='width:40px'>
<input type="radio" name="sa_status" id="sa_status_0" <?=$model->sa_status=="2"?"checked":""?> value="2">通过
</label>
<label class="radio inline" style='width:40px'>
<input type="radio" name="sa_status" id="sa_status_1" <?=$model->sa_status=="3"?"checked":""?> value="3">驳回
</label>
</div>
<p for="sa_status" htmlfor='sa_status' class="error" style=""><?=isset($model->errors['sa_status'])?join('',$model->errors['sa_status']):""?></p>
</div>	    
</div> 
<div class="control-group">
<label class="control-label" for="verify">审核备注 <span class="rcolor">*</span></label>
<div class="controls">
<?php echo $form->textAREA($model,'sa_statusremarks',array('class'=>'input-large pull-left','maxlength'=>200,'name'=>"sa_statusremarks",'style'=>"width:400px;height:100px")); ?>
<p for="sa_statusremarks" class="error" style=""><?=isset($model->errors['sa_statusremarks'])?join('',$model->errors['sa_statusremarks']):""?></p>
</div>
</div> 
<div class="form-actions">
	<button type="submit" class="btn btn-primary" name="addsubmit" value="add">确&nbsp;定</button>&nbsp;
     <a href="<?=Yii::app()->createUrl("admin/students/edit",array("id"=>$stuModel->s_id))?>" target="_blank" class="btn btn-primary" >编辑该学员</a>&nbsp;
	<?php
        $url = isset($_COOKIE['xysqreturnurl'])?$_COOKIE['xysqreturnurl']:Yii::app()->createUrl("admin/application/check");
    ?>

    <a href="<?=$url?>" class="btn btn-primary" >返回</a>
</div>
<?php $this->endWidget(); ?>
</div>
      </td>

    </tr>
    
  </tbody>

</table>
</div>
</div>
<script>
jQuery(document).ready(function(){
    jQuery("#application-form").validate({
            // debug: true,
			autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
				sa_statusremarks:{ 
					maxlength:200
				},
                sa_status: 'required', 
            },
            messages: {
				sa_statusremarks:{ 
					maxlength:'不得超过200个字'
				},
                sa_status: '　请选择！',
            }
        });
})
</script>