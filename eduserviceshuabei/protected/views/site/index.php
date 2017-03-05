    <script type="text/javascript" src="/js/imgScroll.js"></script>
    <script type="text/javascript" src="/js/ajax_login.js"></script>
    <style type="text/css" charset="utf-8">
        /* See license.txt for terms of usage */
        /** reset styling **/
        .firebugResetStyles {
            z-index: 2147483646 !important;
            top: 0 !important;
            left: 0 !important;
            display: block !important;
            border: 0 none !important;
            margin: 0 !important;
            padding: 0 !important;
            outline: 0 !important;
            min-width: 0 !important;
            max-width: none !important;
            min-height: 0 !important;
            max-height: none !important;
            position: fixed !important;
            transform: rotate(0deg) !important;
            transform-origin: 50% 50% !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: transparent none !important;
            pointer-events: none !important;
            white-space: normal !important;
        }
        .firebugBlockBackgroundColor {
            background-color: transparent !important;
        }
        .firebugResetStyles:before, .firebugResetStyles:after {
            content: "" !important;
        }
        /**actual styling to be modified by firebug theme**/
        .firebugCanvas {
            display: none !important;
        }
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
        .firebugLayoutBox {
            width: auto !important;
            position: static !important;
        }
        .firebugLayoutBoxOffset {
            opacity: 0.8 !important;
            position: fixed !important;
        }
        .firebugLayoutLine {
            opacity: 0.4 !important;
            background-color: #000000 !important;
        }
        .firebugLayoutLineLeft, .firebugLayoutLineRight {
            width: 1px !important;
            height: 100% !important;
        }
        .firebugLayoutLineTop, .firebugLayoutLineBottom {
            width: 100% !important;
            height: 1px !important;
        }
        .firebugLayoutLineTop {
            margin-top: -1px !important;
            border-top: 1px solid #999999 !important;
        }
        .firebugLayoutLineRight {
            border-right: 1px solid #999999 !important;
        }
        .firebugLayoutLineBottom {
            border-bottom: 1px solid #999999 !important;
        }
        .firebugLayoutLineLeft {
            margin-left: -1px !important;
            border-left: 1px solid #999999 !important;
        }
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
        .firebugLayoutBoxParent {
            border-top: 0 none !important;
            border-right: 1px dashed #E00 !important;
            border-bottom: 1px dashed #E00 !important;
            border-left: 0 none !important;
            position: fixed !important;
            width: auto !important;
        }
        .firebugRuler{
            position: absolute !important;
        }
        .firebugRulerH {
        top: -15px !important;
        left: 0 !important;
        width: 100% !important;
        height: 14px !important;
        border-top: 1px solid #BBBBBB !important;
        border-right: 1px dashed #BBBBBB !important;
        border-bottom: 1px solid #000000 !important;
        }
        .firebugRulerV {
            top: 0 !important;
            left: -15px !important;
            width: 14px !important;
            height: 100% !important;
            border-left: 1px solid #BBBBBB !important;
            border-right: 1px solid #000000 !important;
            border-bottom: 1px dashed #BBBBBB !important;
        }
        .overflowRulerX > .firebugRulerV {
            left: 0 !important;
        }
        .overflowRulerY > .firebugRulerH {
            top: 0 !important;
        }
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
        .fbProxyElement {
            position: fixed !important;
            pointer-events: auto !important;
        }
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
        .zsjz{
            margin-left:-5px;
            *margin-left:-8px;
            _margin-left:-8px;
        }
    </style>
    
