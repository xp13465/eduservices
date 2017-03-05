<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="acking">
<link href="/css/login.css" rel="stylesheet">
<!--[if lt IE 9]>
  <script src="/js/html5.js"></script>
<![endif]-->

</head>
<body class="login">
		<!--[if  IE 7]>
		<div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;'>    
		<div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'>
		</div>
		<div style='width: 840px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>      
		<div style='width: 75px; float: left;'><img src='/images/ie6nomore-warning.jpg' alt='Warning!'/></div>      
		<div style='width: 475px; float: left; font-family: Arial, sans-serif;'>        
		<div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>您正在使用已经过时的IE 7浏览器！</div>        
		<div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>由于IE 7的安全问题以及对互联网标准的支持问题，<br/>建议您升级您的浏览器，以达到更好的浏览效果！</div>     
		</div>      
		<div style='width: 75px; float: left;'><a href='http://www.firefox.com' target='_blank'><img src='/images/ie6nomore-firefox.jpg' style='border: none;' alt='Get Firefox'/></a></div>      
		<div style='width: 75px; float: left;'><a href='http://www.browserforthebetter.com/download.html' target='_blank'><img src='/images/ie6nomore-ie8.jpg' style='border: none;' alt='Get Internet Explorer'/></a></div>      
		<div style='width: 73px; float: left;'><a href='http://www.apple.com/safari/download/' target='_blank'><img src='/images/ie6nomore-safari.jpg' style='border: none;' alt='Get Safari'/></a></div>      
		<div style='float: left;'><a href='http://www.google.com/chrome' target='_blank'><img src='/images/ie6nomore-chrome.jpg' style='border: none;' alt='Get Google Chrome'/></a></div>    
		</div>  
		</div>  
		<![endif]-->
	<?=$content?>
</body>
</html>