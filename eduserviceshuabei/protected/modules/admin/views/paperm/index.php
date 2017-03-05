<?php
$this->breadcrumbs=array(
	'试卷管理'
);
?>
<form action=""   onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/paperm/index")?>')">
    <div class="clear">
        搜索：
         <?php  /*试卷类：<select class="span2" name= "e_cat" id = "e_cat">
            <option value = "" selected>全部</option>
            <option value = "1" <?=isset($_GET['e_cat'])&&$_GET['e_cat']==1?"selected":""?>>固定试卷</option>
            <option value = "2" <?=isset($_GET['e_cat'])&&$_GET['e_cat']==2?"selected":""?>>随机试卷</option>
        </select>*/?>
        试卷名称：<input class="wauto" type="text" name="e_name" id = "e_name" value="<?=isset($_GET['e_name'])&&$_GET['e_name']!=''?$_GET['e_name']:'';?>">
        <button class="btn btn-inverse serach" type="submit">查询</button>
    </div>
</form>
<div class="clear">
	<button class="btn btn-info serach" type="button" onclick = "window.location='<?=Yii::app()->createUrl('admin/paperm/add');?>'">新建试卷</button>
	<? //<button class="btn btn-info serach" type="button">新建Excel试卷</button> ?>
</div>
<table class="table table-bordered userlist">
	<thead>
		<tr>
			<th width="5%"><input type="checkbox" value="" name="selectAll" id = "selectAll" onclick = "javascript:SelectAll('selectdel[]')" ></th>
			<th width="5%"><b>ID</b></th>
			<th width="20%"><b>试卷名称</b></th>
			<th width="15%"><b>有效时间</b></th>
			<th width="15%"><b>状态</b></th>
			<th width="20%"><b>启用/停用</b></th>
			<th width="25%">操作</th>
		</tr>
	</thead>
	<tbody>
         <?php 
            $result=$dataProvider->getData();
            foreach($result as $r){
        ?>
		<tr>
			<td><input type="checkbox" value="<?=$r->e_id?>" name="selectdel[]" id = "subid"></td>
			<td><?=$r->e_id?></td>
			<td><?=$r->e_name?></td>
			<td><?=date("Y-m-d",$r->e_btime)." ".date("Y-m-d",$r->e_etime)?></td>
			<td><?=Exampaper::$use[$r->e_use]?></td>
			<td><button class="btn" onclick = "changestatus('paperm','<?=$r->e_id?>')"><?php if($r->e_use==1){$duse=2;}else{$duse=1;} echo Exampaper::$use[$duse]?></button></td>
			<td>
            <a href="<?=Yii::app()->createUrl("admin/paperm/edit",array("id"=>$r->e_id))?>">编辑</a> / 
            <a href="javascript:void(0)" onclick="deleteOne('paperm','<?=$r->e_id?>')">删除</a> / 
            <a href="<?=Yii::app()->createUrl("admin/paperm/view",array("id"=>$r->e_id))?>">试卷内容</a>
            <?php /* / <a href="#">考试管理</a> */?></td>
		</tr>
        <?php }?>
	</tbody>
</table>
<div class="clear ohidden">   
	<p class="pull-left">
		<a class="btn btn-success" href="#" onclick = "$('#selectAll').click();SelectAll('selectdel[]');"><i class="icon-ok icon-white"></i> 全选</a>
		<a class="btn btn-danger" href="javascript:GetCheckbox('paperm','')"><i class="icon-trash icon-white"></i> 删除</a>		
		<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
	</p>
	<p class="input-append pull-right">
		<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("e_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['e_pagesize'])?$_COOKIE['e_pagesize']:"20"?>">
		<button class="btn btn-info" type="button" onclick='setpagesize("e_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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