<?php 
$controller = Yii::app()->controller->id;  
$action = $this->getAction()->getId(); 
$controlleraction = strtolower($controller.$action);
$id=isset($_GET['id'])?$_GET['id']:"";

?>
<div class="menu png_bg">
    <ul id="ctl00_ctl00_cphMenu_Menu1_ulmenu1">
        <li><a href="<?php echo DOMAIN?>" <?php echo $controller=="site"?"class='current'":""?> target="_self" >学院首页</a></li>
        <li><a href="<?php echo Yii::app()->createUrl("school/index")?>"  <?php echo $controller=="school"?"class='current'":""?> target="_self" >学院介绍</a></li>
        <li><a href="<?php echo Yii::app()->createUrl("news/index",array("id"=>"4"))?>" <?php echo $controlleraction=="newsindex"&&$id=='4'?"class='current'":""?> target="_self" >招生服务</a></li>
        <li><a href="<?php echo Yii::app()->createUrl("news/index",array("id"=>"1"))?>" <?php echo $controlleraction=="newsindex"&&$id=='1'?"class='current'":""?> target="_self" >网院快讯</a></li>
        <li><a href="<?php echo Yii::app()->createUrl("news/index",array("id"=>"2"))?>" <?php echo $controlleraction=="newsindex"&&$id=='2'?"class='current'":""?> target="_self" >教学教务</a></li>
        <li><a href="<?php echo Yii::app()->createUrl("appendix/index")?>" <?php echo $controller=="appendix"?"class='current'":""?> target="_self" >资料下载</a></li>
        
         
        <?php /*//<li><a href="http://www.beihangonline.com/bh_online.html" target="_blank" >网上报名</a></li>
        $PreFixarray=array("stu","stu0","stu1","stu2","stu3","stu4","stu5","stu6","stu7","stu8","stu9");
        $key=mt_rand(0,10);*/
        $Url="http://hbstu.onlinebeihang.com"; 
        ?>
        <li><a href="<?php echo $Url.Yii::app()->createUrl("/student")?>" target="_blank" >在线考试</a></li>
       <?php /*
        <li id="li5"><a href="jsvascript:void(0)">合作办学</a></li>
        <li id="li6" style="width:92px;"><a href="jsvascript:void(0)">非学历培训</a></li>
        <li id="li7"><a href="jsvascript:void(0)" id="ctl00_ctl00_cphMenu_Menu1_a7" target="_self">课程资源</a></li>
       
        <li id="li8"><a href="jsvascript:void(0)" id="ctl00_ctl00_cphMenu_Menu1_a8" target="_self">网院活动</a></li>
        <li id="li9"><a href="jsvascript:void(0)">学术科研</a></li>
        <li id="li10"><a href="jsvascript:void(0)" id="ctl00_ctl00_cphMenu_Menu1_a9" target="_self">电子学苑</a></li>
        <li id="li11"><a href="jsvascript:void(0)">党建专题</a></li>
        <li id="li12" class="last"><a href="jsvascript:void(0)" id="ctl00_ctl00_cphMenu_Menu1_a4" target="_self">校园地图</a></li>
        */ ?>
    </ul>
</div>