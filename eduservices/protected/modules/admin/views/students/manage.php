<?php
/* @var $this LookupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'学员管理'=>array("admin/index"),
	'学员管理',
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
	<form class="margin0" action="" onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/students/manage")?>')">
	  <span>搜索：</span>
      <?php 
      $model= Students::model()->findAll("1=1 group by s_rpc");
               $array=array();
              foreach($model as $val)$array[$val->s_rpc?$val->s_rpc:"999"]=$val->s_rpc?$val->s_rpc:"无批次";
	  $rpctmp=isset($_GET['s_rpc'])?$_GET['s_rpc']:"";
		echo CHtml::dropDownList('s_rpc',$rpctmp, $array,
		array(
		'class'=>"wauto",
		'empty'=>'入学批次',
		));
	  ?>
	  <?php 
	  $pctmp=isset($_GET['s_pc'])?$_GET['s_pc']:"";
		echo CHtml::dropDownList('s_pc',$pctmp, Pici::model()->getAllPC(false,true),
		array(
		'class'=>"wauto",
		'empty'=>'入学考批次',
		));
	  ?>
      <?php 
            if($pctmp){
                $marktypetmp=isset($_GET['marktype'])?$_GET['marktype']:"";
                echo CHtml::dropDownList('marktype',$marktypetmp, array(1=>"已考",2=>"未考"),
                array(
                'class'=>"wauto",
                'empty'=>'考试情况',
                ));
            }
          ?>
        <input class="width80" type="text" name='s_bmorder'  onfocus='checkifocus("报名编号..",this)' onblur='checkiout("报名编号..",this)' value="<?=isset($_GET['s_bmorder'])&&$_GET['s_bmorder']?$_GET['s_bmorder']:"报名编号.."?>">
        
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
        
        $zxtmp=isset($_GET['zhongxin'])&&$_GET['zhongxin']?$_GET['zhongxin']:"";
        $bmtmp=isset($_GET['baomingdian'])&&$_GET['baomingdian']?$_GET['baomingdian']:"";
        $jgtmp=isset($_GET['jigou'])&&$_GET['jigou']?$_GET['jigou']:"";
        $uid=Yii::app()->user->id;
		$usermodel=User::model()->findByPk($uid);
        if(Yii::app()->user->role==3){
            $zxtmp=$usermodel->user_organization;
        }else if(Yii::app()->user->role==2){
            $bmtmp=$usermodel->user_organization;
        }
        if(Yii::app()->user->role=='4'){
			$tstmp=isset($_GET['type'])?$_GET['type']:"1";
			echo CHtml::dropDownList('type',$tstmp, array("1"=>"正常","2"=>"回收站",),
			array(
				'class'=>"wauto",
			));
			
		}
        if(Yii::app()->user->role=='4'){
            echo CHtml::dropDownList('zhongxin',$zxtmp, Organization::model()->getOrByPid(0,true),
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
        }
        if(in_array(Yii::app()->user->role,array(3,4))){
            $datas=$zxtmp?Organization::model()->getOrByPid($zxtmp,true):array();
            if($datas||Yii::app()->user->role==4)echo CHtml::dropDownList('baomingdian',$bmtmp, $datas,
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
        }
        if(in_array(Yii::app()->user->role,array(2,3,4))){
            $datas=$bmtmp?Organization::model()->getOrByPid($bmtmp,true):array();
            if($datas||Yii::app()->user->role==4)echo CHtml::dropDownList('jigou',$jgtmp, $datas,
            array(	
                'name'=>'jigou',
                'empty'=>'请选择机构名称',
                'class'=>"wauto",
            ));
        }
        $isbdtmp=isset($_GET['s_isbd'])?$_GET['s_isbd']:"";
            echo CHtml::dropDownList('s_isbd',$isbdtmp, Students::$bdtype,
            array(
            'class'=>"wauto",
            'empty'=>'请选择本异地',
            ));
        $tstmp=isset($_GET['sm_status'])?$_GET['sm_status']:"";
		echo CHtml::dropDownList('sm_status',$tstmp, StudentsManage::$status,
		array(
		'class'=>"wauto",
		'empty'=>'状态',
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
<input type='button' class="btn btn-inverse serach <?=isset($_COOKIE['showlisttype'])&&$_COOKIE['showlisttype']=="notall"?"":"hide"?>"  id="showjjtype" value="<?=isset($_COOKIE['showjjtype'])&&$_COOKIE['showjjtype']=="type2"?"模式2":"模式1"?>" >

 </form><script>
$(document).ready(function(){
    <?php if(isset($_COOKIE['showlisttype'])&&$_COOKIE['showlisttype']=="notall"){?>
    $("#btnshowlist").val("显示所有")
    $(".userwidth").css("min-width","890px");
    $(".userwidth").css("width","890px");
    $(".showlist").hide();
        <?php if(isset($_COOKIE['showjjtype'])&&$_COOKIE['showjjtype']=="type1"){?>
        $(".showtype1").show();
        $(".showtype2").hide();
        <?php }else{?>
        $(".showtype1").hide();
        $(".showtype2").show();
        <?php }?>
    <?php }else{?>
    $(".showtype1").show();
    $(".showtype2").show();
    <?php }?>
});
</script>
</div>
<div id="w-auto1" class="w-auto" onscroll='scrollDiv(this)'>
<div  class='userwidth'>&nbsp;</div>
</div>
<div id="w-auto2" class="w-auto" onscroll='scrollDiv(this)'>

	<table class="table table-bordered margin0 userlist userwidth">
	<thead>
	<tr>
	<th width="30px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
	<th width="80px">序号[id]</th>
    <th width="100px">报名编号</th>
    <th width="55px" class='showlist'>入学</th>
	<th width="85px" class='showlist'>入学考
    <?php  
        if(isset($_GET['s_pc'])&&$_GET['s_pc']){
                echo "[成绩]";
            }
    ?>
    </th>
	<th width="80px">姓名</th>
	<th width="205px">证件</th>
	<th class='showtype1' width="100px">出生地</th>
	<th width="100px" class='showlist'>手机</th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("bcu","bcd"))){
		$tmp=$_GET['order']=="bcu"?"↑":"↓";
		$get['order']=$_GET['order']=="bcu"?"bcd":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/manage",$get);
	}else{
		$tmp="↑↓";
		$get['order']="bcu";
		$tmpUrl=Yii::app()->createUrl("admin/students/manage",$get);
	}?>
	<th width="55px">层次 <?php /*<a class='showlist' class="order" href="<?=$tmpUrl?>"><?=$tmp?></a>*/?></th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("bzu","bzd"))){
		$tmp=$_GET['order']=="bzu"?"↑":"↓";
		$get['order']=$_GET['order']=="bzu"?"bzd":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/manage",$get);
	}else{
		$tmp="↑↓";
		$get['order']="bzu";
		$tmpUrl=Yii::app()->createUrl("admin/students/manage",$get);
	}?>
	<th width="100px" class='showlist showtype2'>专业 <a class="order showlist" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("stu","std"))){
		$tmp=$_GET['order']=="stu"?"↑":"↓";
		$get['order']=$_GET['order']=="stu"?"std":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/manage",$get);
	}else{
		$tmp="↑↓";
		$get['order']="stu";
		$tmpUrl=Yii::app()->createUrl("admin/students/manage",$get);
	}?>
	<th width="85px">所属机构</th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("tmu","tmd"))){
		$tmp=$_GET['order']=="tmu"?"↑":"↓";
		$get['order']=$_GET['order']=="tmu"?"bzd":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/manage",$get);
	}else{
		$tmp="↑↓";
		$get['order']="tmu";
		$tmpUrl=Yii::app()->createUrl("admin/students/manage",$get);
	}?>
    <th width="60px">状态</th>
	<th>操作</th>
	</tr>
	</thead>
	<?php 
	if(!$Arrays){?>
	<tr>
	<td colspan='13'>没有找到数据</td>
	</tr>
	<?php }else{
		foreach($Arrays as $key=>$data){
            if($this->beginCache("students_manage_{$data->sm_id}_".Yii::app()->user->role, array('duration'=>5))) {
                $this->renderPartial('_manage',array("data"=>$data,"key"=>$key));
            $this->endCache(); }
		?>
	<?php }
	}?>
	</table>
