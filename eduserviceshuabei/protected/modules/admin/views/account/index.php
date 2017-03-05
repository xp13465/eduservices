<?php
/* @var $this LookupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'帐号管理'=>array("account/index"),
	'帐号列表',
);

// $this->menu=array(
	// array('label'=>'Create Lookup', 'url'=>array('create')),
	// array('label'=>'Manage Lookup', 'url'=>array('admin')),
// );
?>


<?php 
		$Arrays=$dataProvider->getData();
?>
			
			



<div class="clear">
	<form action="" onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/account/index")?>')">
	  <span>搜索：</span>
	  <input class="wauto" type="text" name='u_name' onfocus='checkifocus("负责人..",this)' onblur='checkiout("负责人..",this)' value="<?=isset($_GET['u_name'])?$_GET['u_name']:"负责人.."?>">
      <input class="wauto" type="text" name='o_name' onfocus='checkifocus("机构..",this)' onblur='checkiout("机构..",this)' value="<?=isset($_GET['o_name'])?$_GET['o_name']:"机构.."?>">
	 <?php
		$zxtmp=isset($_GET['zhongxin'])?$_GET['zhongxin']:"";
		echo CHtml::dropDownList('zhongxin',$zxtmp, Organization::model()->getOrByPid(0),
		array(
			'name'=>'zhongxin',
			'empty'=>'请选择学习中心',
			'class'=>"wauto",
			'ajax' => array(
			'type'=>'GET', 
			'url'=>CController::createUrl('admin/getorganization'),
			'update'=>'#baomingdian', 
			'data'=>array('pid'=>"js:this.value",'typeid'=>1)
		)));
		$bmtmp=isset($_GET['baomingdian'])?$_GET['baomingdian']:"";
		$datas=$zxtmp?Organization::model()->getOrByPid($zxtmp):array();
		
		echo CHtml::dropDownList('baomingdian',$bmtmp, $datas,
		array(	
			'name'=>'baomingdian',
			'empty'=>'请选择报名点',
			'class'=>"wauto",
			'ajax' => array(
			'type'=>'GET', 
			'url'=>CController::createUrl('admin/getorganization'),
			'update'=>'#jigou', 
			'data'=>array('pid'=>"js:this.value",'typeid'=>2)
			)
		));
		$jgtmp=isset($_GET['jigou'])?$_GET['jigou']:"";
		$datas=$bmtmp?Organization::model()->getOrByPid($bmtmp):array();
		echo CHtml::dropDownList('jigou',$jgtmp, $datas,
		array(	
			'name'=>'jigou',
			'empty'=>'请选择机构',
			'class'=>"wauto",
		));
		$roletmp=isset($_GET['user_role'])?$_GET['user_role']:"";
		echo CHtml::dropDownList('user_role',$roletmp, User::$RoleName,
		array(
		'class'=>"wauto",
		'empty'=>'帐号权限',
		));
		$statustmp=isset($_GET['user_status'])?$_GET['user_status']:"";
		echo CHtml::dropDownList('user_status',$statustmp, User::$Status,
		array(
		'class'=>"wauto",
		'empty'=>'帐号状态',
		));
		?>	
	  <button type="submit" class="btn btn-inverse serach">搜索</button>
	 

<input type='button' class="btn btn-inverse serach"  id="btnshowlist" value="<?=isset($_COOKIE['showlisttype'])&&$_COOKIE['showlisttype']=="notall"?"显示所有":"精简模式"?>" >
</form><script>
$(document).ready(function(){
    <?php if(isset($_COOKIE['showlisttype'])&&$_COOKIE['showlisttype']=="notall"){?>
    $("#btnshowlist").val("显示所有")
    $(".userwidth").css("min-width","890px");
    $(".userwidth").css("width","890px");
    $(".showlist").hide();
    <?php }?>
});
</script>
</div>
<div id="w-auto1" class="w-auto" onscroll='scrollDiv(this)'>
<div  class='userwidth'>&nbsp;</div>
</div>
<div id="w-auto2" class="w-auto" onscroll='scrollDiv(this)'>

	<table class="table table-bordered userlist userwidth">
	<thead>
	<tr>
	<th  style="text-align: left; padding: 8px 5px;" width="50px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th width="100px">帐号</th>
	<th width="80px">负责人</th>
	<th width="120px">所属学习中心 </th>
	<th width="130px">所属报名点</th>
	<th width="130px">所属机构 </th>
	<th width="100px" class='showlist' >联系电话</th>
	<th width="120px" class='showlist' >通讯地址</th>
	<th width="70px">帐号状态</th>
	<th width="80px">帐号权限</th>
	<th width="120px">操作</th>
	</tr>
	</thead>
	<?php 
	if(!$Arrays){?>
	<tr>
	<td colspan='11'>没有找到数据</td>
	</tr>
	<?php }else{
		foreach($Arrays as $key=>$data){
		$this->renderPartial('_view',array("data"=>$data,"key"=>$key));
		?>
	<?php }
	}?>
	</table>
</div>

<div class="clear ohidden">
	<p class="pull-left">
		<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
		<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
		<a class="btn btn-danger" href="javascript:GetCheckbox('account')"><i class="icon-trash icon-white"></i> 删除</a>
		<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
	</p>
	<p class="input-append pull-right">
		<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("u_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['u_pagesize'])?$_COOKIE['u_pagesize']:"20"?>">
		<button class="btn btn-info" type="button" onclick='setpagesize("u_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
	</p>
</div>
<div class="clear ohidden">
	<div class="pagination pull-left">
	<?php 	$this->widget('CBootstraplinkPager',array(
				'pages'=>$dataProvider->pagination,
			));?>
	</div>
	<div class="pagination pull-right">
		当前第<span class="blcolor weight"><?=$dataProvider->pagination->currentPage+1?></span>页，
		共<span class="blcolor weight"><?=ceil($dataProvider->pagination->itemCount/$dataProvider->pagination->pageSize)?></span>页，
		共有<span class="blcolor weight"><?=$dataProvider->pagination->itemCount?></span>条数据。
	</div>
</div>

