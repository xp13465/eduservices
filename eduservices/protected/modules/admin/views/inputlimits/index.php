<?php
$this->breadcrumbs=array(
	'学校信息设置',
	'批次管理',
);

?>
<?php $Arrays=$dataProvider->getData();?>
 
		<div>
			<table class="table table-bordered specialtylist">
				<thead>
					<tr>
						<th width="30px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
						<th width="80px">序号 [ID]</th>
						<th width="100px">入学批次</th>
						<th width="200px">录入限制 </th>
                        <th >限制帐号 </th>
						<th width="100px">最后修改 </th>
                        <th width="150px">修改时间 </th>
						<th width="80px">操作 </th>
					</tr>
				</thead>
				<tbody>
				<?php 	if(!$Arrays){?>
							<tr>
							<td colspan='8'>没有找到数据</td>
							</tr>
				<?php 	}else{
							foreach($Arrays as $key=>$data){
								$Tatol=Students::model()->count("s_rpc = '{$data->il_pc}' and s_isdel = 1 and  s_addid ='{$data->il_uid}' ");
								$this->renderPartial("_view",array("data"=>$data,"key"=>$key,"Tatol"=>$Tatol));
							}
						}?>
				</tbody>
			</table>
		</div>
		<div class="clear ohidden">
			<p class="pull-left">
				<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
				<a class="btn btn-danger" href="javascript:GetCheckbox('inputlimits')"><i class="icon-trash icon-white"></i> 删除</a> 
                <a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a> 
			</p>
			<p class="input-append pull-right">
				<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("il_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['pc_pagesize'])?$_COOKIE['pc_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("il_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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

			

