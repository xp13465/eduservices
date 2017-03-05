<?php 
$this->breadcrumbs=array(
	'题库管理'=>array("questions/index"),
	'还原题库',
);
?>
<table class="table table-bordered">
	<tr>
		<td width="15%"><font class="td-right">请选择备份文件：</font></td>
		<td width="85%">
			<input class="span8" type="text">
			<button class="btn btn-info serach" type="button">浏览</button>
			<button class="btn btn-info serach" type="button">上传</button>
		</td>
	</tr>
	<tr>
		<td >
			<font class="td-right">
				<input class="" type="radio" value="option1" checked>
				<font>还原并新建题库集：</font>
			</font>
		</td>
		<td >
			<input class="span9" type="text">
		</td>
	</tr>
	<tr>
		<td >
			<font class="td-right">
				<input class="" type="radio" value="option1" checked>
				<font>还原到现有题库集：</font>
			</font>
		</td>
		<td>
			<select class="span9">
				<option>演示题库集</option>
			</select>
		</td>
	</tr>
</table>
<div>
	<div class="re-center">
		<button class="btn btn-info" type="submit">还原</button>
		<button class="btn btn-info" type="submit">取消</button>
	</div>
	<div>
		<label><font color="#FF6600">友情提示</font></label>
		<hr style="border:1px dashed #A0A0A0;">
		<ul>
			<li><font color="#A0A0A0">选择题库集备份文件后，请先点击“上传”按钮，获取题库集备份文件的内容。</font></li>
		</ul>
	</div>
</div>