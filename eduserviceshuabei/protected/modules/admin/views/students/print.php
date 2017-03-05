<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title>学校公共服务体系系统-学生信息打印</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="acking">

    <!-- Le styles -->
    <!-- <link href="/css/studentinfo.css" rel="stylesheet"> -->
    <link href="/css/studentinfo.css" rel="stylesheet"><?php /*
    <link media="print" href="/css/print.css" rel="stylesheet">*/?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
    <![endif]-->
	<script language="JavaScript">

window.print();



</script>

  </head>
  <body>
<!--     <p class="print-button">打印本页</p> -->
<?php 
$Umodel=User::model()->findByPk($model->s_addid);
$Omodel=Organization::model()->findByPk($Umodel->user_organization);
$OName=$Omodel->o_id;//$Omodel->o_name."-".$Omodel->o_id;
if($Umodel->user_role==1){
    $OName=$Omodel->o_pid;
    // $POmodel=Organization::model()->findByPk($Omodel->o_pid);
    // $OName=$POmodel->o_id;//$POmodel->o_name."-".$POmodel->o_id;
}

$Pid=$Omodel->o_pid;
$ocode=$Omodel->o_code;
for($i=1;$i<4;$i++){
	if($Omodel->o_pid){
        if($Omodel->o_code&&!$ocode){
            $ocode=$Omodel->o_code;
        }
		$newmodel=@Organization::model()->findByPk($Omodel->o_pid);
		if($newmodel){
			$Omodel=$newmodel;
		}else{
			break;
		}
	}
}

            
     


?>
    <div class="box-print">
    <p class='from-tips'><?="{$model->s_rpc}-{$OName}".str_pad($model->s_insertid,6,0,STR_PAD_LEFT)?></p>
        <h2 class="s-title-t"><img src="/img/bhlogo-200.png" width="80" /><span>北京航空航天大学现代远程教育招生报名登记表</span></h2>
        <div class="s-table">
          <table class="t-table" bordercolor="#000" width="90%" border="1" cellspacing="0">
            <tr>
              <td class="height40" colspan="2"><span class="weight">学习中心名称</span></td>
              <td colspan="3"><?=$Omodel->o_name?></td>
              <td width="20%" rowspan="5" title="贴照片处(一寸近照，免冠彩色，蓝色背景，浅色服装)" ><?php /*if($model->s_headerimg){?><img class="s-size" title="贴照片处(一寸近照，免冠彩色，蓝色背景，浅色服装)" src="<?=$model->s_headerimg?>" /><?php }*/?></td>
            </tr>
            <tr>
              <td class="height40" width="16%"><span class="weight">姓名</span></td>
              <td width="18%"><?=$model->s_name?></td>
              <td width="20%"><span class="weight">性别<span></td>
              <td colspan="2" class="s-select0"><img src="/img/sex-1<?=$model->s_sex=='1'?"-0":""?>.gif"><img src="/img/sex-0<?=$model->s_sex=='0'?"-0":""?>.gif"></td>
            </tr>
            <tr>
              <td class="height40"><span class="weight">出生日期</span></td>
              <td><?=date("Y-m-d",$model->s_birthdate)?></td>
              <td><span class="weight">民族</span></td>
              <td colspan="2"><?=Lookup::model()->getValueName($model->s_nationality,"nationality")?></td>
            </tr>
            <tr>
              <td class="height40"><span class="weight">政治面貌</span></td>
              <td><?=Lookup::model()->getValueName($model->s_politicalstatus,"politicalstatus")?></td>
              <td class="height40"><span class="weight">生源地区</span></td>
              <td colspan="2"><?=Lookup::model()->getValueName($model->s_sfromaddress,"studentsfrom")?></td>
            </tr>
            <tr>
              <td class="height40"><span class="weight">职业状况</span></td>
              <td colspan="4" class="s-select"><img src="/img/work-1<?=$model->s_zhiyezhuangkuang==1?"-0":""?>.gif"><img src="/img/work-2<?=$model->s_zhiyezhuangkuang==2?"-0":""?>.gif"></td>
            </tr>
            <tr>
              <td><span class="weight">证件类型</span></td>
              <td colspan="5" class="s-select">
				  <img src="/img/cred-1<?=$model->s_credentialstype==1?"-0":""?>.gif">
				  <img src="/img/cred-2<?=$model->s_credentialstype==2?"-0":""?>.gif">
				  <img src="/img/cred-3<?=$model->s_credentialstype==3?"-0":""?>.gif">
				  <img src="/img/cred-4<?=$model->s_credentialstype==4?"-0":""?>.gif">
				  <img src="/img/cred-5<?=$model->s_credentialstype==5?"-0":""?>.gif">
			  </td>
            </tr>
            <tr>
              <td><span class="weight">证件号码</span></td>
              <td colspan="5"><?=$model->s_credentialsnumber?></td>
            </tr>
            <tr>
              <td rowspan="3"><span class="weight">原最高学历</span></td>
              <td><span class="weight">原毕业学校</span></td>
              <td colspan="2"><?=$model->s_oldschool?></td>
              <td width="15%"><span class="weight">原毕业专业</span></td>
              <td><?=$model->s_oldzhuanye?></td>
            </tr>
            <tr>
              <td><span class="weight">原毕业层次</span></td>
              <td colspan="2"><?=Students::$highesteducation[$model->s_highesteducation]?></td>
              <td><span class="weight">原毕业时间</span></td>
              <td><?=$model->s_highesteducation==1?"":date("Y-m",$model->s_oldtime)?></td>
            </tr>
            <tr>
              <td><span class="weight">原毕业证书编号</span></td>
              <td colspan="4"><?=$model->s_oldimgnumber?></td>
            </tr>
            <tr>
              <td><span class="weight">工作单位</span></td>
              <td colspan="5"><?=$model->s_gongzuodanwei?$model->s_gongzuodanwei:"&nbsp;"?></td>
            </tr>
            <tr>
              <td><span class="weight">手机</span></td>
              <td colspan="3"><?=$model->s_phone?></td>
              <td><span class="weight">电子邮箱</span></td>
              <td><?=$model->s_email?></td>
            </tr>
            <tr>
              <td><span class="weight">通讯地址</span></td>
              <td colspan="3"><?=$model->s_contactaddress?$model->s_contactaddress:"&nbsp;"?></td>
              <td><span class="weight">邮政编码</span></td>
              <td><?=$model->s_youbian?$model->s_youbian:"&nbsp;"?></td>
            </tr>
            <tr>
              <td><span class="weight">所报专业</span></td>
              <td colspan="3"><?=Professional::model()->getZyName($model->s_baokaozhuanye)?></td>
              <td><span class="weight">所报层次</span></td>
              <td><?=Lookup::model()->getValueName($model->s_baokaocengci,"professionallevel")?></td>
            </tr>
          </table>
        </div>
        <p class="s-tip weight">注：以上所有信息均为必填项。</p>
        <div class="s-sign lineb2">
          <dl>
            <dt>本人确认签字：</dt>
            <dd>&nbsp;</dd>
          </dl>
          <dl>
            <dt>日期：</dt>
            <dd>&nbsp;</dd>
          </dl>
        </div>
        <div class="s-directions">
