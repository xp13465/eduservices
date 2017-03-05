<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>在线考试--<?php echo CHtml::encode($this->pageTitle); ?></title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link href="/css/student/exam.css" rel="stylesheet" type="text/css" />
<link href="/css/student/exam-public.css" rel="stylesheet" type="text/css" />
<link href="/js/common/common.css" rel="stylesheet">
<script src="/js/common/common.js" type="text/javascript"></script>
<?php 	Yii::app()->clientScript->registerCoreScript('jquery');	?>
<!--[if IE 6]>
<style type="text/css">
/* IE6浏览器的特有方法 */
/* 修正IE6振动bug */
* html,* html body{background-image:url(about:blank);background-attachment:fixed}
* html .ie6fixedTL{position:absolute;left:expression(eval(document.documentElement.scrollLeft));top:expression(eval(document.documentElement.scrollTop))}
* html .ie6fixedBR{position:absolute;left:expression(eval(document.documentElement.scrollLeft+document.documentElement.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,10)||0)-(parseInt(this.currentStyle.marginRight,10)||0));top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)))}
</style>
<![endif]--> 
</head>

<body>
<?php echo $content; ?>
</body>
</html>
