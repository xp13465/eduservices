<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员申请管理'=>array("applicationlist"),
	'申请查看',
);
$url = isset($_COOKIE['xysqlistreturnurl'])?$_COOKIE['xysqlistreturnurl']:"application";
if(Yii::app()->user->role==4||$model->sa_status!=2){
    $this->menu=array(
        array('label'=>'返回学员查看页','url'=>array('students/view','id'=>$model->sa_sid)),
        array('label'=>'返回学员申请列表','url'=>$url),
        array('label'=>'编辑','url'=>array('application/edit','id'=>$model->sa_id,'return'=>'view')),
    );
}else{
    //删除申请存在且通过  恢复申请不存在
    $count = Application::model()->count("sa_sid = '{$model->sa_sid}' and sa_type = 4 and sa_status = 2 and sa_isdel =1");
    $shfcount = Application::model()->count("sa_sid = '{$model->sa_sid}' and sa_type = 5 and sa_status = 2 and sa_isdel =1");
    if($count && !$shfcount){
        $this->menu=array(
            array('label'=>'恢复申请','url'=>array("application/add","sid"=>$model->sa_sid,"type"=>"5")),
            array('label'=>'返回', 'url'=>$url),
        );
    }else{
        $this->menu=array(
            array('label'=>'返回学员查看页','url'=>array('students/view','id'=>$model->sa_sid)),
            array('label'=>'返回', 'url'=>$url),
        );
    }
}
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
      <td class="<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"linebg":"nolinebg"?>" width="100%">
    
    <div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
        <p class="lineh30 marl100" >
			<b>申请类型：</b><span class='blcolor1'><?=isset(Application::$type[$model->sa_type])?Application::$type[$model->sa_type]:""?></span>
			<b>申请用户：</b><span class='blcolor1'><?=User::model()->getUserName($model->sa_proposerid)?></span>
			<b>申请时间：</b><span class='hcolor'><?=date("Y-m-d H:i:s",$model->sa_sqtime)?></span>
		</p>
		<p class="lineh30 marl100" >
			<?=!empty($model->sa_euserid)?"<b>最后修改：</b><span class='blcolor1'>".User::model()->getUserName($model->sa_euserid)."</span>":""?>
            <?=!empty($model->sa_euserid)?"<b>最后修改时间：</b><span class='hcolor'>".date("Y-m-d H:i:s",$model->sa_shedittime)."</span>":""?>
		</p>
		<p class="lineh30 marl100" >
			<b>申请附件：</b><span class='blcolor1'><?=!empty($model->sa_fileurl)?"<a href='".DOMAIN.$model->sa_fileurl."'>下载</a>":"无附件"?></span>			
		</p>
		<p class="lineh30 marl100">
			<b class="pull-left">申请备注：</b><textarea rows="4" readonly style="width:400px;"><?=($model->sa_remarks)?></textarea>
		</p>
        
	</div>
    
	<div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
		<p class="lineh30 marl100" >
			<b>审核状态：</b><span class='<?=$model->sa_status!=1?$model->sa_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=isset(Application::$astatus[$model->sa_status])?Application::$astatus[$model->sa_status]:""?></span>
			<?=$model->sa_status!='1'?"<b>审核时间：</b><span class='hcolor'>".date('Y-m-d H:i:s',$model->sa_shtime)."</span>":""?>			
		</p>
		<p class="lineh30 marl100">
			<?php if($model->sa_statusremarks):?>
				<b class="pull-left">审核备注：</b><span class='blcolor1 '><textarea readonly rows="4" style="width:400px;"><?=$model->sa_statusremarks?></textarea></span>
			<?php endif; ?>
		</p>
		<?=$model->sa_isdel==2?"<p class='lineh30 marl100'><font color='red'>该条记录已删除</font></p>":""?>
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
  </tbody>
</table>
</div>
</div>