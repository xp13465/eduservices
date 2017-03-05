<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
$this->breadcrumbs=array(
	'新闻公告管理'=>array("information/index"),
	'公告查看',
);
$url = isset($_COOKIE['ggnewslistreturnurl'])?$_COOKIE['ggnewslistreturnurl']:"information";
if(Yii::app()->user->role==4){
    $this->menu=array(
        array('label'=>"返回","url"=>$url),
        array('label'=>"编辑","url"=>array('information/edit','id'=>$model->i_id,"return"=>"view")),
    );
}else{
    $this->menu=array(
        array('label'=>"返回列表页","url"=>$url),
    );
}
?>
<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/layout.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/zoomimage.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/custom.css" />
<script type="text/javascript" src="/js/zoomimage.jquery/js/jquery.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/eye.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/utils.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/zoomimage.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/layout.js"></script>			
<div>
<div class="form-horizontal userform">
<table class="table table-bordered">
  <tbody>
 <tr>
<td>
<div class="info-box">
 <h1 class="title"><?=$model->i_title?></h1>
 <h2 class="tags">发表于：<?=date("Y-m-d",$model->i_submitdate)?>&nbsp;&nbsp;来源：<?=$model->i_author?></h2>
 <div class="info-text"><?=$model->i_con?></div>
</div>
</td>
 </tr>
  </tbody>
</table>
</div>
</div>