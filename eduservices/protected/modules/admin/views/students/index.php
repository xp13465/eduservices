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
	<form class="margin0" action=""  onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/students/index")?>')">
	  <span>搜索范围：</span> 
      <?php
        $smtypetmp=isset($_GET['smtype'])?$_GET['smtype']:"";
		echo CHtml::dropDownList('smtype',$smtypetmp, Students::$smtype,
		array(
            'class'=>"wauto",
		));?>
      <span>搜索：</span>
      <?php 
        $array= Students::model()->getSrpc();   
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
                if($marktypetmp==1){
                ?>
                <input class="width60" type="text" name='score_start'  value="<?=isset($_GET['score_start'])&&$_GET['score_start']>=0?$_GET['score_start']:""?>">-
                <input class="width60" type="text" name='score_end'  value="<?=isset($_GET['score_end'])&&$_GET['score_end']>=0?$_GET['score_end']:""?>">
         <?php   
         }

         }
          ?>
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
		$tstmp=isset($_GET['s_status'])?$_GET['s_status']:"";
		echo CHtml::dropDownList('s_status',$tstmp, Students::$status,
		array(
		'class'=>"wauto",
		'empty'=>'审核状态',
		));
		if(Yii::app()->user->role=='4'){
			$tstmp=isset($_GET['type'])?$_GET['type']:"1";
			echo CHtml::dropDownList('type',$tstmp, array("1"=>"正常","2"=>"回收站",),
			array(
				'class'=>"wauto",
			));
			
		}
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
	<div class="padding-tb5">
	<table class="table table-bordered margin0 userlist userwidth">
	<thead>
	<tr>
	<th width="30px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
	<th width="80px">序号[id]</th>
    <th width="55px" class='showlist'>入学</th>
	<th width="90px">入学考
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
		$tmpUrl=Yii::app()->createUrl("admin/students/index",$get);
	}else{
		$tmp="↑↓";
		$get['order']="bcu";
		$tmpUrl=Yii::app()->createUrl("admin/students/index",$get);
	}?>
	<th width="55px">层次 <?php /*<a class='showlist' class="order" href="<?=$tmpUrl?>"><?=$tmp?></a>*/?></th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("bzu","bzd"))){
		$tmp=$_GET['order']=="bzu"?"↑":"↓";
		$get['order']=$_GET['order']=="bzu"?"bzd":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/index",$get);
	}else{
		$tmp="↑↓";
		$get['order']="bzu";
		$tmpUrl=Yii::app()->createUrl("admin/students/index",$get);
	}?>
	<th width="100px" class='showlist showtype2' >专业 <a class="order showlist" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("stu","std"))){
		$tmp=$_GET['order']=="stu"?"↑":"↓";
		$get['order']=$_GET['order']=="stu"?"std":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/index",$get);
	}else{
		$tmp="↑↓";
		$get['order']="stu";
		$tmpUrl=Yii::app()->createUrl("admin/students/index",$get);
	}?>
	<th width="55px"><?php /*<span class='showlist'>审核</span>*/?>状态 <?php /*<a class='showlist' class="order" href="<?=$tmpUrl?>"><?=$tmp?></a>*/?></th>
	<th width="80px">所属机构</th>
	<?php 
	$get=$_GET;
	if(isset($_GET['order'])&&in_array($_GET['order'],array("tmu","tmd"))){
		$tmp=$_GET['order']=="tmu"?"↑":"↓";
		$get['order']=$_GET['order']=="tmu"?"bzd":"";
		$tmpUrl=Yii::app()->createUrl("admin/students/index",$get);
	}else{
		$tmp="↑↓";
		$get['order']="tmu";
		$tmpUrl=Yii::app()->createUrl("admin/students/index",$get);
	}?>
	<th width="80px" class='showlist'>录入时间<a class="order" href="<?=$tmpUrl?>"><?=$tmp?></th>
    <?php /*if(isset($_GET['smtype'])&&$_GET['smtype']==2){ ?>
        <th width="80px" class='showlist'>学员管理</th>
    <?php   }*/?>
	<th>操作</th>
	</tr>
	</thead>
	<?php 
	if(!$Arrays){?>
	<tr>
	<td colspan='14'>没有找到数据</td>
	</tr>
	<?php }else{
		foreach($Arrays as $key=>$data){
            if($this->beginCache("students_view_{$data->s_id}", array('duration'=>5))) {
               $this->renderPartial('_view',array("data"=>$data,"key"=>$key));
            $this->endCache(); }
		?>
	<?php }
	}?>
	</table>
	</div>
</div>

<div class="clear ohidden margin-t20">
	<p class="pull-left">
		<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
		<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
		<?php if(Yii::app()->user->role=='4'){?>
		<a class="btn btn-danger" href="javascript:GetCheckbox('students'<?=isset($_GET['type'])&&$_GET['type']=='2'?",1":""?>)"><i class="icon-trash icon-white"></i> <?=isset($_GET['type'])&&$_GET['type']=='2'?"恢复":"删除"?></a>
		<?php  }?>
        <?php if(isset($_GET['smtype'])&&$_GET['smtype']=='1'){?>
		<button class="btn btn-inverse" target="_blank" onclick='explodeChecked()' <?php //=Yii::app()->createUrl("admin/students/outexcel")?>><i class=" icon-share-alt icon-white"></i> 导出所选的表格</button>
        <button class="btn btn-inverse" target="_blank" onclick='explodeChecked(2)' <?php //=Yii::app()->createUrl("admin/students/outexcel")?>><i class=" icon-share-alt icon-white"></i> 导出所选的照片包</button>
		<button class="btn btn-inverse" target="_blank" onclick='createAlbum()' <?php //=Yii::app()->createUrl("admin/students/outexcel")?>><i class=" icon-share-alt icon-white"></i> 导出</button>
		<?php }?>
		<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
         <font size='-3' color='#999'>(导出前请先选择搜索范围为录入)</font>
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
<div id="albumform" style="display:none">
	<?=$this->renderPartial('_albumform');?>
</div>

