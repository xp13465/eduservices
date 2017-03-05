<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="/css/global.css" rel="stylesheet" type="text/css" />
        <link href="/css/login.css" rel="stylesheet" type="text/css" />
        
        <link href="/js/common/common.css" rel="stylesheet" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script src="/js/jquery.js" type="text/javascript"></script>
    </head>
    <body>
        <?=$this->renderPartial('/layouts/_top');?>
        <?php 
        echo $content;
        $this->renderPartial('/layouts/_footer');
        ?>
        <script src="/js/common/common.js" type="text/javascript"></script>
    </body>
</html>
