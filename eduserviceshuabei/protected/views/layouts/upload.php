<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <script src="/js/jquery.js" type="text/javascript"></script>
		<link href="/css/bootstrap.css" rel="stylesheet">
		<?php Yii::app()->clientScript->registerScriptFile('/js/goldhome.js',CClientScript::POS_END );?>
    </head>
    <body>
            <?php echo $content; ?>
    </body>
</html>
