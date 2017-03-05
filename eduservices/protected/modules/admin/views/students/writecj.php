<?php 
$this->breadcrumbs=array(
	'学员管理'=>array("students/manage"),
	'北航学员管理导入',
);
?>
<div style='margin:10px auto;width:500px;border:0px solid #888;overflow:hidden'>
	<h1>北航学生成绩写入</h1>
	
	
			<form action="" enctype="multipart/form-data" method="post" name="upform">
			<table width="425" height="148" style="font-size:12px">
			  <tr>	
				<td height="89" align="left">execl成绩模版:
				  <input name="upfile" type="file"  /></td>
			  </tr>
			  <tr>
				<td height="26" align="left" bgcolor=""><input class='btn' name="submit" type="submit" value="导入模版写入成绩" /></td>
			  </tr>
			</table>
			</form>

</div>
</body>
</html>