<h3 class="s-title">报名承诺书</h3>
<p class="s-directions-my">本人自愿报名参加北京航空航天大学现代远程教育<span class='bm_line'>　<?=Lookup::model()->getValueName($model->s_baokaocengci,"professionallevel")?>　</span>层次<span class='bm_line'>　<?=Professional::model()->getZyName($model->s_baokaozhuanye)?>　</span>专业的业余学习，已仔细阅读《招生简章》全部内容。本人郑重承诺如下：</p>
<ul class="s-directions-ul">
  <li>一、本人承诺在报名时提供的一切证明材料和填写的本人信息均合法、真实、有效。</li>
  <li>二、本人承诺所提供的学历证书属于国家承认学历的“国民教育系列”范畴。</li>
  <li>三、若本人所提供的证明材料或学历证书经鉴定不符合上述承诺，本人愿意承担由此所造成的一切后果（包括取消学籍和承担缴纳的学习费用等）。</li>
  <li>四、本人承诺所报名地点为我院授权招生的校外学习中心，该学习中心未有“免试”、“代考”、“包过”、“包毕业”、“百分之百通过率”、“不用考试”、“一年取证”、“考试有答案”、“论文保通过”、“拿证零障碍”等虚假宣传及承诺。</li>
  <li>五、本人承诺入学测试及课程考试由本人携带有效身份证件到学习中心考点参加考试，考试时不违规、不作弊。</li>
  <li>六、本人承诺已被告知学费标准。除在该学习中心缴纳的北航远程学费以外，未向该学习中心缴纳其它任何与学费无关的费用。</li>
  <li>
    七、本人熟读并充分理解以下条款：
    <ul>
      <li>1．本人所报名参加的现代远程高等学历教育属国民教育系列范畴，学习方式为业余学习；符合教育部规定的最低毕业年限以及学校规定的毕业条件方可取得网络高等教育的毕业证书。</li>
      <li>2．根据教育部相关规定，取得本科学历须参加教育部网络教育部分公共课全国统一考试，统考成绩合格作为教育部高等教育学历证书电子注册条件之一。</li>
      <li>3．学习期间如遇国家教育部政策调整，按教育部的新政策执行。如违反以上承诺，本人愿意承担由此所造成的一切后果（包括取消学籍和承担缴纳的学习费用等）。</li>
    </ul>
  </li>
  <li>以上承诺真实、有效，是承诺人的真实意愿。</li>
</ul>
        </div>
        <div class="s-sign">
          <dl>
            <dt>承诺人签字：</dt>
            <dd>&nbsp;</dd>
          </dl>
          <dl>
            <dt>日期：</dt>
            <dd>&nbsp;</dd>
          </dl>
        </div>        
    </div>
  </body>
</html>