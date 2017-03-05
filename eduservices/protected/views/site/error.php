<?php
$this->pageTitle = "您访问的页面不存在，错误代码：".$code;
Yii::app()->clientScript->registerCssFile("/css/error404.css");
$returnUrl=DOMAIN;
if(isset($_SERVER["REQUEST_URI"])) {//看看是不是后台的错误。如果是就要使用其他的layout
$find = stripos($_SERVER["REQUEST_URI"], "/admin/");
    if($find!== false) {
        $returnUrl=DOMAIN."/admin/";
    }
}

?>
<div class="error404">
    <div class="error404-info">
      <h5>:-( 找不到你要的页面...</h5>
      <h2>很抱歉，您所请求的页面不存在！&nbsp;&nbsp;<span id="time" class="red"></span>&nbsp;秒后返回首页！</h2>
      <p>仔细找过啦，没有发现你要找的页面。最可能的原因是：</p>
        <?php
        if(isset($message)){
            echo "<p style='color:red'>".CHtml::encode($message)."</p>";
        }
        ?>
        <p>在地址中可能存在键入错误。</p>
        <p>当你点击某个链接时，它可能已过期。</p>
    </div>
    <div class="error404-home">您可以点击：<a href="<?=$returnUrl?>">返回首页</a></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var maxTime = 10;
        $("#time").html(maxTime);
        setInterval(function(){
            maxTime --;
            $("#time").html(maxTime);
            if(maxTime==0){
                window.location.href="<?=$returnUrl?>";
            }
        },1000);
    });
</script>