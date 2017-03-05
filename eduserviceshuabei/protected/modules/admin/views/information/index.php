<?php
/* @var $this InformationController */

$this->breadcrumbs=array(
    '新闻公告列表',
);
$Arrays=$dataProvider->getData();
?>
<div class="clear">
    <form action="" class="margin0" onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/information/index")?>')">
        <span>搜索：</span>
        <input class="width80" type="text" name='i_id'  onfocus='checkifocus("ID..",this)' onblur='checkiout("ID..",this)' value="<?=isset($_GET['i_id'])&&$_GET['i_id']?$_GET['i_id']:"ID.."?>">
        <input class="width60" type="text" name='i_label' onfocus='checkifocus("标签..",this)' onblur='checkiout("标签..",this)' value="<?=isset($_GET['i_label'])&&$_GET['i_label']?$_GET['i_label']:"标签.."?>">
        <input class="width60" type="text" name='i_title' onfocus='checkifocus("标题..",this)' onblur='checkiout("标题..",this)' value="<?=isset($_GET['i_title'])&&$_GET['i_title']?$_GET['i_title']:"标题.."?>">
       
       <?php
            $tjtmp=isset($_GET['i_bool'])?$_GET['i_bool']:"";
            echo CHtml::dropDownList('i_bool',$tjtmp, Information::$isbool,
            array(
            'class'=>"wauto",
            'empty'=>'推荐状态',
            ));
            
            // $tjtmp = isset($_GET['i_bool'])?$_GET['i_bool']:"1";
            // echo CHtml::dropDownList("i_bool",$tjtmp,array("1"=>"推荐","0"=>"否",),
            // array(
                // "class"=>"wauto",
            // ));
            if(Yii::app()->user->role=='4'){
                $tstmp=isset($_GET['type'])?$_GET['type']:"1";
                echo CHtml::dropDownList('type',$tstmp, array("1"=>"正常","2"=>"回收站",),
                array(
                    'class'=>"wauto",
                ));
            }
        ?>
        <button type="submit" class="btn btn-inverse serach">搜索</button>
    </form>
</div>


<div id="w-auto1" class="w-auto2" onscroll='scrollDiv(this)'>
    <div  class='userwidth'>&nbsp;</div>
</div>
<div id="w-auto2" class="w-auto2" onscroll='scrollDiv(this)'>
    <div class="padding-tb5">
        <table class="table table-bordered margin0 userlist userwidth">
            <thead>
                <tr>
                    <th width="30px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
                    <th width="70px">序号[id]</th>
                    <th width="400px">标题</th>
                    <th width="200px">发布时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <?php if(!$Arrays){?>
                <tr>
                    <td colspan='7'>没有找到数据</td>
                </tr>
            <?php }else{
                foreach($Arrays as $key=>$data){
                // print_r($data->attributes);
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
	<?php if(Yii::app()->user->role=='4'){?>
		<a class="btn btn-danger" href="javascript:GetCheckbox('information'<?=isset($_GET['type'])&&$_GET['type']=='2'?",1":""?>)"><i class="icon-trash icon-white"></i> <?=isset($_GET['type'])&&$_GET['type']==2?Yii::app()->user->role!='4'?'删除':'恢复':"删除"?></a>
		<?php  }?>
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