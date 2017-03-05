<?php
        $this->breadcrumbs=array("首页");
        if(Yii::app()->user->role!=5){
        //驳回记录数
        $SMcriteria=new CDbCriteria;
        $criteria=new CDbCriteria;
        $UArr=array();
        if(Yii::app()->user->role!="4"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->findByPk($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
		}
        
		$checkNUM=Students::model()->getNum($UArr,2,1);
		$OkNUM=Students::model()->getNum($UArr,2,2);
        $bhNUM=Students::model()->getNum($UArr,2,3);
        
        $SMcheckNUM=Students::model()->getNum($UArr,1,1);
        $SMOkNUM=Students::model()->getNum($UArr,1,2);
        $SMbhNUM=Students::model()->getNum($UArr,1,3);
        //排考控制器里的内容
        $criteria=new CDbCriteria;
        $criteria->addCondition(' ea_status = 1 ');
        $criteria->addCondition(' ea_isdel = 1 ');
        $criteria->addCondition(' ea_stime >'.(strtotime(date("Y-m-d"))-86400));
        $criteria->addCondition(' ea_stime <'.(strtotime(date("Y-m-d"))+86400*7));
        $criteria->order='ea_stime asc';
        $criteria->offset='0';
        $criteria->limit='15';
        
        $pageSize=isset($_COOKIE['ea_pagesize'])?$_COOKIE['ea_pagesize']:"20";
        $Arrays = Examarrangement::model()->findAll($criteria);   
        $dlrole=Yii::app()->user->role;   
?>

<?php }?>

<div id="container" class="clearfix">


<?php  
    if(Yii::app()->user->role=='4'){
    $phone=isset($_GET['getcode'])?$_GET['getcode']:'';
    if($phone){
        $Codemodel=Phonemsgcode::model()->find("pmc_phone ='{$phone}' and pmc_time >=".time()." order by pmc_time desc" );
    }
        // echo "http://sdk2.sudas.cn:8060/z_balance.aspx?sn=".SMSUSER."&pwd=".SMSPWD;
        $num=@file_get_contents("http://sdk2.sudas.cn:8060/z_balance.aspx?sn=".SMSUSER."&pwd=".SMSPWD);
        // echo "<p>短信发送服务剩余条数<a>{$num}</a>条</p>";
        // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/js/icheck/skins/all.css",CClientScript::POS_BEGIN );
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/icheck/jquery.icheck.min.js",CClientScript::POS_HEAD );
        
        
        $verifyType=Config::model()->getConfig('verifyType');
?>
    <link href="/js/icheck/skins/all.css" rel="stylesheet">
<script>
    $(document).ready(function(){
  
                
    
    
        $('input.ichick').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
       
        $('ins').click(function(){
             var value = $("input[name='iCheck']:checked").val();
             var selectval='<?=$verifyType?>';
             if(value==selectval)return false;
            var arr = new Array();
                arr[1] = "验证码";
                arr[2] = "速达短信";
                arr[3] = "XX短信";
            var ok=confirm('确认修改为'+arr[value]+"?");
            if(ok){
                $.ajax({
                    type: "POST",
                    url: '<?=Yii::app()->createUrl("/admin/admin/changeverifytype")?>',
                    data: {'value':value},
                    async:true,
                    success: function(msg){
                        if(msg=='ok'){
                            alert('设置成功！')
                            // window.location.reload();
                        }else{
                            alert('设置失败！')
                            window.location.reload();
                        }
                    }
                });
            }else{
                 window.location.reload();
            }
            
        });
      
                
       
    });
    </script>
    <style>
    .verify-ichick { overflow:hidden;}
    .verify-ichick-sub { height:24px;border-bottom: 1px dashed #dddddd; margin-top:10px;}
    .iradio_flat-blue { float:left; margin-right:5px;display:inline;}
    </style>
<div class="dw-float box col1">


<table class="table table-bordered info" width="100%">
    <thead>
        <tr>
            <th><span class="pull-left">学员登录验证模式</span></th>
        <tr>
    </thead>
    <tbody>
        <tr>

            <td>
                <div class="verify-ichick">
                   <div class="verify-ichick-sub"><input class='ichick'  type="radio" name="iCheck" value='1'  <?=$verifyType=="1"?"checked='checked'":""?>><span>验证码</span></div>
                   <div class="verify-ichick-sub"><input class='ichick' type="radio" name="iCheck" value='2' <?=$verifyType=="2"?"checked='checked'":""?> ><span>速达短信</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class='hcolor'>短信发送服务剩余条数<a><?=$num?></a>条</span></div>
                   <?php /*<div class="verify-ichick-sub"><input class='ichick' type="radio" name="iCheck" value='3' <?=$verifyType=="3"?"checked='checked'":""?> ><span>XX短信</span></div>*/?>
               </div>
                
            </td>

            
        </tr> 
        <tr>

            <td>
                <div class="verify-ichick">
                   <input id="codephone" value="<?=$phone?>">
                   <button class="btn btn-mini btn-primary" type="button" id="btnleftmenu" onclick="if(+$('#codephone').val().length==11){location.href='/admin/admin/index/getcode/'+$('#codephone').val()}else{alert('手机号码错误')}">查询</button>
                
                    <?php
                    if($phone){
                        if($Codemodel){
                            echo "验证码：<span style='color:blur   '>{$Codemodel->pmc_code}<span>，有效期：".date("Y-m-d H:i:s",$Codemodel->pmc_time );
                        }else{
                            echo "查询无结果";
                        }
                    }
                    ?>
               </div>
                
            </td>

            
        </tr>
    </tbody>
</table>  
</div>
<?php }?>

<div class="dw-float box col1">
<table class="table table-bordered info" width="100%">
    <thead>
        <tr>
            <th><span class="pull-left">最新公告</span><a class="pull-right" href="<?=Yii::app()->createUrl("admin/information/index")?>">更多</a></th>
        <tr>
    </thead>
    <tbody>
        <tr>

            <td>
                <?php $newsArrays = Information::model()->getAllById('5','5','i_submitdate desc','','1');
                    foreach($newsArrays as $key=>$newsdata){
                ?>
                    <dl class="info-new"><dt><a href="<?=Yii::app()->createUrl("admin/information/view",array("id"=>$newsdata->i_id))?>" title="<?=$newsdata->i_title?>">[<?=$key+1?>] <?=$newsdata->i_title?></a></dt><dd><?=date("Y-m-d",$newsdata->i_submitdate)?></dd></dl>
                <?php } ?>
            </td>

            
        </tr>
    </tbody>
</table>   
</div>
<?php if(Yii::app()->user->role!=5){?>
<div class="dw-float box col1">
<table class="table table-bordered info" width="100%">
    <thead>
        <tr>
            <th colspan="2">平台人数统计</th>
        <tr>
    </thead>
    <tbody>
    <tr>
        <td wdith="50%">学员列表人数 <font color="#0088CC"><?=$bhNUM+$checkNUM+$OkNUM?></font></td>
        <td>学员管理人数 <font color="#0088CC"><?=$SMbhNUM+$SMcheckNUM+$SMOkNUM?></font></td>
    </tr>
    <tr>
        <td>您有<a href='<?=Yii::app()->createUrl('admin/students/index',array("s_status"=>"1","smtype"=>"2"))?>'><?=$checkNUM?></a>条待审核的记录  <a href='<?=Yii::app()->createUrl('admin/students/index',array("s_status"=>"1","smtype"=>"2"))?>' >查看</a></td>
        <td>您有<a href='<?=Yii::app()->createUrl('admin/students/manage',array("sm_status"=>"3"))?>' ><?=$SMbhNUM?></a>不录取学员  <a href='<?=Yii::app()->createUrl('admin/students/manage',array("sm_status"=>"3"))?>' >查看</a></td>
       </tr>
    <tr>
        <td>您有<a href='<?=Yii::app()->createUrl('admin/students/index',array("s_status"=>"2","smtype"=>"2"))?>'><?=$OkNUM?></a>条已审核的记录  <a href='<?=Yii::app()->createUrl('admin/students/index',array("s_status"=>"2","smtype"=>"2"))?>' >查看</a></td>
        <td>您有<a href='<?=Yii::app()->createUrl('admin/students/manage',array("sm_status"=>"1"))?>'><?=$SMcheckNUM?></a>未确认学员  <a href='<?=Yii::app()->createUrl('admin/students/manage',array("sm_status"=>"1"))?>' >查看</a></td>
    </tr>
    <tr>
        <td>您有<a href='<?=Yii::app()->createUrl('admin/students/index',array("s_status"=>"3","smtype"=>"2"))?>' ><?=$bhNUM?></a>条审核驳回的记录  <a href='<?=Yii::app()->createUrl('admin/students/index',array("s_status"=>"3","smtype"=>"2"))?>' >查看</a></font></td>
        <td>您有<a href='<?=Yii::app()->createUrl('admin/students/manage',array("sm_status"=>"2"))?>'><?=$SMOkNUM?></a>已录取学员  <a href='<?=Yii::app()->createUrl('admin/students/manage',array("sm_status"=>"2"))?>' >查看</a></td>
    </tr>
    <?php   
        $criteria=new CDbCriteria;
        if(Yii::app()->user->role=="4"){
            $criteria->addCondition("s_isdel  = '2' ");
            $delNum=Students::model()->count($criteria);
    ?>
    <tr class="rcolor">
        <td colspan="2"><i>有<a href='<?=Yii::app()->createUrl('admin/students/index',array("type"=>"2","smtype"=>"1"))?>'><?=$delNum?></a>条被删除的记录  <a href='<?=Yii::app()->createUrl('admin/students/index',array("type"=>"2","smtype"=>"1"))?>' >查看</a></i></td>
    </tr>
    <?php  } ?>
    <tbody>
</table>
</div>

<div class="dw-float box col1">
<table class="table table-bordered info" width="100%">
    <thead>
        <tr>
            <th colspan="5">近期(7天内)排考列表</th>
        <tr>
        <tr class="info-center">
            <th width="10%">排考场次</th>
            <th width="12%">入学考批次</th>
            <th >试卷名称</th>
            <th width="30%">考试时间</th>
            <th width="8%">类别 </th>
            <th width="8%">操作 </th>
        <tr>
    </thead>
    <tbody>
        <?php if(!$Arrays){ ?>
        <tr>
            <td colspan='6'>暂无最新排考信息</td>
        </tr>
        <?php }else{
            foreach($Arrays as $key=>$data){
                $this->renderPartial("_view",array("data"=>$data,"key"=>$key));
            }
        }  ?>
    </tbody>
</table>
</div>


<?php
foreach($Arrays as $key=>$data){
//$this->renderPartial("_view",array("data"=>$data,"key"=>$key));
// echo $data->ea_pkid;  
$criteria=new CDbCriteria;
if($dlrole==4){
$userarr=User::model()->findAll("user_role!=4");//屏闭管理员录入的学员
$ararry=array();
foreach($userarr as $v){ $ararry[]=$v["user_id"];}
$criteria->addInCondition('s_addid', $ararry);
}
if($data->ea_type==2){
    $pkArr=$Sarr=array();
    $pkModel=Examarrangement::model()->findAll("ea_pkid  ='{$data->ea_pkid}' ");
    foreach($pkModel as $pkey=>$pval)$pkArr[]=$pval->ea_id;
    $acriteria=new CDbCriteria;
    $acriteria->select="sc_sid,sc_kgmark";
    $acriteria->addInCondition('sc_pkid', $pkArr);
    $acriteria->addCondition("sc_kgmark  is not  NULL "); 
    $acriteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1")';
    $Scoremodels=Score::model()->findAll($acriteria);
    foreach($Scoremodels as $score)$Sarr[]=$score->sc_sid;
    $criteria->addNotInCondition('s_id', $Sarr);
    $criteria->addCondition("s_enrollment =1");
    
}
$criteria->addCondition("s_isdel  = '1' ");
$criteria->addCondition("s_status ='2'");
$criteria->addCondition("s_pc ='{$data->ea_pkid}'");

$sdNum=Students::model()->count($criteria);
$rxkPcArr=Pici::model()->getAllPC(true,false);
$rxkPc=isset($rxkPcArr[$data->ea_pkid])?$rxkPcArr[$data->ea_pkid]:$data->ea_pkid;
if($dlrole!=4){
$criteria->addCondition("s_addid ='".Yii::app()->user->id."'");
$sdNum=Students::model()->count($criteria);
// if($sdNum){
// $aa=Students::model()->find($criteria);
// $sm=$aa?StudentsManage::model()->count("sm_sid ='{$aa->s_id}'"):false;
// $action=$sm?"manage":"index";
// }
$action='index';
if($sdNum>0){ ?> 
<div class="dw-float box col1">
<p>
您有<a href='<?=Yii::app()->createUrl('admin/students/'.$action,array("s_pc"=>$data->ea_pkid,"s_status"=>"2"))?>'><?=$sdNum?></a>
位学员在<font color=red>[<?=$data->ea_id?>]</font>场次中安排了考试<span class='blcolor1'>[<?=Examarrangement::$type[$data->ea_type]?>]</span>！入学考批次为<font color=green><?=$rxkPc?></font>
<a href='<?=Yii::app()->createUrl('admin/students/'.$action,array("s_pc"=>$data->ea_pkid,"s_status"=>"2","marktype"=>$data->ea_type==2?2:""))?>' >查看</a>
</p>
</div>
<?php 
}
}else{  
// if($sdNum){
// $aa=Students::model()->find($criteria);
// $sm=$aa?StudentsManage::model()->count("sm_sid ='{$aa->s_id}'"):false;
// $action=$sm?"manage":"index";
// }
$action='index';
if($sdNum>0){ ?>
<div class="dw-float box col1">
<p>
您有<a href='<?=Yii::app()->createUrl('admin/students/'.$action,array("s_pc"=>$data->ea_pkid,"s_status"=>"2"))?>'><?=$sdNum?></a>
位学员在<font color=red>[<?=$data->ea_id?>]</font>场次中安排了考试<span class='blcolor1'>[<?=Examarrangement::$type[$data->ea_type]?>]</span>！入学考批次为<font color=green><?=$rxkPc?></font>
<a href='<?=Yii::app()->createUrl('admin/students/'.$action,array("s_pc"=>$data->ea_pkid,"s_status"=>"2","marktype"=>$data->ea_type==2?2:""))?>' >查看</a>
</p>

<table class="table table-bordered info" width="100%">
<thead>
<tr class="info-center">
<th >报名点</th>
<th >帐号</th>
<th >负责人昵称</th>
<th >参考人数</th>
<th >操作</th>
</tr>
</thead>
<tbody>
<?php
foreach($userarr as $val){

$cra=new CDbCriteria;        
$cra->with="manageinfo";
$cra->addCondition("s_isdel  = '1' ");
$cra->addCondition("s_status ='2'");
$cra->addCondition("s_pc ='{$data->ea_pkid}'");
$cra->addCondition("s_addid ={$val["user_id"]}");
if($data->ea_type==2){
    $cra->addNotInCondition('s_id', $Sarr);
    $cra->addCondition("s_enrollment =1");
    
}
$fsdNum=Students::model()->count($cra);
$organmodel=Organization::model()->find("o_id={$val["user_organization"]}"); 
if($fsdNum>0){
$aa=Students::model()->find($cra);
$action="index";
}
if($dlrole!=4){                                   
if($val["user_id"]==Yii::app()->user->id&&$fsdNum>0){                                                 
$this->renderPartial("_pdview",array("action"=>$action,"data"=>$data,"key"=>$key,"organmodel"=>$organmodel,"val"=>$val,"fsdNum"=>$fsdNum));
}                              
}else{                              
if($fsdNum>0){
$this->renderPartial("_pdview",array("action"=>$action,"data"=>$data,"key"=>$key,"organmodel"=>$organmodel,"val"=>$val,"fsdNum"=>$fsdNum));
}
}
}
echo "</tbody></table></div>";
}
}

// echo "<font color=red>{$data->ea_id}</font>场次中安排了考试！入学考批次为<font color=green>{$rxkPc}</font>";
}
?>

<?php
    /*if(Yii::app()->user->role!='4'){
    $Ilimits=Inputlimits::model()->findAll("il_uid = '".Yii::app()->user->id."'");
?>
<div class="dw-float box col1">
<table class="table table-bordered info" width="100%">
    <thead>
        <tr>
            <th colspan="2">当前帐号的录入人数限制</th>
        <tr>
        <tr class="info-center">
            <th width="10%">入学批次</th>
            <th width="15%">录入上限制</th>
        <tr>
    </thead>
    <tbody>
        <?php  
            if($Ilimits){
            foreach($Ilimits as $il){
            $Tatol=Students::model()->count("s_rpc = '{$il->il_pc}' and s_isdel = 1 and s_addid =".Yii::app()->user->id);
        ?>
        <tr>
            <td><?=$il->il_pc?>批次</td>
            <td><?=$il->il_limit?>人(已录<?=$Tatol?>人)</td>
        </tr>
        <?php }
            }else{
            echo "<td colspan='2'>不限制人数</td>";
        } ?>
    </tbody>
</table>
</div>
<?php }*/ ?>
<script>
  $(function(){
    $('#container').masonry({
      itemSelector: '.box'
    });
  });
</script>
<script src="/js/masonry/jquery.masonry.min.js"></script>
<script src="/js/masonry/jquery.infinitescroll.min.js"></script>
<?php }?>
</div>