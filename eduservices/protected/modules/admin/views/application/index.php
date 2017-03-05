<?php
/* @var $this ApplicationController */

$this->breadcrumbs=array(
    // '学员管理'=>array("admin/index"),
    // '学员申请管理'=>array("applicationlist"),
    '学员申请列表',
);
$Arrays=$dataProvider->getData();
?>
<div class="clear">
    <?/*<form class="margin0" action="" onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/application/index")?>')">*/?>
    <form action="" class="margin0" onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/application/index")?>')">
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
        <input class="width80" type="text" name='sa_id'  onfocus='checkifocus("ID..",this)' onblur='checkiout("ID..",this)' value="<?=isset($_GET['sa_id'])&&$_GET['sa_id']?$_GET['sa_id']:"ID.."?>">
        <input class="width60" type="text" name='s_name' onfocus='checkifocus("姓名..",this)' onblur='checkiout("姓名..",this)' value="<?=isset($_GET['s_name'])&&$_GET['s_name']?$_GET['s_name']:"姓名.."?>">
	   
        <input class="wauto" type="text" name='s_credentialsnumber' onfocus='checkifocus("证件..",this)' onblur='checkiout("证件..",this)' value="<?=isset($_GET['s_credentialsnumber'])&&$_GET['s_credentialsnumber']?$_GET['s_credentialsnumber']:"证件.."?>">
        <?/*
        <input class="width80" type="text" name='s_birthaddress'  onfocus='checkifocus("出生地..",this)' onblur='checkiout("出生地..",this)' value="<?=isset($_GET['s_birthaddress'])&&$_GET['s_birthaddress']?$_GET['s_birthaddress']:"出生地.."?>"> */?>
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
            $tstmp=isset($_GET['sa_status'])?$_GET['sa_status']:"";
            echo CHtml::dropDownList('sa_status',$tstmp, Application::$astatus,
            array(
            'class'=>"wauto",
            'empty'=>'审核状态',
            ));
            
            $tstmp=isset($_GET['sa_type'])?$_GET['sa_type']:"";
            echo CHtml::dropDownList('sa_type',$tstmp, Application::$type,
            array(
            'class'=>"wauto",
            'empty'=>'申请类型',
            ));
            
            if(Yii::app()->user->role=='4'){
                $tstmp=isset($_GET['type'])?$_GET['type']:"1";
                echo CHtml::dropDownList('type',$tstmp, array("1"=>"正常","2"=>"回收站",),
                array(
                    'class'=>"wauto",
                ));
                
            }
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
        <button type="submit" class="btn btn-inverse serach">搜索</button>
        <input type='button' class="btn btn-inverse serach"  id="btnshowlist" value="<?=isset($_COOKIE['showlisttype'])&&$_COOKIE['showlisttype']=="notall"?"显示所有":"精简模式"?>" >
 </form>
<script>
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
                    <th width="65px">序号[id]</th>
                    <th width="40px" class="showlist">批次</th>
                    <th width="90px">入学考
                    <?php  
                        if(isset($_GET['s_pc'])&&$_GET['s_pc']){
                                echo "[成绩]";
                            }
                    ?>
                    </th>
                    <th width="90px">姓名</th>
                    <th width="200px">证件</th>
                    <th width="100px">出生地</th>
                    <th width="100px" class='showlist'>手机</th>
                    <th width="55px">层次</th>
                    <th width="160px" class='showlist' >专业</th>
                    <th width="55px">状态</th>
                    <th width="65px" class="showlist">申请类型</th>
                    <th width="65px" class="showlist">申请人</th>
                    <th width="80px" class='showlist'>申请时间</th>
                    <th width="85px">所属机构</th>
                    <th>操作</th>
                </tr>
            </thead>
            <?php if(!$Arrays){?>
                <tr>
                    <td colspan='16'>没有找到数据</td>
                </tr>
            <?php }else{
                foreach($Arrays as $key=>$data){
                    $this->renderPartial('_view',array("data"=>$data,"key"=>$key));
                ?>
            <?php }
            }?>
        </table>
	</div>
</div>
<div class="clear ohidden margin-t20">
	<p class="pull-left">
		<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
	<?php //if(Yii::app()->user->role=='4'){?>
		<a class="btn btn-danger" href="javascript:GetCheckbox('application'<?=isset($_GET['type'])&&$_GET['type']=='2'?",1":""?>)"><i class="icon-trash icon-white"></i> <?=isset($_GET['type'])&&$_GET['type']==2?Yii::app()->user->role!='4'?'删除':'恢复':"删除"?></a>
		<?php  //}?>
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