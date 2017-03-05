<?php
/* @var $this LookupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'免考管理'=>array("emapp/index"),
	'免考审核',
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
	<form action="" onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/emapp/auditck")?>')">
	  <span>搜索：</span>
      <?php
	    $rpctmp=isset($_GET['mk_cardtype'])?$_GET['mk_cardtype']:"";
		echo CHtml::dropDownList('mk_cardtype',$rpctmp, Emapp::$credentialstype,
		array(
		'class'=>"wauto",
		'empty'=>'证件类型',
		));      
      ?>
        <input class="wauto" type="text" name='mk_cardnumber' onfocus='checkifocus("证件号码..",this)' onblur='checkiout("证件号码..",this)' value="<?=isset($_GET['mk_cardnumber'])?$_GET['mk_cardnumber']:"证件号码.."?>">
        <input class="wauto" type="text" name='mk_xh' onfocus='checkifocus("学号..",this)' onblur='checkiout("学号..",this)' value="<?=isset($_GET['mk_xh'])?$_GET['mk_xh']:"学号.."?>">
        <input class="wauto" type="text" name='mk_sname' onfocus='checkifocus("姓名..",this)' onblur='checkiout("姓名..",this)' value="<?=isset($_GET['mk_sname'])?$_GET['mk_sname']:"姓名.."?>">
        <input class="wauto" type="text" name='mk_moblie' onfocus='checkifocus("手机..",this)' onblur='checkiout("手机..",this)' value="<?=isset($_GET['mk_moblie'])?$_GET['mk_moblie']:"手机.."?>">
	  	<?php 
        $zxtmp=isset($_GET['mk_subject'])?$_GET['mk_subject']:"";
		echo CHtml::dropDownList('mk_subject',$zxtmp, Emapp::$subject,
		array(
			'name'=>'mk_subject',
			'empty'=>'请选择免考科目',
			'class'=>"wauto",
			));
        ?>
	  <button type="submit" class="btn btn-inverse serach">搜索</button>
	 

<input type='button' class="btn btn-inverse serach"  id="btnshowlist" value="<?=isset($_COOKIE['showlisttype'])&&$_COOKIE['showlisttype']=="notall"?"显示所有":"精简模式"?>" >
</form><script>
$(document).ready(function(){
    <?php if(isset($_COOKIE['showlisttype'])&&$_COOKIE['showlisttype']=="notall"){?>
    $("#btnshowlist").val("显示所有")
    $(".userwidth").css("min-width","1100px");
    $(".userwidth").css("width","1100px");
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
<th width="30px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
<th width="80px">序号[id]</th>
<th width="70px">学号</th>
<th width="70px">姓名 </th>
<th width="205px">证件号码</th>
<?php /*<th width="100px">就读试点高校 </th> 
<th width="50px">性别</th> 
<th width="80px">民族 </th>*/?>
<th width="110px">专业</th>
<th width="100px" class='showlist' >手机</th>
<th width="110px" class='showlist' >电话</th>
<th width="120px">免考科目</th>
<th width="150px" class='showlist' >所属</th>
<th width="60px" class='showlist' >状态</th>
<th>操作</th>
</tr>
</thead>
	<?php 
	if(!$Arrays){?>
	<tr>
	<td colspan='11'>没有找到数据</td>
	</tr>
	<?php }else{
		foreach($Arrays as $key=>$data){
		$this->renderPartial('_shview',array("data"=>$data,"key"=>$key));
		?>
	<?php }
	}?>
	</table>
</div>

<div class="clear ohidden">
	<p class="pull-left">
		<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
		<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
	</p>    
	<p class="input-append pull-right">
		<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("m_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['m_pagesize'])?$_COOKIE['m_pagesize']:"20"?>">
		<button class="btn btn-info" type="button" onclick='setpagesize("m_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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

