<?php
/* @var $this LookupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员列表',
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
	<form class="margin0" action="" onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/students/check")?>')">
	  <span>搜索：</span>
        <input class="width80" type="text" name='s_insertid'  onfocus='checkifocus("录入编号..",this)' onblur='checkiout("录入编号..",this)' value="<?=isset($_GET['s_insertid'])&&$_GET['s_insertid']?$_GET['s_insertid']:"录入编号.."?>">
        <input class="width80" type="text" name='s_id'  onfocus='checkifocus("ID..",this)' onblur='checkiout("ID..",this)' value="<?=isset($_GET['s_id'])&&$_GET['s_id']?$_GET['s_id']:"ID.."?>">
	  <input class="width60" type="text" name='s_name' onfocus='checkifocus("姓名..",this)' onblur='checkiout("姓名..",this)' value="<?=isset($_GET['s_name'])&&$_GET['s_name']?$_GET['s_name']:"姓名.."?>">
	  <input class="wauto" type="text" name='s_credentialsnumber' onfocus='checkifocus("证件..",this)' onblur='checkiout("证件..",this)' value="<?=isset($_GET['s_credentialsnumber'])&&$_GET['s_credentialsnumber']?$_GET['s_credentialsnumber']:"证件.."?>">
	  <input class="width80" type="text" name='s_birthaddress'  onfocus='checkifocus("出生地..",this)' onblur='checkiout("出生地..",this)' value="<?=isset($_GET['s_birthaddress'])&&$_GET['s_birthaddress']?$_GET['s_birthaddress']:"出生地.."?>">
	  <?php
		$cctmp=isset($_GET['s_baokaocengci'])?$_GET['s_baokaocengci']:"";
		echo CHtml::dropDownList('s_baokaocengci',$cctmp, Lookup::model()->getClassInfo('professionallevel'),
		array(
			'empty'=>'请选择报考层次',
			'class'=>"wauto",
			'ajax' => array(
			'type'=>'GET', 
			'url'=>CController::createUrl('admin/getbk'),
			'update'=>'#s_baokaozhuanye', 
			'data'=>array('mid'=>"js:this.value",'typeid'=>2)
		)));
		$zytmp=isset($_GET['s_baokaozhuanye'])?$_GET['s_baokaozhuanye']:"";
		$datas=$cctmp?Professional::model()->getKCInfo($cctmp):array();
		
		echo CHtml::dropDownList('s_baokaozhuanye',$zytmp, $datas,
		array(
		'class'=>"wauto",
		'empty'=>'请选择报考专业',
		));
        
        if(Yii::app()->user->role=='4'){
            $zxtmp=isset($_GET['zhongxin'])&&$_GET['zhongxin']?$_GET['zhongxin']:"";
            $bmtmp=isset($_GET['baomingdian'])&&$_GET['baomingdian']?$_GET['baomingdian']:"";
            $jgtmp=isset($_GET['jigou'])&&$_GET['jigou']?$_GET['jigou']:"";
            echo CHtml::dropDownList('zhongxin',$zxtmp, Organization::model()->getOrByPid(0),
            array(
                'name'=>'zhongxin',
                'empty'=>'请选择所属学习中心',
                'class'=>"wauto",
                'ajax' => array(
                'type'=>'GET', 
                'url'=>CController::createUrl('admin/getorganization'),
                'update'=>'#baomingdian', 
                'data'=>array('pid'=>"js:this.value",'typeid'=>1)
            )));
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
            $datas=$bmtmp?Organization::model()->getOrByPid($bmtmp):array();
            echo CHtml::dropDownList('jigou',$jgtmp, $datas,
            array(	
                'name'=>'jigou',
                'empty'=>'请选择机构',
                'class'=>"wauto",
            ));
        }
        $isbdtmp=isset($_GET['s_isbd'])?$_GET['s_isbd']:"";
		echo CHtml::dropDownList('s_isbd',$isbdtmp, Students::$bdtype,
		array(
		'class'=>"wauto",
		'empty'=>'请选择本异地',
		));
        ?>	
	  <?php /*
	  <select class="wauto">
	  <option value="1">所属机构</option>
	  </select>
	  
	  <div class="input-prepend sdate">
		  <span class="add-on pointer"><i title="点击选择时间" class="icon-calendar"></i></span>
		  <input type="text" class="width80 input-large" value="录入时间..">
	  </div>
	  <input class="wauto" type="text" value="关键字..">
	   */ ?>
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
<div id="w-auto1" class="w-auto2" onscroll='scrollDiv(this)'>
<div  class='userwidth'>&nbsp;</div>
</div>
<div id="w-auto2" class="w-auto2">
	<div class="padding-tb5">
	<table class="table table-bordered margin0 userlist userwidth">
	<thead>
	<tr>
	<th width="30px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
	<th width="80px">序号</th>
    <th width="55px">入学</th>
	<th width="80px">姓名</th>
	<th width="205px">证件</th>
	<th width="100px">出生地</th>
	<th width="100px" class='showlist'>手机</th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("bcu","bcd"))){
		$tmp=$_GET['order']=="bcu"?"↑":"↓";
		$get['order']=$_GET['order']=="bcu"?"bcd":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/check",$get);
	}else{
		$tmp="↑↓";
		$get['order']="bcu";
		$tmpUrl=Yii::app()->createUrl("admin/students/check",$get);
	}?>
	<th width="70px">层次 <?php /*<a class='showlist' class="order" href="<?=$tmpUrl?>"><?=$tmp?></a>*/?></th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("bzu","bzd"))){
		$tmp=$_GET['order']=="bzu"?"↑":"↓";
		$get['order']=$_GET['order']=="bzu"?"bzd":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/check",$get);
	}else{
		$tmp="↑↓";
		$get['order']="bzu";
		$tmpUrl=Yii::app()->createUrl("admin/students/check",$get);
	}?>
	<th width="150px" class='showlist'>专业 <a class="order" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("stu","std"))){
		$tmp=$_GET['order']=="stu"?"↑":"↓";
		$get['order']=$_GET['order']=="stu"?"std":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/check",$get);
	}else{
		$tmp="↑↓";
		$get['order']="stu";
		$tmpUrl=Yii::app()->createUrl("admin/students/check",$get);
	}?>
	<th width="100px" class='showlist'>审核状态 <a class="order" href="<?=$tmpUrl?>"><?=$tmp?></th>
	<th width="85px">所属机构</th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("tmu","tmd"))){
		$tmp=$_GET['order']=="tmu"?"↑":"↓";
		$get['order']=$_GET['order']=="tmu"?"bzd":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/check",$get);
	}else{
		$tmp="↑↓";
		$get['order']="tmu";
		$tmpUrl=Yii::app()->createUrl("admin/students/check",$get);
	}?>
	<th width="100px" >录入时间<a class="order" href="<?=$tmpUrl?>"><?=$tmp?></th>
	<th >操作</th>
	</tr>
	</thead>
	<?php 
	if(!$Arrays){?>
	<tr>
	<td colspan='12'>没有找到数据</td>
	</tr>
	<?php }else{
		foreach($Arrays as $key=>$data){
            // if($this->beginCache("students_check_{$key}", array('duration'=>5))) {
                $this->renderPartial('_check',array("data"=>$data,"key"=>$key));
            // $this->endCache(); }
		?>
	<?php }
	}?>
	</table>
	</div>
</div>

<div class="clear ohidden margin-t20">
	<p class="pull-left">
		<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
	<?php /*	<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
		<a class="btn btn-danger" href="javascript:GetCheckbox('students')"><i class="icon-trash icon-white"></i> 删除</a>
		*/?>
		<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
	</p>
	<p class="input-append pull-right">
		<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("s_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20"?>">
		<button class="btn btn-info" type="button" onclick='setpagesize("s_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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

