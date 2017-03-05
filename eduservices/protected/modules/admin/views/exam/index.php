<?php
$show = '';
$cat=isset($_GET['cat'])?$_GET['cat']:'';
switch($cat){
    case 2:$show = '待批改的考生';break;
    case 3:$show = '有成绩的考生';break;
    case 4:$show = '缺考的考生';break;
    default:$show = '考试中的考生';break;
}
$this->breadcrumbs=array(
	'考试管理',
);
$Arrays=$dataProvider->getData();
?>
<div class="container-fluid breadcrumb">
  <div class="row-fluid">
    <div class="span2 breadcrumb">
		<ul class="nav nav-list">
			<li class="nav-header">所有考生</li>
			<li class="divider"></li>
			<li>
				<a class="t_nav" href="javascript:void(0);">考生</a>
				<ul class="nav sub-nav nav-list">
					<li <?=$cat==1||!$cat?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/exam/index")?>">考试中的考生</a></li>
					<li <?=$cat==3?'class="active"':""?>><a href="<?=Yii::app()->createUrl("admin/exam/index",array("cat"=>"3"))?>">有成绩的考生</a></li>
				</ul>
			</li>
		</ul>
    </div>
    <div class="span10">
		<?php if($cat == 3){?>
        <label style="padding-left:5px;padding-top:5px;">当前位置：<?=$show?></label>
		<?php }else{?>
            <label style="padding-left:5px;padding-top:5px;">当前位置：<?=$show?></label>
        <?php }?>
        <?/*<label style="padding-left:5px;padding-top:5px;">
			<font color="#003399">查询及操作</font>
		</label>*/?>
        
		<form class="margin0" action=""   onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/exam/index")?>')">
        <div class="clear" style="padding-left:5px;padding-top:5px;">
            <input class="wauto" type="hidden" name="cat" value="<?=isset($_GET['cat'])&&$_GET['cat']?$_GET['cat']:""?>">
            姓名：<input class="wauto" type="text" name="stname" onfocus='checkifocus("姓名...",this)' onblur='checkiout("姓名...",this)' value="<?=isset($_GET['stname'])&&$_GET['stname']?$_GET['stname']:"姓名..."?>">
            身份证：<input class="wauto" type="text" name="stsfz"  onfocus='checkifocus("身份证...",this)' onblur='checkiout("身份证...",this)' value="<?=isset($_GET['stsfz'])&&$_GET['stsfz']?$_GET['stsfz']:"身份证..."?>">
            排考场次：<input class="wauto" type="text" name="stpkcc"  onfocus='checkifocus("排考场次...",this)' onblur='checkiout("排考场次...",this)' value="<?=isset($_GET['stpkcc'])&&$_GET['stpkcc']?$_GET['stpkcc']:"排考场次..."?>">
            
			<button class="btn btn-info serach" type="submit">查询</button>
		</div>
        </form>
        <table class="table table-bordered userlist" style='min-width:1200px'>
			<thead>
				<tr>
                    <th width="30px"><input type="checkbox" value="" name="selectAll" id = "selectAll" onclick = "javascript:SelectAll('selectdel[]')" ></th>
                    <th width="80px">ID/排考场次</th>
                    <th >试卷名称</th>
                    <th width="80px">姓名</th>
                    <th width="145px">身份证</th>
                    <th width="170px">
                        <?php
                            $get = $_GET;
                            if($cat==3){
                                if(isset($_GET['order'])&&in_array($_GET['order'],array("tmeu","tmed"))){
                                    $tmp=$_GET['order']=="tmeu"?"↑":"↓";
                                    $get['order']=$_GET['order']=="tmeu"?"bzd":"";
                                    $tmpUrl=Yii::app()->createUrl("admin/exam/index",$get);
                                }else{
                                    $tmp="↑↓";
                                    $get['order']="tmeu";
                                    $tmpUrl=Yii::app()->createUrl("admin/exam/index",$get);
                                }
                            }else{
                                if(isset($_GET['order'])&&in_array($_GET['order'],array("tmbu","tmbd"))){
                                    $tmp=$_GET['order']=="tmbu"?"↑":"↓";
                                    $get['order']=$_GET['order']=="tmbu"?"bzd":"";
                                    $tmpUrl=Yii::app()->createUrl("admin/exam/index",$get);
                                }else{
                                    $tmp="↑↓";
                                    $get['order']="tmbu";
                                    $tmpUrl=Yii::app()->createUrl("admin/exam/index",$get);
                                }
                            }
                        ?>
                        <?=$cat=="3"?"交卷":"开始"?>时间[答题时间]<a href="<?=$tmpUrl?>"><?=$tmp?></a>
                    </th>
                    <?php if($cat == 3){?>
                    <th width="60px">客观分</th>
                    <th width="60px">主观分</th>
                    <th width="60px">总分数</th>
                    <th width="60px">试卷状态</th>
                    <th width="80px">评卷人</th>
					<?php }?>
                    <th width="110px">操作</th>
				</tr>
			</thead>
            <tbody>
                <?php if(!$Arrays){?>
                <tr><td colspan="13">没有找到数据</td></tr>    
                <?php   }else{
                    foreach($Arrays as $key=>$data){
                        $this->renderPartial('_view',array("data"=>$data,"key"=>$key,"cat"=>$cat));
                    }
                }?>
			</tbody>
        </table>
		<div class="clear ohidden">
			<p class="pull-left">
				<a class="btn btn-success" href="#" onclick = "$('#selectAll').click();SelectAll('selectdel[]');"><i class="icon-ok icon-white"></i> 全选</a>
                <?php /*if(Yii::app()->user->role==4){?>
                <a class="btn btn-danger" href="javascript:GetCheckbox('exam','')"><i class="icon-trash icon-white"></i> 删除</a>
                <?php }*/?>
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
    </div>
</div>
</div>