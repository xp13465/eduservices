<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>北航远程教育学院</title>
<link rel="stylesheet" type="text/css" href="/css/matriculate.css">
</head>


<?php if($return){?>
<script>
alert('<?=$return?>');
</script>
<?php }?>
<?php if($return&&$Smodel&&$Smodel->sm_status==2){
$Umodel=User::model()->findByPk($Smodel->studentinfo->s_addid);
$Omodel=Organization::model()->findByPk($Umodel->user_organization);


$OName=$Omodel->o_name."-".$Omodel->o_id;
if($Umodel->user_role==1){
    $POmodel=Organization::model()->findByPk($Omodel->o_pid);
    $OName=$POmodel->o_name."-".$POmodel->o_id;
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
<body >
<div id="matriculate-box">
	<div class="matriculate-info matriculate-bg">
		<div class="matriculate-text">
			<p class="matriculate-code">编号：<span class="line"><?=$Smodel->sm_bmorder?></span></p>
			<p class="matriculate-name"><span class="line"><?=$Smodel->studentinfo->s_name?></span>同学：</p>
			<p class="matriculate-note">
            <span class="width50">&nbsp;</span>
            经考试审核，决定录取你入北京航空航天大学现代远程教育学院
            <span class="line-ds"><?=Professional::model()->getZyName($Smodel->studentinfo->s_baokaozhuanye)?></span>
            专业（<span class="line-mini-kh">&nbsp;</span><?=Lookup::model()->getValueName($Smodel->studentinfo->s_baokaocengci,"professionallevel")?>
            <span class="line-mini-kh">&nbsp;</span>）学习，请你准时于<span class="line-mini">&nbsp;</span>
            月<span class="line-mini">&nbsp;</span>日凭本通知到北京航空航天大学现代远程教育
            <span class="line-ds"><?=Common::strCut($Omodel->o_name,24)?>
            </span>学习中心报到注册。</p>
			<p class="matriculate-sign">北京航空航天大学</br>现代远程教育学院</br>二〇一三 年 八 月</p>
		</div>
	</div>
	<div class="matriculate-tip">
		请已录取学生，及时至北航远程官方授权学习中心注册、交费。
	</div>
</div>
<?php }else{ ?>
<body id="body-bg">
<div id="main">
	<div id="login">
		<form action="" method="post" target=_top name="user_form">
	  <table cellspacing="0" cellpadding="0" width="270px">
	    <tr>
	      <td width="30%" height="40px">证件号码：</td>
	      <td width="70%" colspan="2" align="left"><input maxlength="50" size="23" name="cardnumber" value="<?=isset($_POST['cardnumber'])?$_POST['cardnumber']:""?>" /></td>
        </tr>
	    <tr>
	      <td width="30%" height="40px">&nbsp;手机号：</td>
	      <td colspan="2" align="left"><input maxlength="20" size="23" type="text" value="<?=isset($_POST['phone'])?$_POST['phone']:""?>" name="phone" /></td>
        </tr>
        <tr>
	      <td height="40px" colspan="3" align="center"><a href="javascript:document.user_form.submit()" >
	      	<img src="/images/button.gif" width="88" height="26" border=0/></a></td>
        </tr>
      </table>
	 </form>
	</div>
</div>
<?php }?>
</body>
</html>
