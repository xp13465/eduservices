<?php
$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员列表'=>array("index"),
	'学员查看',
);

$url=isset($_COOKIE['xylistreturnurl'])?$_COOKIE['xylistreturnurl']:array("index");
if(Yii::app()->user->role==4||$model->s_status!=2){
    $this->menu=array(
        array('label'=>'返回列表', 'url'=>$url),
        array('label'=>'编辑', 'url'=>array("students/edit","id"=>$model->s_id,"return"=>'view')),
    );
}else{
	$this->menu=array(
		array('label'=>'返回列表', 'url'=>$url),
	);
}
$id=Yii::app()->user->id;
$usermodel=User::model()->getUserInfoById($id);
$authArr= unserialize($usermodel->user_authorize);
$inputType='readonly';
if(Yii::app()->user->role=='4'||(isset($authArr['diyinsert'])&&$authArr['diyinsert']==1)){
    $inputType='';
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
            <?php if($model->s_stype=='1'){?>
            <?php 
                $usermodel=User::model()->findByPk($model->s_addid);
                $Omodel=Organization::model()->findByPk($usermodel->user_organization);
                $OName=$Omodel->o_name."-".$Omodel->o_id;
                if($usermodel->user_role==1){
                    $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                    $OName=$POmodel->o_name."-".$POmodel->o_id;
                }
            ?>
            <b>录入编号：</b><span class='blcolor1 '><?="{$model->s_rpc}-{$OName}".str_pad($model->s_insertid,6,0,STR_PAD_LEFT)?></span>
            <?php 
            $statusTmp=isset($_COOKIE['stu_status'])&&in_array($_COOKIE['stu_status'],array(1,2,3))?$_COOKIE['stu_status']:"";
            $statusStr=$statusTmp?"and s_status= '{$statusTmp}' ":"";
            $sql=" and s_isdel= '1' and s_addid = '{$model->s_addid}'  {$statusStr}";
            $prevStudentModel=Students::model()->find("s_insertid <'{$model->s_insertid}' {$sql} order by s_insertid desc");
            $nextStudentModel=Students::model()->find("s_insertid >'{$model->s_insertid}' {$sql} order by s_insertid asc");
            $prevUrl=$prevStudentModel?Yii::app()->createUrl("admin/students/view",array("id"=>$prevStudentModel->s_id)):"javascript:void(0)";
            $nextUrl=$nextStudentModel?Yii::app()->createUrl("admin/students/view",array("id"=>$nextStudentModel->s_id)):"javascript:void(0)";
            ?>
            <a title="上一个" class="btn "  <?=$prevStudentModel?"":"style='background:#ddd'"?> href="<?=$prevUrl?>" >上一个</a>
            <?php echo Chtml::dropDownList('status',$statusTmp,Students::$status,$htmlOptions=array ('empty'=>"所有",'name'=>"status",'class'=>"wauto",'onchange'=>"setpagesize('stu_status',this.value)")); ?>
            <a title="上一个" class="btn "  <?=$nextStudentModel?"":"style='background:#ddd'"?> href="<?=$nextUrl?>" >下一个</a>
            <?php  }?>
             
            <?php
                $smModel=StudentsManage::model()->find("sm_sid ='{$model->s_id}'");
                if(Yii::app()->user->id!=5){
                    foreach(Application::$type as $key=>$val){//放退学 信息删除  信息变更 申请
                        if($key==1||$key==5)continue;
                                    
                        $smModel=StudentsManage::model()->find("sm_sid ='{$model->s_id}'");
                        if(!$smModel)if($key==2)continue;
                        $AppModel = Application::model()->find("sa_sid = '{$model->s_id}' and sa_type ='{$key}' and sa_status =1 and sa_isdel =1");
                        if(!$AppModel){                           
                                echo  "<a  class='btn btn-primary '  href='".Yii::app()->createUrl("admin/application/add",array("sid"=>$model->s_id,"type"=>$key))."' >{$val}</a>&nbsp;";                            
                        }
                    }
                }
                if($model->s_baokaocengci==2&&$model->s_status!=3&&in_array(Yii::app()->user->role,array(1,2,3))&&$smModel){
                    echo  "<a  class='btn btn-primary '  href='".Yii::app()->createUrl("admin/emapp/add",array("mksid"=>$model->s_id))."' >免考申请</a>&nbsp;";
                }
                
            ?>
            </p>
            <div class="btn-group pull-right marr10">                
                <a title="一栏显示" class="btn" href="javascript:showList(1,this)" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"":"background:#ddd"?>'><i class="icon-align-justify"></i></a>
                <a title="二栏显示"  class="btn" href="javascript:showList(2,this)" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"background:#ddd":""?>'><i class=" icon-th-large"></i></a>
                <a title="打印预览报名表" class="btn" href="<?=Yii::app()->createUrl("admin/students/print",array("id"=>$model->s_id))?>" target="_blank"><i class="icon-print"></i></a>	
                <a title="打印预览学生信息" class="btn" href="<?=Yii::app()->createUrl("admin/students/allprint",array("id"=>$model->s_id))?>" target="_blank"><i class="icon-print"></i></a>	
            </div>
            </td>
        </tr>
        <?php            
            if($smModel){ ?>
        <tr>
          <td>
            <p class="pull-left lineh30 margin0  marl10 " >
                <b>报名编号：</b>
                <span class="blcolor1"><?=$smModel->sm_bmorder?></span>
                <b>录取状态：</b>
                <span class="blcolor1"><?=@StudentsManage::$status[$smModel->sm_status]?></span>
                <b>状态备注：</b>
                <span class="blcolor1"><?=nl2br($smModel->sm_statusabout)?></span>
            </p>
          </td>
        </tr>
        <?php }?>
      <td >
        <?php if($model->s_stype=='1'){?>
		<p class="pull-left lineh30 margin0  marl10 " >
        <b>录入批次：</b><span class='blcolor1 '><?=$model->s_rpc?$model->s_rpc:"未安排"?></span>
        <b>录入员：</b>	
		<span class="blcolor1"><?=User::model()->getUserName($model->s_addid)?></span>
		<span class='hcolor marl5'><?=date("Y-m-d H:i:s",$model->s_addtime)?></span>
        <b>最后修改：</b>	
		<span class="blcolor1"><?=User::model()->getUserName($model->s_editid)?></span>
		<span class='hcolor marl5'><?=$model->s_edittime?date("Y-m-d H:i:s",$model->s_edittime):""?></span>
        
        <br/>
        <?php $rxkPcArr=Pici::model()->getAllPC(false,false);?>
        <b>排考批次：</b><span class='blcolor1 '><?=isset($rxkPcArr[$model->s_pc])?$rxkPcArr[$model->s_pc]:$model->s_pc."未安排"?></span>
		<b>审核状态：</b>
		<span class="blcolor1"><?=@Students::$status[$model->s_status]?></span>
		<?php if(in_array($model->s_status,array(2,3))){?>
			<b class='marl5'>审核员：</b><span class="blcolor1"><?=User::model()->getUserName($model->s_statusid)."{$model->s_statusid}"?></span>
			<span class='hcolor marl5'><?=date("Y-m-d H:i:s",$model->s_statustime)?></span>
		<?php }?>
        <br/>
        <?php 
                if($model->s_baokaocengci==2&&$model->s_status!=3){
                if(isset($smModel->sm_bmorder)&&$smModel->sm_bmorder){
                    $mkArr=Emapp::model()->findAll("mk_xh='".mb_substr($smModel->sm_bmorder,1)."'");
                    foreach($mkArr as $key=>$val){
                    ?>
                    <b>免考科目：</b><span class='blcolor1 '><?=isset(Emapp::$subject[$val["mk_subject"]])?Emapp::$subject[$val["mk_subject"]]:''?></span>
                    <b>审核状态：</b>
                    <span class="blcolor1"><?=Emapp::$status[$val["mk_status"]]?></span>               
                    <b>申请操作人：</b>
                    <span class='<?=$val->mk_status!=1?$val->mk_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=User::model()->getUserName($val->mk_addid)?></span>
                    <b>申请时间：</b>
                    <span class='hcolor'><?=date('Y-m-d H:i:s',$val->mk_addtime)?></span>
                    <?php if($val->mk_editid){?>
                    <b>最后操作人：</b><span class='<?=$val->mk_status!=1?$val->mk_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=User::model()->getUserName($val->mk_editid)?></span>
                    <b>修改时间：</b><span class='hcolor'><?=date('Y-m-d H:i:s',$val->mk_editime)?></span>
                    <?php }?>
        <br>
        <?php }}}?>  
		</p>
        <?php }else{?>
            <p class="pull-left lineh30 margin0  marl10 " ><b>北航导入新增</b>
        <?php }?>
      </td>
    </tr>
    <?php if($model->s_statusabout){?>
	<tr>
      <td>
		<dl class='dl-beizhu margin0'>
			<dt><b class='marl5'>审核备注:</b></dt>
			<dd><span class='rcolor'><?=nl2br($model->s_statusabout)?></span></dd>
		</dl>
      </td>
    </tr>
    <?php }?>
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
			<dt>考试成绩</dt><dd>
            <?php
                $bkAppModel = Application::model()->find("sa_sid = '{$model->s_id}' and sa_type = '1' and sa_isdel = '1' and sa_status =1");
                if($model->s_enrollment==1){
                    $EAmodels=Examarrangement::model()->findAll("ea_pkid ='{$model->s_pc}'");
                    if($EAmodels){
                        $PKarr=array();
                        foreach($EAmodels as $val)$PKarr[]=$val->ea_id;
                        $num=Score::model()->count("sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$model->s_id}' ");
                        if($num){
                            $Score=Score::model()->find("sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$model->s_id}' and sc_status != 0  order by sc_kgmark desc");
                            echo $Score?$Score->sc_kgmark?"[".$Score->sc_kgmark."]":"<font color='red'>未考</font>":"<font color='red'>未交卷</font>";
                        }else{
                            echo "<font color='red'>未考</font>";
                        }
                    }else{
                        echo "<font color='red'>未排</font>";
                    }
                }elseif($model->s_enrollment==2){
                    echo "免试";
                }
                $Button=false;
                if($model->s_pc){
                    $PiciModel=Pici::model()->findByPk($model->s_pc);
                    $PkModel=$PiciModel?Examarrangement::model()->find("ea_pkid = '{$PiciModel->p_id}'"):false;
                    if($PkModel&&$PkModel->ea_etime<time()){
                        $Button=true;
                    }
                }
                if($Button&&$model->s_enrollment==1&&Yii::app()->user->role!=5){
                    if(!$bkAppModel){
                        echo "<a href='".Yii::app()->createUrl("admin/application/add",array("sid"=>$model->s_id,"type"=>'1'))."' class='btn btn-mini btn-primary'>补考申请</a>&nbsp;";
                    }
                }
            ?>
           &nbsp;</dd>
            <dt>个人照片</dt><dd class="gr-photo"><a  class="bwGal"  title="个人照片"  rel="gal"  target='_blank' href='<?=$model->s_headerimg?>'><img src="<?=$model->s_headerimg?>" /></a>&nbsp;</dd>
			<dt>证件号码</dt><dd><?=Students::$credentialstype[$model->s_credentialstype]."：".$SFCardNum?>&nbsp;</dd>
			<dt>证件扫描件</dt>
			<dd class="smj-photo">
				<a  class="bwGal"  title="身份证扫描件正面"  rel="gal" target='_blank' href='<?=$model->s_credentialsimg1?>'><img src="<?=$model->s_credentialsimg1?>" /></a>
				
				<a  class="bwGal"  title="身份证扫描件反面"  rel="gal" target='_blank' href='<?=$model->s_credentialsimg2?>'><img src="<?=$model->s_credentialsimg2?>" /></a>
				&nbsp;
			</dd>
			<dt>出生日期</dt><dd><?=date("Ymd",$model->s_birthdate)?>&nbsp;</dd>
			<dt>出生地</dt><dd><?=$model->s_birthaddress?>&nbsp;</dd>
			<dt>民族</dt><dd><?=Lookup::model()->getValueName($model->s_nationality,"nationality")?>&nbsp;</dd>
			<dt>政治面貌</dt><dd><?=Lookup::model()->getValueName($model->s_politicalstatus,"politicalstatus")?>&nbsp;</dd>
			<dt>最高学历</dt><dd><?=isset(Students::$highesteducation[$model->s_highesteducation])?Students::$highesteducation[$model->s_highesteducation]:''?>&nbsp;</dd>
			<dt>手机</dt><dd><?=$model->s_phone?>&nbsp;</dd>
			<dt>邮箱</dt><dd><?=$model->s_email?>&nbsp;</dd>
			<dt>报考层次</dt><dd class='blcolor1 '><?=Lookup::model()->getValueName($model->s_baokaocengci,"professionallevel")?>&nbsp;</dd>
			<dt>报考专业</dt><dd><?=Professional::model()->getZyName($model->s_baokaozhuanye)?>&nbsp;</dd>
			<dt>职业状况</dt><dd><?=isset(Students::$profession[$model->s_zhiyezhuangkuang])?Students::$profession[$model->s_zhiyezhuangkuang]:''?>&nbsp;</dd>
			<dt>婚姻状况</dt><dd><?=isset(Students::$marital[$model->s_hunyinzhuangkuang])?Students::$marital[$model->s_hunyinzhuangkuang]:''?>&nbsp;</dd>
		</dl>
	</div>
</div>
<div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
	<div>
		<dl class="dl-horizontal">
			<dt>家庭地址</dt><dd><?=$model->s_familyaddress?$model->s_familyaddress:"&nbsp;"?></dd>
			<dt>工作单位</dt><dd><?=$model->s_gongzuodanwei?$model->s_gongzuodanwei:"&nbsp;"?></dd>
			<dt>邮编</dt><dd><?=$model->s_youbian?$model->s_youbian:"&nbsp;"?></dd>
			<dt>通讯地址</dt><dd><?=$model->s_contactaddress?$model->s_contactaddress:"&nbsp;"?></dd>
			<dt>联系电话</dt><dd><?=$model->s_tel?$model->s_tel:"&nbsp;"?></dd>
			<dt>生源地</dt><dd><?=Lookup::model()->getValueName($model->s_sfromaddress,"studentsfrom")?>&nbsp;</dd>
			<dt>生源状况</dt><dd><?=Lookup::model()->getValueName($model->s_sfromtype,"studentsfromstatus")?>&nbsp;</dd>
			<dt>参加工作时间</dt><dd><?=date("Y-m",$model->s_cjgztime)?>&nbsp;</dd>
			<?php if(in_array($model->s_highesteducation,array(2,3,4,5))){?>
			<dt>原毕业院校</dt><dd><?=$model->s_oldschool?>&nbsp;</dd>
			<dt>原毕业院校代码</dt><dd><?=$model->s_oldschoolcode?$model->s_oldschoolcode:"&nbsp;"?></dd>
			<dt>原毕业专业</dt><dd><?=$model->s_oldzhuanye?>&nbsp;</dd>
			<dt>原毕业时间</dt><dd><?=date("Y-m",$model->s_oldtime)?>&nbsp;</dd>
			<?php }?>
			<dt>原毕业证书编号</dt><dd><?=$model->s_oldimgnumber?>&nbsp;</dd>
			
			<dt>原毕业证书扫描件</dt><dd class="smj-photo">
			<a  class="bwGal" title="原毕业证书扫描件"  rel="gal"   target='_blank' href='<?=$model->s_oldimg?>'><img src="<?=$model->s_oldimg?>	" /></a>&nbsp;
			</dd>
            <?php if(in_array($model->s_baokaocengci,array(2))){?>
            <dt>专升本证明</dt><dd class="smj-photo">
			<a  class="bwGal" title="专升本证明"  rel="gal"  target='_blank' href='<?=$model->s_zsbzm?>'><img src="<?=$model->s_zsbzm?>	" /></a>&nbsp;</dd>
			<?php }?>
			<dt>入学方式</dt><dd><?=isset(Students::$enrollment[$model->s_enrollment])?Students::$enrollment[$model->s_enrollment]:""?>&nbsp;</dd>
			<dt>学习类型</dt><dd><?=isset(Students::$study[$model->s_study])?Students::$study[$model->s_study]:""?>&nbsp;</dd>
			<dt>其他证明材料</dt><dd><a target='_blank' href='<?=$model->s_file?>'><?=$model->s_file?></a>&nbsp;</dd>
			<dt>生源类型</dt><dd><?=isset(Students::$bdtype[$model->s_idbd])?Students::$bdtype[$model->s_idbd]:""?></a>&nbsp;</dd>
            <dt>其他证明材料类型分配</dt><dd><?=isset(Students::$zjtype[$model->s_zjtype])?Students::$zjtype[$model->s_zjtype]:""?></a>&nbsp;</dd>
			
		</dl>
	</div>
</div>	

      </td>
    </tr>
    <?php 
        $application = Application::model()->find("sa_sid = '{$model->s_id}' and  sa_isdel = 1");
        if(Yii::app()->user->id!=5){
        if(isset($application->sa_sid)){
        $sqmodel = Application::model()->findAll("sa_sid='{$model->s_id}' and sa_isdel = 1");
    ?>
    <tr>
        <td>
            <div>
                <dl class="dl-horizontal">
                    <dt>学员申请信息<dt>
                    <dd>
                        <table style="width:100%;max-width:800px    " class="table table-bordered specialtylist">
                            <thead>
                                    <tr>						
                                        <th width="10%">申请类型</th>
                                        <th width="10%">申请时间</th>
                                        <th width="15%">审核状态</th>
                                        <th width="20%">审核时间</th>
                                        <th width="20%">申请操作人</th>
                                        <th width="15%">操作</th>
                                    </tr>
                            </thead>
                            <tbody>
                            <?php foreach($sqmodel as $key=>$data){?>
                                <tr>
                                    <td><?=isset(Application::$type[$data->sa_type])?Application::$type[$data->sa_type]:""?></td>
                                    <td><?=date("Y-m-d",$data->sa_sqtime)?></td>
                                    <td class="<?=$data->sa_status!=1?$data->sa_status==2?"blcolor1":"rcolor":"ycolor"?>"><?=isset(Application::$astatus[$data->sa_status])?Application::$astatus[$data->sa_status]:""?></td>
                                    <td><?=$data->sa_status!='1'?date('Y-m-d',$data->sa_shtime):"待审,无时间"?></td>
                                    <td><?=User::model()->getUserName($data->sa_proposerid)?></td>
                                    <td>
                                        <a href="<?=Yii::app()->createUrl("admin/application/view",array("id"=>$data->sa_id))?>">查看</a>
                                        <?php if(Yii::app()->user->role==4||$data->sa_status!=2){?>
                                        /<a href="<?=Yii::app()->createUrl("admin/application/edit",array("id"=>$data->sa_id))?>">编辑</a>
                                        <?php }?>
                                        <?php  if($data->sa_isdel==1&&(Yii::app()->user->role==4||$data->sa_status!=2)){?>
                                            / <a href="javascript:void(0)" onclick="deleteOne('application','<?=$data->sa_id?>')">删除</a>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </dd>
                </dl>
            </div>
        </td>
    </tr>
    <?php }}?>
<!--     <tr>
      <td>
<div class="form-actions">
<button type="submit" class="btn btn-primary" name="addsubmit" value="add">修改数据</button>&nbsp;
<button type="reset" class="btn">重新填写</button>
</div>
      </td>
    </tr> -->



  </tbody>

</table>
</div>
          </div>