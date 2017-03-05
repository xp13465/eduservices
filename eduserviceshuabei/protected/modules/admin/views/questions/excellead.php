<?php 
$this->breadcrumbs=array(
	'题库管理'=>array("questions/index"),
	'Excel导入页面',
);
?>
<div class="breadcrumb">
	<span>您可以通过Excel批量导入题目数据： </span>
	<label>第一步： 下载<font color="#CC3300">Excel题目模板表格</font>，并按模板中的说明填写题目信息。</label>
	<label>第二步： 如果你已经根据模板，把题目的信息添加到EXCEL文件里，接下来我们就可以往系统导入题目的信息。 </label>
</div>
<div class="clear breadcrumb">
	<label><span>题集库：</span>
		<select class="span3">
			<option>题集库A</option>
			<option>题集库B</option>
		</select>
	</label>
	<span>题&nbsp;&nbsp;&nbsp;库：</span>
	<select class="span3">
		<option>题库A</option>
		<option>题库B</option>
	</select>
	<label>
		<div class="input-append">
			<input class="input-xlarge" type="text">
			<button class="btn" type="button">浏览</button>
			<button class="btn" type="button">导入题目</button>
		</div>
	</label>
	<p>
		<button class="btn" type="reset">关闭</button>
	</p>
</div>
<div>
	<label><font color="#FF6600">友情提示</font></label>
	<hr style="border:1px dashed #A0A0A0;">
	<ul>
		<li><font color="#A0A0A0">如果你在实际的运用中不知道怎么更好地导入题目，您可以给我们写邮件或者直接与你的专职客户经理联系。</font></li>
	</ul>
</div>