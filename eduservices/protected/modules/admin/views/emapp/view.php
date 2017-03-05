<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
'免考管理'=>array("emapp/index"),
'免考申请',
);
$this->menu=array(
// array('label'=>'用户列表', 'url'=>array('index')),
// array('label'=>'添加用户', 'url'=>array('create')),
// array('label'=>'修改该用户', 'url'=>array('update', 'id'=>$model->user_id)),
// array('label'=>'删除该用户', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'确定删除这条数据?')),
// array('label'=>'用户管理', 'url'=>array('admin')),
);
?>


<div>
<div class="form-horizontal userform">
<table class="table table-bordered">
    <tbody>
        <tr>
          <td>
            <p class="pull-left lineh30 margin0  marl10">
                <b>申请操作人：</b>
                <span class='<?=$model->mk_status!=1?$model->mk_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=User::model()->getUserName($model->mk_addid)?></span>
                <b>申请时间：</b>
                <span class='hcolor'><?=date('Y-m-d H:i:s',$model->mk_addtime)?></span>     
            </p>
            <div class="btn-group pull-right marr10">
                <a style="background:#ddd" href="javascript:showList(1,this)" class="btn" title="一栏显示"><i class="icon-align-justify"></i></a>
                <a style="" href="javascript:showList(2,this)" class="btn" title="二栏显示"><i class=" icon-th-large"></i></a>
            </div>
          </td>
        </tr>
        <tr>
          <td>
<?php if($model->mk_editid):?>
<p class="pull-left lineh30 margin0  marl10" >
<b>最后操作人：</b><span class='<?=$model->mk_status!=1?$model->mk_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=User::model()->getUserName($model->mk_editid)?></span>
<b>修改时间：</b><span class='hcolor'><?=date('Y-m-d H:i:s',$model->mk_editime)?></span>
</p>
<?php endif; ?>
<p class="pull-left lineh30 margin0  marl10" >
<b>审核状态：</b><span class='<?=$model->mk_status!=1?$model->mk_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=isset(Application::$astatus[$model->mk_status])?Application::$astatus[$model->mk_status]:""?></span>
<b>审核时间：</b><span class='hcolor'><?=date('Y-m-d H:i:s',$model->mk_statustime)?></span>  
</p>     
<?=$model->mk_isdel==2?"<p class='lineh30 marl100'><font color='red'>该条记录已删除</font></p>":""?>
          </td>
        </tr>
        <tr>
          <td>
                    <p class="pull-left lineh30 margin0  marl10">
                    <?php if($model->mk_statusabout):?>
                    <b class="pull-left">审核备注：</b><span class='blcolor '><?=$model->mk_statusabout?></span>
                    <?php endif; ?>
                    </p>
          </td>
        </tr>
        <tr>
<td width="100%" class="nolinebg">
<div class="nocolumn">
    <div>
    <dl class="dl-horizontal">
      <dt>证件类型</dt><dd><?=Emapp::$credentialstype[$model->mk_cardtype]?>&nbsp;</dd>
      <dt>证件号</dt><dd><?=$model->mk_cardnumber?>&nbsp;</dd>   
      <?php       
      $jigou=User::model()->findByPk($model->mk_addid);
      $jigoutitle=Organization::model()->getNameByOid($jigou["user_organization"]);
      ?>
      <dt>所属机构</dt><dd><?=$jigoutitle?>&nbsp;</dd>
      <dt>学员姓名</dt><dd><?=$model->mk_sname?>&nbsp;</dd>
      <dt>性别</dt><dd><?=isset(Emapp::$arrsex[$model->mk_sex])?Emapp::$arrsex[$model->mk_sex]:''?>&nbsp;</dd>
      <dt>民族</dt><dd><? $aa=Lookup::model()->find("lu_class='nationality' and lu_key={$model->mk_ethnic}"); echo $aa->lu_value; ?>&nbsp;</dd>
      <dt>试点高校</dt><dd><?=$model->mk_sdgx;?>&nbsp;</dd>
      <dt>手机号码</dt><dd><?=$model->mk_moblie?>&nbsp;</dd>
      <dt>联系电话</dt><dd><?=$model->mk_tel?>&nbsp;</dd>
      <dt>学号</dt><dd><?=$model->mk_xh?>&nbsp;</dd>
      <dt>免考专业</dt><dd><?php $ponal=Professional::model()->getKCInfo(2); echo $ponal[$model->mk_specialty];?>&nbsp;</dd>
      <dt>免考科目</dt><dd><?=Emapp::$subject[$model->mk_subject]?>&nbsp;</dd>
      <dt>免考原因</dt><dd><? $e_trip = unserialize($model->mk_reason); foreach($e_trip as $j=>$v){ if($v==1){echo Emapp::$arrreason[$j]."<br/>";} }?></dd>
      <dt>查看附件</dt><dd><?=$model->mk_file?>&nbsp;<a class="btn btn-mini btn-success" onclick="window.open ('<?=$model->mk_file?>') ">查看</a></dd>
      <?php 
        $e_trip = unserialize($model->mk_reason); // print_r($e_trip);判断只有当选中40岁以上的免考原因,才显示身分证
        foreach($e_trip as $j=>$v){
          if($j==6&&$v==1){
      ?>
      <dt>身份证图片</dt><dd><img width="300" src="<?=$model->mk_cardimg?$model->mk_cardimg:'/img/photo.jpg'?>" />&nbsp;</dd>
      <?php }}?>
      <?php
        $e_trip = unserialize($model->mk_reason);
        // print_r($e_trip);//判断只有原因为公三英语或计算机一级B时,才显示省分，准考证号和证件号等
        foreach($e_trip as $j=>$v){
          if($v==1){
            if($j==2||$j==4){
      ?>
      
      <dt>免考证书报考省份</dt>
      <dd>
      <?=isset(Emapp::$arrmkadder [$model->mk_ksadder])?Emapp::$arrmkadder [$model->mk_ksadder]:''?>&nbsp;
      </dd>
      <dt>免考证书类别</dt>
      <dd>
      <?=isset(Emapp::$arrzstype [$model->mk_zstype])?Emapp::$arrzstype [$model->mk_zstype]:''?>&nbsp;
      </dd>
      <dt>免考准考证号</dt>
      <dd><?=$model->mk_zkznum?>&nbsp;</dd>
      <dt>免考证件号</dt>
      <dd><?=$model->mk_zjnum?>&nbsp;</dd>
      <dt>&nbsp;</dt><dd><a href="<?=Yii::app()->createUrl("site/checkmk",array("mkid"=>$model->mk_id))?>" target="_blank" class="btn btn-primary">验证证书</a></dd>
      <?php }}}?>

    </dl>
  </div>
</div>
<div class="nocolumn">
  <div>
    <dl class="dl-horizontal">
     
    </dl>
  </div>
</div>  
      </td>
    </tr>
  </tbody>
</table>

</div>
</div>




