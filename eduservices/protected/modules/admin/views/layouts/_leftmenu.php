<?php 
$controller = Yii::app()->controller->id;  
$action = $this->getAction()->getId(); 
$controlleraction = strtolower($controller.$action);
$typecontrolleraction=isset($_GET['type'])?$controlleraction.$_GET['type']:$controlleraction;
//
?>
 <button class="btn btn-mini btn-primary" style='position:absolute;top:5px;right:10px;' type="button" id='btnleftmenu' onclick='checkaaa()'><?=isset($_COOKIE['showleftmenu'])&&$_COOKIE['showleftmenu']=="hide"?"显示":"隐藏"?></button>

<div class="well sidebar-nav" id="leftmenu" <?=isset($_COOKIE['showleftmenu'])&&$_COOKIE['showleftmenu']=="hide"?"style='display:none'":""?> >
	<ul class="nav nav-list">
    
        
        <li class="nav-header">个人设置</li>
        <div class="divider"></div>
        <li <?=$controlleraction=="userview"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/user/view")?>"><i class="icon-user"></i> 个人信息</a></li>
		
        <?php if(Yii::app()->user->role!=5){?>
		<li class="nav-header">学员录入</li>
		<div class="divider"></div>
        <?php 
        $criteria=new CDbCriteria;
        if(Yii::app()->user->role!="4"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->getUserInfoById($uid); 
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			$criteria->addInCondition('s_addid', $UArr);
		}
        $criteria->addCondition("s_isdel  = '1' ");
        $criteria->addCondition("s_status  = '3' ");
        $bhNUM=Students::model()->count($criteria); ?>
		<li <?=$controlleraction=="studentsindex"?'class="active"':""?> ><a href="<?=Yii::app()->createUrl("admin/students/index")?>"><i class="icon-list"></i> 学员列表(<span class="rcolor"><?=$bhNUM?></span>)</a></li>
		
        <?php if(in_array(Yii::app()->user->role,array(1,2))){ ?>
        <li <?=$controlleraction=="studentsadd"?'class="active"':""?> ><a href="<?=Yii::app()->createUrl("admin/students/add")?>"><i class="icon-plus-sign"></i> 学员添加</a></li>
		<?php } ?>
        
        <?php if(in_array(Yii::app()->user->role,array(4))){
        $criteria=new CDbCriteria;
        if(Yii::app()->user->role!="4"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->getUserInfoById($uid);
			// echo $usermodel->user_organization;
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			$criteria->addInCondition('s_addid', $UArr);
		}
		$criteria->addCondition("s_status ='1'");
		$criteria->addCondition("s_isdel ='1'");
		$checkNUM=Students::model()->count($criteria); ?>
		<li <?=$controlleraction=="studentscheck"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/students/check")?>"><i class="icon-eye-open"></i> 学员审核(<span class="rcolor"><?=$checkNUM?></span>)</a></li>
        <?php }?>
        <?php } ?>
        <li class="nav-header">学员管理</li>
        <div class="divider"></div>
        <li <?=$controlleraction=="studentsmanage"||($controlleraction=="studentsinportsm"&&$typecontrolleraction!="studentsinportsm5")?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/students/manage")?>"><i class="icon-book"></i> 学员管理</a></li>
        
        
        
       
        <?php 
            $criteria=new CDbCriteria;
            $criteria->with="studentinfo";
            if(Yii::app()->user->role!="4"){
                $uid=Yii::app()->user->id;
                $usermodel=User::model()->getUserInfoById($uid); 
                $OArr=Organization::model()->getAllid($usermodel->user_organization);
                $UArr=User::model()->getAllByOid($OArr);
                $criteria->addInCondition('s_addid', $UArr);
            }
            $criteria->addCondition("sa_isdel  = '1' ");
            $criteria->addCondition("sa_status  = '3' ");
            $sqCheckNUM = Application::model()->count($criteria);
        ?>
        <?php if(Yii::app()->user->role!=5){?>
        <li <?=$controlleraction=="applicationindex"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/application/index")?>"><i class="icon-list"></i> 申请管理(<span class="rcolor"><?=$sqCheckNUM?></span>)</a></li>
        <?php }?>
        
        <?php if(in_array(Yii::app()->user->role,array(4))){
            $criteria=new CDbCriteria;
            $criteria->with="studentinfo";
            if(Yii::app()->user->role!="4"){
                $uid=Yii::app()->user->id;
                $usermodel=User::model()->getUserInfoById($uid);
                $OArr=Organization::model()->getAllid($usermodel->user_organization);
                $UArr=User::model()->getAllByOid($OArr);
                $criteria->addInCondition('sa_proposerid', $UArr);
            }
            $criteria->addCondition("sa_status ='1'");
            $criteria->addCondition("sa_isdel ='1'");
            $txCheckNUM = Application::model()->count($criteria);      ?>
        <li <?=$controlleraction=="applicationcheck"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/application/check")?>"><i class="icon-eye-open"></i> 申请审核(<span class="rcolor"><?=$txCheckNUM?></span>)</a></li>
        <?php }?>
        
        <li class="nav-header">新闻公告管理</li>
        <div class="divider"></div>
        <li <?=$controlleraction=="informationindex"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/information/index")?>"><i class="icon-list"></i> 公告列表</a></li>
        <?php if(in_array(Yii::app()->user->role,array(4))){?>
        <li <?=$controlleraction=="informationadd"?'class="active"':""?> ><a href="<?=Yii::app()->createUrl("admin/information/add")?>"><i class="icon-plus-sign"></i> 公告添加</a></li>
        <?php }?>
		<?php
            $criteria=new CDbCriteria;
            $criteria->addCondition("mk_isdel  = '1' ");
            $criteria->addCondition("mk_status= '1' ");
            $mkshNUM = Emapp::model()->count($criteria);
            $criteria=new CDbCriteria;
            if(Yii::app()->user->role!="4"){
                $uid=Yii::app()->user->id;
                $usermodel=User::model()->getUserInfoById($uid); 
                $OArr=Organization::model()->getAllid($usermodel->user_organization);
                $UArr=User::model()->getAllByOid($OArr);
                $criteria->addInCondition('mk_addid', $UArr);
            }
            $criteria->addCondition("mk_isdel  = '1' ");
            $criteria->addCondition("mk_status= '3' ");
            $mkbhNUM = Emapp::model()->count($criteria);
            if(Yii::app()->user->role!=4||in_array(Yii::app()->user->id,array(1,2))){?>
            <li class="nav-header">免考管理</li>
            <div class="divider"></div>        
            <li <?=$controlleraction=="emappindex"?'class="active"':""?> ><a href="<?=Yii::app()->createUrl("admin/emapp/index")?>"><i class="icon-plus-sign"></i> 免考管理(<span class="rcolor"><?=$mkbhNUM?></span>)</a></li>
            <?php if(in_array(Yii::app()->user->role,array(1,2,3))){?>
                 <li <?=$controlleraction=="emappadd"?'class="active"':""?> ><a href="<?=Yii::app()->createUrl("admin/emapp/add")?>"><i class="icon-tags"></i> 免考申请</a></li>
            <?php }?>
            <?php if(Yii::app()->user->role==5||in_array(Yii::app()->user->id,array(1,2))){?>
                <li <?=$controlleraction=="emappauditck"?'class="active"':""?> ><a href="<?=Yii::app()->createUrl("admin/emapp/auditck")?>"><i class="icon-plus-sign"></i> 免考审核(<span class="rcolor"><?=$mkshNUM?></span>)</a></li>
            <?php }?>
            <?php if(Yii::app()->user->role==5||in_array(Yii::app()->user->id,array(1,2))){?>
                <li <?=$typecontrolleraction=="studentsinportsm5"?'class="active"':""?> ><a href="<?=Yii::app()->createUrl("admin/students/inportSM",array("type"=>"5"))?>"><i class="icon-plus-sign"></i> 合并汇总</a></li>
            <?php }?>
        <?php }?>
        
        
         <?php if(Yii::app()->user->role==4){?>
        <li class="nav-header">基础信息设置</li>
        <div class="divider"></div>
        <li <?=$controlleraction=="schoolindex"?'class="active"':""?>><a  href="<?=Yii::app()->createUrl("admin/school/index")?>"><i class="icon-list-alt"></i> 院校管理</a></li>
        <li <?=$controlleraction=="professionalindex"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/professional/index")?>"><i class="icon-book"></i> 专业管理</a></li>
        <li <?=$controlleraction=="piciindex"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/pici/index")?>"><i class="icon-tags"></i> 入学考批次管理</a></li>
       
		<li>
          <a class="t_nav" href="javascript:void(0);" id='xxzx' ><i class="icon-th-list"></i> 学习中心</a>
          <ul class="nav sub-nav nav-list <?=isset($_COOKIE['disxxzx'])&&$_COOKIE['disxxzx']=="block"?'':"hide"?>">
              <li <?=$typecontrolleraction=="organizationindex"?'class="active"':""?> ><a  href="<?=Yii::app()->createUrl("admin/organization/index")?>"><i class="icon-align-justify"></i> 学习中心管理</a></li>
              <li <?=$typecontrolleraction=="organizationindexbaomingdian"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/organization/index/type/baomingdian")?>"><i class="icon-align-justify"></i> 报名点管理</a></li>
              <li <?=$typecontrolleraction=="organizationindexjigou"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/organization/index/type/jigou")?>"><i class="icon-align-justify"></i> 机构管理</a></li>
             <?/*  <li><a href="a_school_map.html"><i class="icon-plus"></i> 中心附属列表</a></li> */?>
          </ul>
        </li>
        <li <?=$controlleraction=="adminstatistics"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/admin/statistics")?>"><i class="icon-tags"></i> 人数统计</a></li>
       
        <?php }?>
        <?php if(Yii::app()->user->role==4){?>
		<!--入学考试管理 begin-->
		<li class="nav-header">入学考试管理</li>
		<div class="divider"></div>
        
		<!--题库管理 begin-->
        <li>
			<a class="t_nav" href="javascript:void(0);" id='tjkgl' ><i class="icon-tasks"></i> 题库集管理</a>
			<ul class="nav sub-nav nav-list <?=isset($_COOKIE['distjkgl'])&&$_COOKIE['distjkgl']=="block"?'':"hide"?> " >
				<li <?=$typecontrolleraction=="examsetindex"?'class="active"':""?> ><a  href="<?=Yii::app()->createUrl("admin/examset/index")?>"><i class="icon-plus"></i> 题库集</a></li>
				<li <?=$typecontrolleraction=="examsetindexsecond"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/examset/index/type/second")?>"><i class="icon-plus"></i> 题库</a></li>
				
            </ul>
		</li>
		<li>
			<a class="t_nav" href="javascript:void(0);" id='tkgl' ><i class="icon-tasks"></i> 题库管理</a>
			<ul class="nav sub-nav nav-list <?=isset($_COOKIE['distkgl'])&&$_COOKIE['distkgl']=="block"?'':"hide"?> " >
				<li <?=$controlleraction=="questionsindex"?'class="active"':""?>><a  href="<?=Yii::app()->createUrl("admin/questions/index")?>"><i class="icon-user"></i> 题库管理</a></li>
				<li <?=$controlleraction=="questionsadd"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/questions/add")?>"><i class="icon-plus"></i> 新增试题</a></li>
				<?php /*
                <li <?=$controlleraction=="questionsexcellead"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/questions/excellead")?>"><i class="icon-download-alt"></i> Excel导入</a></li>
                <li <?=$controlleraction=="questionsbackups"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/questions/backups")?>"><i class="icon-share"></i> 备份题库</a></li>
				<li <?=$controlleraction=="questionsrestore"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/questions/restore")?>"><i class="icon-repeat"></i> 还原题库</a></li>
                */?>
            </ul>
		</li>
		<!--题库管理 end-->
		<!--试卷管理 Begin-->
		<li>
			<a class="t_nav" href="javascript:void(0);" id='sjgl'><i class="icon-tasks"></i> 试卷管理</a>
			<ul class="nav sub-nav nav-list <?=isset($_COOKIE['dissjgl'])&&$_COOKIE['dissjgl']=="block"?'':"hide"?>">
				<li <?=$controlleraction=="papermindex"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/paperm/index")?>"><i class="icon-user"></i> 试卷管理</a></li>
				<li <?=$controlleraction=="papermadd"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/paperm/add")?>"><i class="icon-edit"></i> 新增试卷</a></li>
				<?php  /*   
				<li <?=$controlleraction=="papermaddexcel"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/paperm/addexcel")?>"><i class="icon-download-alt"></i> 新建Excel试卷页面</a></li>
                */?>
			</ul>
		</li>
        <?php }?>
        <?php if(Yii::app()->user->role==4){?>
        <li >
            <a class="t_nav" href="javascript:void(0);" id='ksgl'><i class="icon-tasks"></i> 考试管理</a>
			<ul class="nav sub-nav nav-list <?=isset($_COOKIE['disksgl'])&&$_COOKIE['disksgl']=="block"?'':"hide"?>">
            
                <li <?=$controlleraction=="examarrangementindex"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/examarrangement/index")?>"><i class="icon-user"></i> 排考管理</a></li>
            
               <li <?=$controlleraction=="examindex"?'class="active"':""?>><a href=" <?=Yii::app()->createUrl("admin/exam/index")?>"><i class="icon-hand-right"></i> 考试管理</a></li>
                <li <?=$controlleraction=="examequery"?'class="active"':""?>><a  href="<?=Yii::app()->createUrl("admin/exam/equery")?>"><i class="icon-search"></i> 成绩查询</a></li>
			</ul>
		</li>
        <!--试卷管理 End-->
		<!--入学考试管理 end-->
        <?php  }?>
        <?php if(Yii::app()->user->role==4&&in_array(Yii::app()->user->id,array(1,2,3))){?>
            <li class="nav-header">帐号管理</li>
            <div class="divider"></div>
            <?php if(in_array(Yii::app()->user->id,array(1,2))){?>
            <li <?=$controlleraction=="accountindex"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/account/index")?>"><i class="icon-list"></i> 帐号列表</a></li>
            <li <?=$controlleraction=="accountadd"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/account/add")?>"><i class="icon-plus-sign"></i> 帐号添加</a></li>
            <?php }?>
            <li <?=$controlleraction=="inputlimitsindex"?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/inputlimits/index")?>"><i class="icon-list"></i> 录入限制</a></li>
       <?php }?>
       

	</ul>
</div>
<!--/.well -->