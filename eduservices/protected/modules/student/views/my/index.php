
<?php 
$smodel=Students::model()->findByPk(User::model()->getId());
?>
<!-- start top -->
<div id="top">
	<h1 style="margin:0;padding:6px;cursor:default;font-family:微软雅黑,黑体,宋体;">
		<img style="float:left" src="images/bhlogo-68.gif" width="68" />
		<span style="float:left;margin-top:22px;font-size:22px;">北京航空航天大学现代远程教育</span>
	</h1>
	<div class="welcome">
    <span class="welcome-name">欢迎您:<i class="red"><?=$smodel->s_name?></i> 入学考批次:[<i class="red"><?=Pici::model()->getPcById($smodel->s_pc)?></i>]
    性别<i class="red"><?=Students::$sex[$smodel->s_sex]?></i>&nbsp;
    报考层次<i class="red"><?=Lookup::model()->getValueName($smodel->s_baokaocengci,"professionallevel")?></i>&nbsp;
    报考专业<i class="red"><?=Professional::model()->getZyName($smodel->s_baokaozhuanye)?></i>&nbsp;
    
    </span>
        <?php /*<a class="mini-button mini-button-iconTop" iconCls="icon-add">快捷</a>    
            <a class="mini-button mini-button-iconTop" iconCls="icon-edit">首页</a>        
            <a class="mini-button mini-button-iconTop" iconCls="icon-date">消息</a>        
            <a class="mini-button mini-button-iconTop" iconCls="icon-edit">设置</a>        */?>
            <a href="<?=Yii::app()->createUrl('student/my/logout')?>" class="out" iconCls="icon-close"><span><img src="/images/cancel.gif">登出</span></a>             
	</div>
</div>
<!-- end top -->
<!-- start menu -->
       <?=$this->renderPartial('/layouts/_leftmenu');?>
<!-- end menu -->

    <div title="south" region="south" showSplit="false" showHeader="false" height="30" >
        <div style="line-height:28px;text-align:center;cursor:default">
        Copyright ? 北京航空航天大学现代远程教育-华东监管中心 </div>
    </div>
<!-- end mainl -->

