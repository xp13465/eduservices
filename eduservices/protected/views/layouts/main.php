<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="ctl00_ctl00_Head1">
    <title><?php echo $this->pageTitle;?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="author" content="acking">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link href="/css/skin.css" rel="stylesheet" type="text/css">
    <?php 	Yii::app()->clientScript->registerCoreScript('jquery');	?>
    <script language="javascript" type="text/javascript" src="/js/jquery_cookie.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/SelectColorStyle.css">
    <link rel="stylesheet" type="text/css" href="/css/<?php echo isset($_COOKIE['MyCssSkin'])?$_COOKIE['MyCssSkin']:"skin_2"?>.css" id="cssfile">
    <script type="text/javascript" src="/js/ChangeSkin.js"></script>
    <link type="text/css" rel="stylesheet" href="/css/WebResource.css">
    <link rel="stylesheet" type="text/css" href="/css/imgScroll.css">
    <link href="/js/common/common.css" rel="stylesheet">
	<script src="/js/common/common.js" type="text/javascript"></script>
</head>
<body>
<!-- wrapper_inner -->
<div id="wrapper_inner" style="margin-bottom:-20px;">   
    <!-- head -->
        <?php echo $this->renderPartial('/layouts/_head');?>
    <!-- end of head -->

    <!-- menu -->
        <?php echo $this->renderPartial('/layouts/_menu');?>
    <!-- end of menu -->

    <!-- content -->
        <div class="main-content" style="min-height:500px; _height:500px; overflow:visible;">
            <?php echo $content?>
        </div>
    <!-- end of content -->

    <!-- footer -->
        <?php echo $this->renderPartial('/layouts/_footer');?>
    <!-- end of footer -->
</div>
<!-- end of wrapper_inner -->
</body>
</html>