<div class="cleaner_h5"></div>
<!--左边列开始-->
<div class="navLeft navLeftDefault">
<!-- navigation2 -->
<div class="webpart loginHeight">
    <?php if(Yii::app()->user->isGuest){?>
    <h1><span class="pillar"></span>登录入口</h1>
   
        <div class="logincontent" style=" height:156px;_height:157px">
         <form method='post' action='' onsubmit="return ajax_login()">
            <ul>
                <li>请选择：
                    <select name="logintype" id="login_logintype" class="ddlLineCss" style="width:150px;">
                    <option selected="selected" value="1">华北监管中心</option>
                    </select>
                </li>
                <li>用户名：
                    <input name="username" id="login_username" style="border-color:#999999;border-width:1px;border-style:Solid;width:146px;" type="text" value = "">
                </li>
                <li>密&nbsp;&nbsp;&nbsp;&nbsp;码：
                    <input name="password" id="login_password" style="border-color:#999999;border-width:1px;border-style:Solid;width:146px;" type="password" value = "">
                </li>
                <li>
                    <input  value="登录" class="btn" type="submit">
                    &nbsp;&nbsp;
                    <input  class="btn" value="重置" type="reset">
                    &nbsp;
                </li>
            </ul>
              </form>
        </div>
  
    <?php }else{ ?>
    <h1><span class="pillar"></span>欢迎 <?php echo User::model()->getUserName(Yii::app()->user->id)?>　[<?php echo User::$RoleName[Yii::app()->user->role]?>]</h1>
        <div class="logincontent" style=" height:156px;_height:157px">
            
            <ul>
                <?php 
            if(Yii::app()->user->role==9999){?>
                <li><a target='_blank' href='<?php echo Yii::app()->createUrl("/student")?>'>进入学员平台</a></li>
            <?php }else{?>
                <li><a target='_blank' href='<?php echo Yii::app()->createUrl("/admin")?>'>进入管理平台</a></li>
            <?php }?>
                <li><a href='javascript:void(0)' onclick="ajax_logout()" >退出</a>
                </li>
            </ul>
        </div>
    <?php }?>
</div>

