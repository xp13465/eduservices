<?php 
$REWRITE_URL=isset($_SERVER['REDIRECT_URL'])?$_SERVER['REDIRECT_URL']:$_SERVER['REQUEST_URI'];
$PreFixarray=array("stu","stu0","stu1","stu2","stu3","stu4","stu5","stu6","stu7","stu8","stu9");
$urlArr=explode(".",$_SERVER['HTTP_HOST']);
$urlArr1=explode("/",$_SERVER['REQUEST_URI']);

    if($urlArr[0]!='api'){
        // require("update.html");
        // exit;
    }
if($REWRITE_URL=="/site/getphonecode.html"){


}else{
    if($urlArr[0]=='api'){
        if(!isset($urlArr1[1])||$urlArr1[1]!='api'){
            header("Location:http://api.onlinebeihang.com/api");
        }
    }elseif($urlArr[0]=='bh'){
        if(!isset($urlArr1[1])||$urlArr1[1]!='admin'){
            // header("Location:http://bh.onlinebeihang.com/admin");
        }
    }elseif(in_array($urlArr[0],$PreFixarray)){
        if(!isset($urlArr1[1])||$urlArr1[1]!='student'){
            header("Location:http://{$urlArr[0]}.onlinebeihang.com/student");
        }
    }

}
date_default_timezone_set("PRC");

// change the following paths if necessary
$yii=dirname(__FILE__).'/protected/yii.php';
$yii=dirname(__FILE__).'/framework/yiilite.php';


$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',false);
// defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER',false);
// defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
 
if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false && ($urlArr[0]!='api'&&$urlArr[0]!='stu'&&$urlArr1[1]!='student'))
{ 
   // header('Location: /noread.html');?>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>请升级您的浏览器</title>
<!--[if lt IE 7]>
<div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;'>    
<div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'>
</div>
<div style='width: 840px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>      
<div style='width: 75px; float: left;'><img src='/images/ie6nomore-warning.jpg' alt='Warning!'/></div>      
<div style='width: 475px; float: left; font-family: Arial, sans-serif;'>        
<div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>您正在使用已经过时的IE 6浏览器！</div>        
<div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>由于IE 6的安全问题以及对互联网标准的支持问题，本网站不支持IE6！<br/>建议您升级您的浏览器，以达到更好的浏览效果！</div>     
</div>      
<div style='width: 75px; float: left;'><a href='http://www.firefox.com' target='_blank'><img src='/images/ie6nomore-firefox.jpg' style='border: none;' alt='Get Firefox'/></a></div>      
<div style='width: 75px; float: left;'><a href='http://www.browserforthebetter.com/download.html' target='_blank'><img src='/images/ie6nomore-ie8.jpg' style='border: none;' alt='Get Internet Explorer'/></a></div>      
<div style='width: 73px; float: left;'><a href='http://www.apple.com/safari/download/' target='_blank'><img src='/images/ie6nomore-safari.jpg' style='border: none;' alt='Get Safari'/></a></div>      
<div style='float: left;'><a href='http://www.google.com/chrome' target='_blank'><img src='/images/ie6nomore-chrome.jpg' style='border: none;' alt='Get Google Chrome'/></a></div>    
</div>  
</div>  
<![endif]-->
 
 <?php 
}
else
{
	require_once($yii);
	Yii::createWebApplication($config)->run();
}

?>