</div>

<div class="clear ohidden margin-t20">
	<p class="pull-left">
		<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
		<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
		
        <button class="btn btn-inverse" target="_blank" onclick='explodeChecked(2)' <?php //=Yii::app()->createUrl("admin/students/outexcel")?>><i class=" icon-share-alt icon-white"></i> 导出所选的照片包</button>
		
        <a class="btn btn-inverse" target="_blank"  href="<?=Yii::app()->createUrl("admin/students/np")?>"><i class="icon-share-alt icon-white"></i> 导出</a>
        <?php if(Yii::app()->user->role==4){?>
        <a class="btn btn-info" target='_blank' href="<?=Yii::app()->createUrl("admin/students/inportSM",array("type"=>'1'))?>"><i class="icon-arrow-up icon-white"></i> 未确认导入</a>
		<a class="btn btn-info" target='_blank' href="<?=Yii::app()->createUrl("admin/students/inportSM",array("type"=>'2'))?>"><i class="icon-arrow-up icon-white"></i> 录取导入</a>
        <?php /*<a class="btn btn-info" target='_blank' href="<?=Yii::app()->createUrl("admin/students/inportSM",array("type"=>'3'))?>"><i class="icon-arrow-up icon-white"></i> 学籍导入</a>*/?>
        <a class="btn btn-info" target='_blank' href="<?=Yii::app()->createUrl("admin/students/writecj")?>"><i class="icon-arrow-up icon-white"></i>写入成绩</a>
        <?php }?>
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
<div id="albumform" style="display:none ">
	<?=$this->renderPartial('_albumform');?>
</div>