<div class="cleaner_h5"></div>
<style type="text/css">
</style>
<?php if($this->beginCache('siteleftdata', array('duration'=>0))) { ?>
<div class="webpart">
    <h1><span class="pillar"></span><a href="javascript:void(0)">招生服务</a></h1>
    <div class="webpart_nav">
        <ul class="col2">
        <?php $zjlink=Link::model()->findAll("typeid='2' order by listorder");
            foreach($zjlink as $key=>$val){
                if($key%2=="1")continue;
            ?>
            <li <?=$key=="0"?'style="border:0px solid red; "':'class="li_alternating"'?>>      
                <span class="pillar" <?=$key=="0"?'style="border:0px solid red; "':''?>></span>
                <img src="<?=$val->logo?>" alt="<?=$val->name?>" align="absmiddle">
                <a <?=$val->linktype=="1"?"target='_blank'":""?> class="zsjz" title="<?=$val->name?>" href="<?=$val->siteurl?$val->siteurl:"javascript:void(0)"?>"><?=$val->name?></a>
            </li>
            <?php }?>
        </ul>
        <ul class="col2">
            <?php 
            foreach($zjlink as $key=>$val){
                if($key%2=="0"&&$key!=="0")continue;
            ?>
            <li <?=$key=="1"?'style="border:0px solid red; "':'class="li_alternating"'?>>                
                <span class="pillar" ></span>
                <img src="<?=$val->logo?>" alt="<?=$val->name?>" align="absmiddle">
                <a <?=$val->linktype=="1"?"target='_blank'":""?> class="zsjz" title="<?=$val->name?>" href="<?=$val->siteurl?$val->siteurl:"javascript:void(0)"?>"><?=$val->name?></a>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
<div class="cleaner_h5"></div>
<div class="webpart">
    <h1><span class="pillar"></span><a href="javascript:void(0)">合作办学</a></h1>
    <div class="webpart_nav">
        <ul class="col2">
          <?php $zjlink=Link::model()->findAll("typeid='3' order by listorder");
            foreach($zjlink as $key=>$val){
                if($key%2=="1")continue;
            ?>
            <li <?=$key=="0"?'style="border:0px solid red; "':'class="li_alternating"'?>>                
                <span class="pillar" <?=$key=="0"?'style="border:0px solid red; "':''?>></span>
                <img src="<?=$val->logo?>" alt="<?=$val->name?>" align="absmiddle">
                <a <?=$val->linktype==1?"target='_blank'":""?> class="zsjz" title="<?=$val->name?>" href="<?=$val->siteurl?$val->siteurl:"javascript:void(0)"?>"><?=$val->name?></a>
            </li>
            <?php }?>
        </ul>
        <ul class="col2">
            <?php 
            foreach($zjlink as $key=>$val){
                if($key%2=="0"&&$key!=="0")continue;
            ?>
            <li <?=$key=="1"?'style="border:0px solid red; "':'class="li_alternating"'?>>                
                <span class="pillar" ></span>
                <img src="<?=$val->logo?>" alt="<?=$val->name?>" align="absmiddle">
                <a <?=$val->linktype==1?"target='_blank'":""?> class="zsjz" title="<?=$val->name?>" href="<?=$val->siteurl?$val->siteurl:"javascript:void(0)"?>"><?=$val->name?></a>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
<div class="cleaner_h5"></div>
<div class="webpart">
    <h1><span class="pillar"></span><a href="javascript:void(0)">非学历培训</a></h1>
    <div class="webpart_nav">
        <ul class="col2">
          <?php $zjlink=Link::model()->findAll("typeid='4' order by listorder");
            foreach($zjlink as $key=>$val){
                if($key%2=="1")continue;
            ?>
            <li <?=$key=="0"?'style="border:0px solid red; "':'class="li_alternating"'?>>                
                <span class="pillar" <?=$key=="0"?'style="border:0px solid red; "':''?>></span>
                <img src="<?=$val->logo?>" alt="<?=$val->name?>" align="absmiddle">
                <a <?=$val->linktype==1?"target='_blank'":""?> class="zsjz" title="<?=$val->name?>" href="<?=$val->siteurl?$val->siteurl:"javascript:void(0)"?>"><?=$val->name?></a>
            </li>
            <?php }?>
        </ul>
        <ul class="col2">
            <?php 
            foreach($zjlink as $key=>$val){
                if($key%2=="0"&&$key!=="0")continue;
            ?>
            <li <?=$key=="1"?'style="border:0px solid red; "':'class="li_alternating"'?>>                
                <span class="pillar" ></span>
                <img src="<?=$val->logo?>" alt="<?=$val->name?>" align="absmiddle">
                <a <?=$val->linktype==1?"target='_blank'":""?> class="zsjz" title="<?=$val->name?>" href="<?=$val->siteurl?$val->siteurl:"javascript:void(0)"?>"><?=$val->name?></a>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
<div class="cleaner_h5"></div>
<div class="webpart" style=" height:207px;">
    <h1><span class="webpart_more_right"><a class="more" href="<?=Yii::app()->createUrl("appendix/index")?>">更多
</a></span><span class="pillar"></span>资源下载</h1>
    <div>
        <?php $Files=Appendix::model()->findAll("ishome='1' and status='1' order by createtime desc");
        // echo count($Files);
        foreach($Files as $file)
        { ?>
            <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
                <span class="newsdate"></span>
                <span class="pillar"></span>
                <span class="news" title="<?=$file->name?>" style="width:248px;*width:230px;_width:230px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                    <img src="/images/sublist.gif">
                    <span class="pillar"></span>
                    <?php if(time()-$file->createtime<=86400){?>
                        <img src="/images/new.gif" border="0">&nbsp;
                    <?php }else{?>
                        <img src="/images/up.gif" border="0">&nbsp;
                    <?php }?>
                    <a target="_blank" href="<?=$file->fileurl?>" style="color:#36332F" target="_blank"><?=$file->name?></a>
                </span>
            </div>
        <div class="cleaner"></div>
        <?php 
        }?>
        <?php /*<div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
            <span class="newsdate"></span>
            <span class="pillar"></span>
            <span class="news" title="希普统考平台Silverlight插件" style="width:248px;*width:230px;_width:230px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                <img src="/images/sublist.gif">
                <span class="pillar"></span>
                <img src="/images/new.gif" border="0">&nbsp;<a href="javascript:void(0)" style="color:#000000" target="_blank">希普统考平台Silverlight插件</a>
            </span>
        </div>
        <div class="cleaner"></div>
            <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
            <span class="newsdate"></span>
            <span class="pillar"></span>
            <span class="news" title="InternetExplorer 7.0" style="width:248px;*width:230px;_width:230px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                <img src="/images/sublist.gif">
                <span class="pillar"></span><a href="javascript:void(0)" style="color:#36332F" target="_blank">InternetExplorer 7.0</a>
            </span>
        </div>
        <div class="cleaner"></div>
        <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
            <span class="newsdate"></span>
            <span class="pillar"></span>
            <span class="news" title="InternetExplorer 6.0" style="width:248px;*width:230px;_width:230px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                <img src="/images/sublist.gif">
                <span class="pillar"></span><a href="javascript:void(0)" style="color:#36332F" target="_blank">InternetExplorer 6.0</a>
            </span>
        </div>
        <div class="cleaner"></div>
        <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
            <span class="newsdate"></span><span class="pillar"></span>
            <span class="news" title="360浏览器5.0版本" style="width:248px;*width:230px;_width:230px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                <img src="/images/sublist.gif">
                <span class="pillar"></span>
                <a href="javascript:void(0)" style="color:#36332F" target="_blank">360浏览器5.0版本</a>
            </span>
        </div>
        <div class="cleaner"></div>
        <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
            <span class="newsdate"></span>
            <span class="pillar"></span>
            <span class="news" title="Windows media player 11.0" style="width:248px;*width:230px;_width:230px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                <img src="/images/sublist.gif">
                <span class="pillar"></span>
                <a href="javascript:void(0)" style="color:#36332F" target="_blank">Windows media player 11.0</a>
            </span>
        </div>
        <div class="cleaner"></div>
        <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
            <span class="newsdate"></span><span class="pillar"></span>
            <span class="news" title="直播交谈插件" style="width:248px;*width:230px;_width:230px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                <img src="/images/sublist.gif">
                <span class="pillar"></span>
                <a href="javascript:void(0)" style="color:#36332F" target="_blank">直播交谈插件</a>
            </span>
        </div>
        <div class="cleaner"></div>
        */?>
        <div class="cleaner_h5"></div>
        
    </div>
</div>
<div class="cleaner_h5"></div>
<div class="webpart" style="height: 207px; *height: 204px; _height: 205px">
    <h1><a href="javascript:void(0)">校园漫步</a></h1>
    <a href="javascript:void(0)"><div style="height: 182px; *height: 179px; _height: 182px; background: url('images/xymb.jpg') repeat;"></div></a>
</div>
<?php $this->endCache(); } ?>
</div>
<!--左边列结束-->
<!--右边列开始-->
<div class="main mainDefault">
<?php if($this->beginCache('homeflash', array('duration'=>Yii::app()->params->WebCacheTime))) { ?>
<?php 
$slideModels=Scrollpicture::model()->findAll("sp_type='1'  order by sp_order");
?>
<div id="ifocus">
    <div id="ifocus_pic">
        <div id="ifocus_piclist" style="left:0px; top:-185px;">
            <span id="ctl00_ctl00_cphContent_cphContent_PortalFlash1_lab1">
                <ul>
                    <?php foreach($slideModels as $key=>$slide){?>
                    <li ><a href="<?=$slide->sp_link?$slide->sp_link:"javascript:void(0)"?>"><img src="<?=$slide->sp_picture  ?>" style="width:585px;height:185px;"></a></li>
                    <?php  }?>
                </ul>
            </span>
        </div>
        <div id="ifocus_opdiv"></div>
        <div id="ifocus_tx">
            <span id="ctl00_ctl00_cphContent_cphContent_PortalFlash1_lab2">
                <ul>
                     <?php foreach($slideModels as $key=>$slide){?>
                    <li class="<?=$key=="1"?"current":"normal"?>"><p><?=$slide->sp_title?></p></li>
                    <?php  }?>
                </ul>
            </span>
        </div>
    </div>
    <div id="ifocus_btn">
        <span id="ctl00_ctl00_cphContent_cphContent_PortalFlash1_lab3">
            <ul>
                <?php foreach($slideModels as $key=>$slide){?>
                    <li class="<?=$key=="1"?"current":"normal"?>"><img src="<?=$slide->sp_picture  ?>" style="width:75px;height:50px;"></li>
                    <?php  }?>
            </ul>
        </span>
    </div>
</div>
<?php $this->endCache(); } ?>
<div class="cleaner_h5"></div>

<div class="webpart">
    <h1><span class="webpart_more_right"><a class="more" target='_blank' href="<?=Yii::app()->createUrl("news/index",array('id'=>1))?>" >更多</a></span> <span class="pillar"></span><a href="javascript:void(0)">网院快讯</a></h1>
    <div style="padding-top:10px; height:194px">
        <ul class="mainNews">
            <?php 
                $wykximg=array('pic'=>'/images/PageImage_005.jpeg','link'=>'javascript:void(0)');
                foreach($News['wykx'] as $key=>$val){ 
                    if($val->i_pic&&file_exists(DOCUMENTROOT.$val->i_pic)){
                       $wykximg=array('pic'=>$val->i_pic,'link'=>Yii::app()->createUrl("news/detail",array('id'=>$val->i_id)));
                       break;
                    }
                }
            ?>
           
            <li class="img"><a href="<?=$wykximg['link']?>" target="_blank"><img src="<?=$wykximg['pic']?>" style="width:180px;border-width:0px;"></a></li>
            <li class="news">
                <?php foreach($News['wykx'] as $key=>$val){ ?>
                    <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
                        <span class="newsdate"><?=date("(m/d)",$val->i_submitdate)?></span>
                        <span class="pillar"></span>
                        <span class="news" title="<?=$val->i_title?>" style="width:440px;*width:400px;_width:400px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                            <img src="/images/sublist.gif">
                            <span class="pillar"></span>
                            <?php if((time()-$val->i_submitdate<=(7*86400))||$key=='0'){?>
                                <img src="/images/new.gif" border="0">
                            <?php }else{?>
                                <img src="/images/up.gif" border="0">
                            <?php }?>
                           &nbsp;<a href="<?=Yii::app()->createUrl("news/detail",array('id'=>$val->i_id))?>" style="color:#000000" target="_blank"><?=$val->i_title?></a>
                        </span>
                    </div>
               <div class="cleaner"></div>
                <?php }?>
                <div class="cleaner_h5"></div>
            </li>
        </ul>
    </div>
</div>

<div class="cleaner_h5"></div>
<div class="webpart" style="height:228px;*height:229px; _height:226px">
    <h1><span class="webpart_more_right"><a class="more" target='_blank' href="<?=Yii::app()->createUrl("news/index",array('id'=>2))?>" >更多</a></span> <span class="pillar"></span><a href="javascript:void(0)">教学教务</a></h1>
    <div style="padding-top: 10px; height: 196px">
        <ul class="mainNews">
            <?php 
                $hdggimg=array('pic'=>'/images/PageImage_004.jpeg','link'=>'javascript:void(0)');
                foreach($News['hdgg'] as $key=>$val){ 
                    if($val->i_pic&&file_exists(DOCUMENTROOT.$val->i_pic)){
                       $hdggimg=array('pic'=>$val->i_pic,'link'=>Yii::app()->createUrl("news/detail",array('id'=>$val->i_id)));
                       break;
                    }
                }
            ?>
            
            <li class="img"><a href="<?=$hdggimg['link']?>" target="_blank"><img src="<?=$hdggimg['pic']?>" style="width:180px;border-width:0px;"></a></li>
            <li class="news">
                <?php foreach($News['hdgg'] as $key=>$val){ ?>
                    <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
                        <span class="newsdate"><?=date("(m/d)",$val->i_submitdate)?></span>
                        <span class="pillar"></span>
                        <span class="news" title="<?=$val->i_title?>" style="width:440px;*width:400px;_width:400px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                            <img src="/images/sublist.gif">
                            <span class="pillar"></span>
                            <a href="<?=Yii::app()->createUrl("news/detail",array('id'=>$val->i_id))?>" style="color:#000000" target="_blank"><?=$val->i_title?></a>
                        </span>
                    </div>                
                    <div class="cleaner"></div>
                <?php }?>


                <div class="cleaner_h5"></div>
            </li>
        </ul>
    </div>
</div>
<div class="cleaner_h5"></div>

<div class="nTab">
    <!-- 标题开始 -->
    <div class="TabTitle">
        <ul id="ctl00_ctl00_cphContent_cphContent_TabInfos1_ControlID_0">
        <li class="active png" onclick="nTabs(this,0);">
        <span id="ctl00_ctl00_cphContent_cphContent_TabInfos1_Label1">课程资源</span></li>
        <li class="normal png" onclick="nTabs(this,1);">
        <span id="ctl00_ctl00_cphContent_cphContent_TabInfos1_Label2">学术讲座公告</span></li>
        <li class="normal png" onclick="nTabs(this,2);">
        <span id="ctl00_ctl00_cphContent_cphContent_TabInfos1_Label3">讲座在线听</span></li>
        </ul>
    </div>
    <!-- 内容开始 -->
    <div class="TabContent">
        <div id="ctl00_ctl00_cphContent_cphContent_TabInfos1_ControlID_0_Content0">
            <div style="margin:0; padding:5px 15px 0px 15px; clear:both; height:150px;">
                <iframe src="/Portal.htm" frameborder="0" height="170px" scrolling="no" width="660px"></iframe>
            </div>
        </div>
        <div id="ctl00_ctl00_cphContent_cphContent_TabInfos1_ControlID_0_Content1" class="none">
            <div class="mainNews">
                <?php foreach($News['jzgg'] as $key=>$val){ ?>
                <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
                    <span class="newsdate"><?=date("(m/d)",$val->i_submitdate)?></span>
                    <span class="pillar"></span>
                    <span class="news" title="<?=$val->i_title?>" style="width:630px;*width:400px;_width:400px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                        <img src="/images/sublist.gif">
                        <span class="pillar"></span>
                        <a href="<?=Yii::app()->createUrl("news/detail",array('id'=>$val->i_id))?>" style="color:#36332F" target="_blank"><?=$val->i_title?></a>
                    </span>
                </div>
                <div class="cleaner"></div>
                <?php }?>

                <div class="cleaner_h5"></div>
            </div>
            <div class="more"><a target='_blank' href="<?=Yii::app()->createUrl("news/index",array('id'=>3))?>" >更多</a></div>
        </div>
        <div id="ctl00_ctl00_cphContent_cphContent_TabInfos1_ControlID_0_Content2" class="none">
            <div class="mainNews">
                <div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
                    <span class="newsdate">(04/25)</span>
                    <span class="pillar"></span>
                    <span class="news" title="4月26日：移动学习专题讲座" style="width:630px;*width:400px;_width:400px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
                        <img src="/images/sublist.gif">
                        <span class="pillar"></span>
                        <a href="javascript:void(0)" style="color:#36332F" target="_blank">4月26日：移动学习专题讲座</a>
                    </span>
                </div>
                <div class="cleaner"></div>


                <div class="cleaner_h5"></div>
            </div>
            <div class="more"><a href="javascript:void(0)">更多</a></div>
        </div>
    </div>
</div>

<div class="nTab">
<!-- 标题开始 -->
<div class="TabTitle">
    <ul id="ctl00_ctl00_cphContent_cphContent_Activity1_ControlID_0">
        <li class="active png" onclick="nTabs(this,0);"><span id="ctl00_ctl00_cphContent_cphContent_Activity1_Label1">活动专栏</span></li>
        <li class="normal png" onclick="nTabs(this,1);"><span id="ctl00_ctl00_cphContent_cphContent_Activity1_Label2">学院简报</span></li>
    </ul>
</div>
<!-- 内容开始 -->
<div class="TabContent">
<div id="ctl00_ctl00_cphContent_cphContent_Activity1_ControlID_0_Content0">
    <div style="margin:16px 20px 0px 20px; *margin:12px 20px 0px 20px; _margin:13px 20px 0px 20px; text-align:center;">
        <div class="box" style="margin-left: 20px; _margin-left: 10px;">
            <div class="img"><a href="javascript:void(0)" target="_blank"><img src="/images/a1.jpg" alt=""></a></div>
            <div class="txt"><a href="javascript:void(0)" target="_blank">新生报道</a></div>
        </div>
        <div class="box">
            <div class="img"><a href="javascript:void(0)" target="_blank"><img src="/images/a2.jpg" alt=""></a></div>
            <div class="txt"><a href="javascript:void(0)" target="_blank">毕业园地</a></div>
        </div>
        <div class="box">
            <div class="img"><a href="javascript:void(0)" target="_blank"><img src="/images/a3.jpg" alt=""></a></div>
            <div class="txt"><a href="javascript:void(0)" target="_blank">学生之家</a></div>
        </div>
        <div class="box">
            <div class="img"><a href="javascript:void(0)" target="_blank"><img src="/images/a4.jpg" alt=""></a></div>
            <div class="txt"><a href="javascript:void(0)" target="_blank">学生喜乐会</a></div>
        </div>
        <div class="box" style="margin-left:20px; _margin-left:10px;">
            <div class="img"><a href="javascript:void(0)" target="_blank"><img src="/images/a5.jpg" alt=""></a></div>
            <div class="txt"><a href="javascript:void(0)" target="_blank">10周年院庆专题</a></div>
        </div>
        <div class="box">
            <div class="img"><a href="javascript:void(0)" target="_blank"><img src="/images/a6.jpg" alt=""></a></div>
            <div class="txt"><a href="javascript:void(0)" target="_blank">校友会</a></div>
        </div>
        <div class="box">
            <div class="img"><a href="javascript:void(0)" target="_blank"><img src="/images/a7.jpg" alt=""></a></div>
            <div class="txt"><a href="javascript:void(0)" target="_blank">学生手记</a></div>
        </div>
        <div class="box">
            <div class="img"><a href="javascript:void(0)" target="_blank"><img src="/images/a8.jpg" alt=""></a></div>
            <div class="txt"><a href="javascript:void(0)" target="_blank">学习中心活动</a></div>
        </div>
    </div>
</div>
<!-- 学员芳草地 -->
<!-- 学院简报 -->
<div id="ctl00_ctl00_cphContent_cphContent_Activity1_ControlID_0_Content1" class="none">
    <div style="margin: 8px 25px 0px 35px;">
        <span id="ctl00_ctl00_cphContent_cphContent_Activity1_lab">
            <div class="book">
                <div><a href="javascript:void(0)" target="_blank"><img src="/images/PageImage_009.jpeg" alt=""></a></div>
                <div class="txt"><a style="color: #ff0000" href="javascript:void(0)" target="_blank">卷5-期3</a></div>
            </div>
            <div class="book">
                <div><a href="javascript:void(0)" target="_blank"><img src="/images/PageImage_006.jpeg" alt=""></a></div>
                <div class="txt"><a style="color: #ff0000" href="javascript:void(0)" target="_blank">卷5-期2</a></div>
            </div>
            <div class="book">
                <div><a href="javascript:void(0)" target="_blank"><img src="/images/PageImage_009.jpeg" alt=""></a></div>
                <div class="txt"><a style="color: #ff0000" href="javascript:void(0)" target="_blank">卷5-期3</a></div>
            </div>
            <div class="book">
                <div><a href="javascript:void(0)" target="_blank"><img src="/images/PageImage_006.jpeg" alt=""></a></div>
                <div class="txt"><a style="color: #ff0000" href="javascript:void(0)" target="_blank">卷5-期2</a></div>
            </div>
            <div class="book">
                <div><a href="javascript:void(0)" target="_blank"><img src="/images/PageImage_006.jpeg" alt=""></a></div>
                <div class="txt"><a style="color: #ff0000" href="javascript:void(0)" target="_blank">卷5-期2</a></div>
            </div>

        </span>
    </div>
    <div class="cleaner"></div>
    <div class="more"><a href="javascript:void(0)">更多</a></div>
</div>

</div>
</div>

</div>
    <!-- 右边列结束 -->
    <div class="webpart link"><h1><span class="pillar"></span>友情链接</h1>
    <div style="text-align:center;">
        <span><a href="javascript:void(0)" target="_blank"><img src="/images/lj1.jpg" style="padding: 3px 1px 2px 0px;"></a></span>
        <span><a href="javascript:void(0)" target="_blank"><img src="/images/lj1.jpg" style="padding: 3px 1px 2px 0px;"></a></span>
        <span><a href="javascript:void(0)" target="_blank"><img src="/images/lj1.jpg" style="padding: 3px 1px 2px 0px;"></a></span>
    </div>
</div>



<div class="cleaner"></div>
