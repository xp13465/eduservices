<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->breadcrumbs=array(
	'帐号管理'=>array("admin/index"),
	'帐号列表'=>array("index"),
	'帐号查看',
);

$url=isset($_COOKIE['userreturnurl'])?$_COOKIE['userreturnurl']:array("index");
$this->menu=array(
	array('label'=>'返回帐号列表', 'url'=>$url),
    array('label'=>'编辑', 'url'=>array("edit",'id'=>$model->user_id)),
);
?>
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
<div class="nocolumn column">
	<div>
		<dl class="dl-horizontal">
			<dt>帐号</dt><dd><?=$model->user_name?$model->user_name:'&nbsp;'?></dd>
			<dt>负责人</dt><dd><?=$model->user_nkname?$model->user_nkname:'&nbsp;'?></dd>
			<dt>负责人照片</dt><dd><img src="<?=$model->user_headimg?$model->user_headimg:'/img/photo.jpg'?>" /></dd>
			<dt>联系电话</dt><dd><?=$model->user_tel?$model->user_tel:'&nbsp;'?></dd>
			<dt>手机号码</dt><dd><?=$model->user_phone?$model->user_phone:'&nbsp;'?></dd>
			<dt>邮箱</dt><dd><?=$model->user_email?$model->user_email:'&nbsp;'?></dd>
			<dt>通讯地址</dt><dd><?=$model->user_adderss?$model->user_adderss:'&nbsp;'?></dd>
			<dt>网址</dt><dd><?=$model->user_webset?$model->user_webset:'&nbsp;'?></dd>
			<dt>所属学习中心</dt><dd><?=isset($OModel[count($OModel)-1])?$OModel[count($OModel)-1]['o_name']:'&nbsp;'?></dd>
			<dt>所属报名点</dt><dd><?=isset($OModel[count($OModel)-2])?$OModel[count($OModel)-2]['o_name']:'&nbsp;'?></dd>
			<dt>所属机构</dt><dd><?=isset($OModel[count($OModel)-3])?$OModel[count($OModel)-3]['o_name']:"&nbsp;"?></dd>
			<dt>帐号状态</dt><dd><span class="blcolor1"><?=$model->user_status==1?"启用":"禁用"?></span></dd>
            <dt>可录入区号</dt><dd><?=$model->user_sfqz?$model->user_sfqz:'&nbsp;'?></dd>
            <dt>本地区号</dt><dd><?=$model->user_bddm?$model->user_bddm:'&nbsp;'?></dd>
            <dt>权限备注</dt><dd><?=$model->user_rolebz?$model->user_rolebz:'&nbsp;'?></dd>
            <dt>权限备注</dt><dd><?=$model->user_rolebz?$model->user_rolebz:'&nbsp;'?></dd>
            <?php $Arr= unserialize($model->user_authorize);?>
            <dt>API授权</dt><dd>
            <?=isset($Arr['synlogin'])&&$Arr['synlogin']==1?"同步登录<br/>":""?>
            <?=isset($Arr['synlogin'])&&$Arr['synlogin']==2?"无条件同步登录<br/>":""?>
            <?=isset($Arr['synlogout'])&&$Arr['synlogout']==1?"同步登出<br/>":""?>
            <?=isset($Arr['changepwd'])&&$Arr['changepwd']==1?"同步修改密码<br/>":""?>
            <?=isset($Arr['diyinsert'])&&$Arr['diyinsert']==1?"学员高级录入<br/>":""?>
            <?=isset($Arr['synbeihang'])&&$Arr['synbeihang']==1?"北航同步帐号<br/>":""?>
            </dd>
            <dt>最后登录IP</dt><dd><?=$model->user_lastip?$model->user_lastip:'&nbsp;'?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$model->user_lasttime?date("Y-m-d H:i:s",$model->user_lasttime):''?></dd>
            
            <dt>登录次数</dt><dd><?=$model->user_loginnum ?$model->user_loginnum :'&nbsp;'?></dd>
            <dt>已录人数</dt><dd>
            <table class="table table-bordered specialtylist" style='width:500px;' >
            <thead>
					<tr>						
						<th width="50%">入学批次</th>
						<th width="50%">已录人数</th>
					</tr>
			</thead>
            <?php  
            $criteria = new CDbCriteria;
            $criteria->select='count(s_rpc) as s_id ,s_rpc'; 
            $criteria->group='s_rpc'; 
            $criteria->compare("s_addid",$model->user_id);
            $criteria->compare("s_isdel",1);
            $Smodel=Students::model()->findAll($criteria);
                $Ilimits=Inputlimits::model()->findAll("il_uid = '{$model->user_id}'");
                foreach($Smodel as $smodel){?>
                <tr>
                <td><?=$smodel->s_rpc?>批次 </td>
                <td><?=$smodel->s_id?$smodel->s_id:0?>人</td>
                </tr>
            <?php   }?>
            </table>
            </dd>
            <dt>录入人数限制</dt><dd>
            <table class="table table-bordered specialtylist" style='width:500px;' >
            <thead>
					<tr>						
						<th width="30%">入学批次</th>
						<th width="30%">录入上限</th>
						<th width="40%">操作&nbsp;&nbsp;<a class="btn btn-mini btn-primary" href="<?=Yii::app()->createUrl("admin/inputlimits/create",array("uid"=>$model->user_id))?>"></i>添加</a></th>
					</tr>
			</thead>
            <?php  
                $Ilimits=Inputlimits::model()->findAll("il_uid = '{$model->user_id}'");
                foreach($Ilimits as $il){?>
                <tr>
                <td><?=$il->il_pc?>批次 </td>
                <td><?=$il->il_limit?>人</td>
                <td>
                    <a class="btn btn-mini btn-primary" href="<?=Yii::app()->createUrl("admin/inputlimits/update",array("id"=>$il->il_id))?>"></i>修改</a>&nbsp;&nbsp;<a class="btn btn-mini btn-primary" href="javascript:void(0)" onclick="deleteOne('inputlimits','<?=$il->il_id?>')"> 删除</a>
                </td>
                </tr>
            <?php   }?>
            </table>
            </dd>
            <?php /*
            <dt>辅导老师</dt><dd>
                <table class="table table-bordered specialtylist" style='width:500px;'>
                    <thead>
                        <tr>
                            <th width="30%">姓名</th>
                            <th width="30%">管理上限</th>
                            <th width="40%">操作 &nbsp;&nbsp;
                                <a class="btn btn-mini btn-primary" href="<?=Yii::app()->createUrl("admin/teacher/add",array("uid"=>$model->user_id))?>">添加</a>
                            </th>
                        </tr>
                    </thead>
                    <?php 
                        $Telists = Teacher::model()->findAll("te_relationid = '{$model->user_id}'");
                        foreach($Telists as $te){?>
                            <tr>
                                <td><?=$te->te_name?></td>
                                <td><?=$te->te_toplimit?></td>
                                <td><a href="<?=Yii::app()->createUrl("admin/teacher/edit",array("id"=>$te->te_id))?>">编辑</a></td>
                            </tr>
                    <?php   }?>
                </table>
            </dd>*/?>
            <?php $IpArr= explode(",",$model->user_iparr);?>
            <dt>登录历史IP</dt><dd>
            <a class="btn btn-primary" href="<?=Yii::app()->createUrl("admin/account/view",array("id"=>$model->user_id,"type"=>'clean'))?>">清空保留最近5次登录IP</a><br/>
            <?php  foreach($IpArr as $IP){
                if($IP==" ")continue;
                    $qqwry = Yii::app()->ip;
                    $ip = $qqwry->getlocation($IP);
                    $encode_array = array('ASCII', 'UTF-8', 'GBK', 'GB2312', 'BIG5');
                    $encoded = mb_detect_encoding($ip['country'], $encode_array);
                    $to = 'UTF-8';
                    if($encoded != $to) {
                        $country = mb_convert_encoding($ip['country'], $to, $encoded);
                    }else{
                        $country=$ip['country'];
                    }
                    echo $IP."---".$country."<br/>";
                }?>&nbsp;
            </dd>
		</dl>
	</div>
</div>