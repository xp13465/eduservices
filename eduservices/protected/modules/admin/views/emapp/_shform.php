<?php
/* @var $this StudentsController  */
/* @var $model Students */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jsdate/WdatePicker.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
?>

<div>
<div class="form-horizontal userform">
  <?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'mksh_form',
"htmlOptions"=>array('class'=>'form-horizontal mkform'),
'enableAjaxValidation'=>false,
)); ?>

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

<?php if($model->mk_statusabout):?>
<tr>
<td>
<p class="pull-left lineh30 margin0  marl10">
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
      <dt>性别</dt><dd><?=Emapp::$arrsex[$model->mk_sex]?>&nbsp;</dd>
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
         // print_r($e_trip);exit;//判断只有原因为公三英语或计算机一级B时,才显示省分，准考证号和证件号等
        foreach($e_trip as $j=>$v){
          if($v==1){
            if($j==2||$j==4){
      ?>
      <dt>免考证书报考时间</dt>
      <dd>
      <?php 
        $ksnf=$j==2?Emapp::$arrjsjksnf:Emapp::$arrengksnf;
        echo isset($ksnf[$model->mk_ksnf])?$ksnf[$model->mk_ksnf]:"";
      ?>&nbsp;
      </dd>
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
</td>
</tr>
    <tr>
      <td>
        <div class="control-group">
          <label class="control-label">审核状态 <span class="rcolor">*</span></label>
          <div class="controls " id='mk_status'>
            <div class='pull-left'>
              <label class="radio inline" style='width:40px'>
                <input type="radio" name="mk_status" id="s_status_2" <?=$model->mk_status=="2"?"checked":""?> value="2">通过
              </label>
              <label class="radio inline" style='width:40px'>
                <input type="radio" name="mk_status" id="s_status_3" <?=$model->mk_status=="3"?"checked":""?> value="3">驳回
              </label>
            </div>
            <p for="mk_status" class="error"></p>
          </div>      
        </div>
        <div class="control-group">
          <label class="control-label">审核备注 <span class="rcolor"></span></label>
          <div class="controls">
            <?php echo $form->textAREA($model,'mk_statusabout',array('class'=>'input-large pull-left','maxlength'=>200,'name'=>"mk_statusabout",'style'=>"width:400px;height:100px")); ?>
            <p for="mk_statusabout" class="error"></p>
          </div>  
        </div>
      </td>
    </tr>
<tr>
<td>
<div class="form-actions">
<button type="submit" class="btn btn-primary" name="addsubmit" value="add">确&nbsp;定</button>&nbsp;
<a class="btn" href='<?=$url?>'>返&nbsp;回</a>&nbsp;
</div>    
</td>
</tr>
<?php 
  $cfmodel=Emapp::model()->findAll("mk_cardnumber='{$model->mk_cardnumber}' and mk_sname='{$model->mk_sname}' and mk_xh='{$model->mk_xh}' and mk_subject='{$model->mk_subject}'");
 ?>
<?php 
foreach($cfmodel as $cfv){
if($model->mk_id!=$cfv->mk_id){?>
<tr>     
<td width="100%" class="nolinebg">
<div class="nocolumn">
<b class="pull-left">重复信息：</b><span class='blcolor '></span>
  <div>
 
  </div>
</div>
</td>
</tr>
<tr>
<td>
  <p class="pull-left lineh30 margin0  marl10">
      <b>申请操作人：</b>
      <span class='<?=$cfv->mk_status!=1?$cfv->mk_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=User::model()->getUserName($cfv->mk_addid)?></span>
      <b>申请时间：</b>
      <span class='hcolor'><?=date('Y-m-d H:i:s',$cfv->mk_addtime)?></span>     
  </p>
</td>
</tr>
<tr>
<td>
<?php if($cfv->mk_editid):?>
<p class="pull-left lineh30 margin0  marl10" >
<b>最后操作人：</b><span class='<?=$cfv->mk_status!=1?$cfv->mk_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=User::model()->getUserName($cfv->mk_editid)?></span>
<b>修改时间：</b><span class='hcolor'><?=date('Y-m-d H:i:s',$cfv->mk_editime)?></span>
</p>
<?php endif; ?>
<p class="pull-left lineh30 margin0  marl10" >
<b>审核状态：</b><span class='<?=$cfv->mk_status!=1?$cfv->mk_status==2?"blcolor1":"rcolor":"ycolor"?>'><?=isset(Application::$astatus[$cfv->mk_status])?Application::$astatus[$cfv->mk_status]:""?></span>
<b>审核时间：</b><span class='hcolor'><?=date('Y-m-d H:i:s',$cfv->mk_statustime)?></span>  
</p>     
<?=$cfv->mk_isdel==2?"<p class='lineh30 marl100'><font color='red'>该条记录已删除</font></p>":""?>
</td>
</tr>
<tr>
<td>
<p class="pull-left lineh30 margin0  marl10">
<?php if($cfv->mk_statusabout):?>
<b class="pull-left">审核备注：</b><span class='blcolor '><?=$cfv->mk_statusabout?></span>
<?php endif; ?>
</p>
</td>
</tr>
<tr>     
<td width="100%" class="nolinebg">
<div class="nocolumn">
    <div>
    <dl class="dl-horizontal">
      <dt>证件类型</dt><dd><?=Emapp::$credentialstype[$cfv->mk_cardtype]?>&nbsp;</dd>
      <dt>证件号</dt><dd><?=$cfv->mk_cardnumber?>&nbsp;</dd>
      <?php       
      $jigou=User::model()->findByPk($cfv->mk_addid);
      $jigoutitle=Organization::model()->getNameByOid($jigou["user_organization"]);
      ?>
      <dt>所属机构</dt><dd><?=$jigoutitle?>&nbsp;</dd>
      <dt>学员姓名</dt><dd><?=$cfv->mk_sname?>&nbsp;</dd>
      <dt>性别</dt><dd><?=Emapp::$arrsex[$cfv->mk_sex]?>&nbsp;</dd>
      <dt>民族</dt><dd><? $aa=Lookup::model()->find("lu_class='nationality' and lu_key={$cfv->mk_ethnic}"); echo $aa->lu_value; ?>&nbsp;</dd>
      <dt>试点高校</dt><dd><?=$cfv->mk_sdgx;?>&nbsp;</dd>
      <dt>手机号码</dt><dd><?=$cfv->mk_moblie?>&nbsp;</dd>
      <dt>联系电话</dt><dd><?=$cfv->mk_tel?>&nbsp;</dd>
      <dt>学号</dt><dd><?=$cfv->mk_xh?>&nbsp;</dd>
      <dt>免考专业</dt><dd><?php $ponal=Professional::model()->getKCInfo(2); echo $ponal[$cfv->mk_specialty];?>&nbsp;</dd>
      <dt>免考科目</dt><dd><?=Emapp::$subject[$cfv->mk_subject]?>&nbsp;</dd>
      <dt>免考原因</dt><dd><? $e_trip = unserialize($cfv->mk_reason); foreach($e_trip as $j=>$v){ if($v==1){echo Emapp::$arrreason[$j]."<br/>";} }?></dd>
      <dt>查看附件</dt><dd><?=$cfv->mk_file?>&nbsp;<a class="btn btn-mini btn-success" onclick="window.open ('<?=$cfv->mk_file?>') ">查看</a></dd>
      
      <?php  
        $e_trip = unserialize($cfv->mk_reason); // print_r($e_trip);判断只有当选中40岁以上的免考原因,才显示身分证
        foreach($e_trip as $j=>$v){
          if($j==6&&$v==1){
      ?>
      <dt>身份证图片</dt><dd><img width="300" src="<?=$cfv->mk_cardimg?$cfv->mk_cardimg:'/img/photo.jpg'?>" />&nbsp;</dd>
      <?php }}?>
      <?php
        $e_trip = unserialize($cfv->mk_reason);
         // print_r($e_trip);exit;//判断只有原因为公三英语或计算机一级B时,才显示省分，准考证号和证件号等
        foreach($e_trip as $j=>$v){
          if($v==1){
            if($j==2||$j==4){
      ?>
      <dt>免考证书报考时间</dt>
      <dd>
      <?php 
        $ksnf=$j==2?Emapp::$arrjsjksnf:Emapp::$arrengksnf;
        echo isset($ksnf[$cfv->mk_ksnf])?$ksnf[$cfv->mk_ksnf]:"";
      ?>&nbsp;
      </dd>
      <dt>免考证书报考省份</dt>
      <dd>
      <?=isset(Emapp::$arrmkadder [$cfv->mk_ksadder])?Emapp::$arrmkadder [$cfv->mk_ksadder]:''?>&nbsp;
      </dd>
      <dt>免考证书类别</dt>
      <dd>
      <?=isset(Emapp::$arrzstype [$cfv->mk_zstype])?Emapp::$arrzstype [$cfv->mk_zstype]:''?>&nbsp;
      </dd>
      <dt>免考准考证号</dt>
      <dd><?=$cfv->mk_zkznum?>&nbsp;</dd>
      <dt>免考证件号</dt>
      <dd><?=$cfv->mk_zjnum?>&nbsp;</dd>
      <dt>&nbsp;</dt><dd><a href="<?=Yii::app()->createUrl("site/checkmk",array("mkid"=>$cfv->mk_id))?>" target="_blank" class="btn btn-primary">验证证书</a></dd>
      <?php }}}?>

    </dl>
  </div>
</div>
</td>
</tr>
<?php }}?>


  </tbody>
</table>
<?php $this->endWidget(); ?>  

</div>
</div>
<script>
$(document).ready(function() {

$(".controls").find("input").change(function(){
// alert($(this).parent('div.controls').find("p.pl8"))
if($(this).parent('div.controls').find("p.pl8").css("display")=="block"){
$(this).parent('div.controls').find("p.pl8").hide()
}
})
$("a.btn-success").mouseover(function(){
$(this).next("img").show();

}).mouseout(function(){
$(this).next("img").hide();

})	

jQuery("#mksh_form").validate({
// debug: true,
autoCreateRanges:true	,
errorClass: "error",
errorElement: "p",
rules: {				
mk_status: 'required'
},
messages: {				
mk_status: '请选择！'              
}
});

});
</script>
