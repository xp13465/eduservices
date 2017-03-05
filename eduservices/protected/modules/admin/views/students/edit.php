<?php
/* @var $this StudentsController */
/* @var $model Students */
//if(isset($_GET['type'])&&in_array($_GET['type'],array(1,2,"other"))){
$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员列表'=>array("index"),
	'学员编辑',
);


$url=isset($_COOKIE['xylistreturnurl'])?$_COOKIE['xylistreturnurl']:array("index");
$menuArr[]=array('label'=>'返回列表', 'url'=>$url);
if(!$model->isNewRecord)$menuArr[]=array('label'=>'查看本学员', 'url'=>array("view","id"=>$model->s_id));
$this->menu=$menuArr;
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); 
/*
}else{ ?>
 <div style="margin:10px 0 10px;; marheight:200px;width:590px;">
 <?php	if(Yii::app()->user->role==4||$model->s_credentialstype==1){?>
 	<div class="click-ico">
		<a href='<?=Yii::app()->createUrl("admin/students/edit",array("id"=>$model->s_id,"type"=>"1"))?>' >
			<img src="/images/ss.png" title="神思读卡器身份证编辑" />
			神思读卡器身份证编辑
		</a>
	</div> 
	<div class="click-ico">
		<a href='<?=Yii::app()->createUrl("admin/students/edit",array("id"=>$model->s_id,"type"=>"2"))?>' >
			<img src="/images/gt.png"  title="国腾读卡器身份证编辑" />
			国腾读卡器身份证编辑
		</a>
	</div> 
<?php } if(Yii::app()->user->role==4||$model->s_credentialstype!=1){?>
	<div class="click-ico">
		<a href='<?=Yii::app()->createUrl("admin/students/edit",array("id"=>$model->s_id,"type"=>"other"))?>' >
			<img src="/images/qt.png"  title="其他证件手动编辑" />
			其他证件手动编辑
		</a>
	</div> 
<?php }?>	
 </div>
  
<?php }*/?>