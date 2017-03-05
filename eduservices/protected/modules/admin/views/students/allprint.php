<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title>学校公共服务体系系统-学生信息打印</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="acking">

    <!-- Le styles -->
    <!-- <link href="/css/studentinfo.css" rel="stylesheet"> -->
    <link href="/css/studentinfo.css" rel="stylesheet"><?php /*
    <link media="print" href="/css/print.css" rel="stylesheet">*/?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
    <![endif]-->
<style media=print>
.Noprint{display:none;}
</style>
<script language="JavaScript">
window.print();
</script>

  </head>
  <body>
<!--     <p class="print-button">打印本页</p> -->
<?php 
            $usermodel=User::model()->findByPk($model->s_addid);
            $Omodel=Organization::model()->findByPk($usermodel->user_organization);
            $OName=$Omodel->o_id;//$Omodel->o_name."-".$Omodel->o_id;
            if($usermodel->user_role==1){
                $OName=$Omodel->o_pid;
                // $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                // $OName=$POmodel->o_id;//$POmodel->o_name."-".$POmodel->o_id;
            }
        ?>
<!-- 身份证 -->
    <div class="box-print-all">
        <div class="from-tips"><?="{$model->s_rpc}-{$OName}".str_pad($model->s_insertid,6,0,STR_PAD_LEFT)?></div>
        <div class="print-img">
            
            <p><br/>身份证正面扫描<br/></p>
            
            <img class="img-sfz" src="<?=$model->s_credentialsimg1?>" />
            
            <p><br/><br/>身份证反面扫描<br/></p>
            
            <img class="img-sfz" src="<?=$model->s_credentialsimg2?>" />
        </div>
    </div>
    <hr align="center" width="90%" size="1" noshade="noshade" class="Noprint" >
    <div class="PageNext">&nbsp;</div>
    <?php  if($model->s_oldimg&&file_exists(DOCUMENTROOT.$model->s_oldimg)){?>
<!-- 毕业证 -->

    <div class="box-print-all">
        <div class="from-tips"><?="{$model->s_rpc}-{$OName}".str_pad($model->s_insertid,6,0,STR_PAD_LEFT)?></div>
            <p><br/>毕业证扫描
            <?php
            $style="text-align: center;z-index: -1;max-width: 1060px;max-height: 780px;";
            if(!strpos($_SERVER["HTTP_USER_AGENT"],"MSIE")){
                $style.="position: relative;left: -135px;top: 50px;margin-top: 90px;";
            }else{
                $style.="margin-left:14px;";
            }
            if(file_exists(DOCUMENTROOT.$model->s_oldimg)){
                $imagesize=getimagesize(DOCUMENTROOT.$model->s_oldimg);
                $width=$imagesize['0'];
                $height=$imagesize['1'];
                 $widthbl=$imagesize[0]/1060;
                 $cheight=$height/$widthbl;
                // echo "<br/>";
                 $heightbl=$imagesize[1]/760;
                  $cwidth=$width/$heightbl;
                 if($cheight<=760){
                    $style.="width: 1060px;";
                 }else if($cwidth<=1060){
                     $style.=";height: 760px;";
                 }
            }
?>
            
            </p>
        <div class="print-img " style='overflow:visible;margin-top:20px'>
          <img class=" deg90" style='<?=$style?>' src="<?=$model->s_oldimg?>" />
        </div>
    </div>
    <hr align="center" width="90%" size="1" noshade="noshade" class="Noprint" >
    <div class="PageNext">&nbsp;</div>
    <?php } if($model->s_zsbzm&&file_exists(DOCUMENTROOT.$model->s_zsbzm)){?>
        <!-- 专升本证明 -->
        <div class="box-print-all">
            <div class="from-tips"><?="{$model->s_rpc}-{$OName}".str_pad($model->s_insertid,6,0,STR_PAD_LEFT)?></div>
            <p>专升本证明扫描 <br/></p>
            <div class="print-img ">
                <br/><br/>
                <img class="img-byz"  src="<?=$model->s_zsbzm?>" />
            </div>
        </div>
        <hr align="center" width="90%" size="1" noshade="noshade" class="Noprint" >
    <?php  } ?>
  </body>
</html>