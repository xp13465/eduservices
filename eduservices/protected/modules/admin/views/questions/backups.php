<?php 
$this->breadcrumbs=array(
	'题库管理'=>array("questions/index"),
	'备份题库',
);
?>
<div class="clear">
	题库集：<select>
		<option>题库集A</option>
		<option>题库集B</option>
	</select>
	<button class="btn btn-info serach" type="button">备份</button>
	<button class="btn btn-info serach" type="button">退出</button>
</div>
<table class="table table-bordered backups">
	<thead>
		<tr>
			<th width="5%"><input type="checkbox" value="" name=""></th>
			<th width="95%">题库</th>
		</tr>
	</thead>
	<tbody>	
		<tr>
			<td><input type="checkbox" value="" name=""></td>
			<td>税务知识</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="" name=""></td>
			<td>财务</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="" name=""></td>
			<td>工程</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="" name=""></td>
			<td>工程1</td>
		</tr>
	</tbody>	
</table>
<div class="clear ohidden">
	<p class="pull-left">
		<a class="btn btn-success" href="#"><i class="icon-ok icon-white"></i> 全选</a>
	<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
		<a class="btn btn-danger" href="#"><i class="icon-trash icon-white"></i> 删除</a>
		<a class="btn btn-warning" href="#"><i class=" icon-share-alt icon-white"></i> 导出</a>
		<a class="btn" href="#"><i class="icon-refresh"></i> 刷新</a>
	</p>
	<p class="input-append pull-right">
		<input class="width60" type="text" value="20">
		<button class="btn btn-info" type="button">设置每页显示条数</button>
	</p>
</div>
<div class="clear ohidden">
	<div class="pagination pull-left">
		<ul>
			<li class="disabled"><a href="#">«上一页</a></li>
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">下一页»</a></li>
		</ul>
	</div>
	<div class="pagination pull-right">
		当前第<span class="blcolor weight">1</span>页，共<span class="blcolor weight">10</span>页，共有<span class="blcolor weight">360</span>条数据。
	</div>
</div>