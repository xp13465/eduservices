<?php 
$model=$dataProvider->getData();
// print_r($model);exit;
?>
<style>
table {border-collapse: collapse;border-spacing: 0px;}



.table_01{ width:100%;}
.table_01 td {border:1px solid #E8E8E8; padding:5px 10px 4px 10px; text-align:center;}
.table_01 td.tit{ line-height:21px; color:#333; font-weight:bold;}
.table_01 td.titl{ line-height:21px; color:#333; font-weight:bold; padding-left:18px;}
.table_01 td.txt{line-height:21px; color:#333; }
</style>	
<script>
function xzyx(sname,scode){
	if(window.opener.document.getElementById('s_oldschool')){
		var ok=confirm("确认选择\n"+sname+"？");
		if(ok){
			window.opener.document.getElementById('s_oldschool').value=sname;
			window.opener.document.getElementById('s_oldschoolcode').value=scode;
			window.close();
		}
	}
}
</script>
<form method='get' id='csearch'>
	<div style='margin-top:10px;width:800px'>
	院校名称或沿革：<input name='keyword' value='<?=$keyword?>'/>
	院校省份：<select name='province' style='margin:0px;'>
	<option < value=''>选择省份</option>
	<?php 
		$ProvinceArr=array();
	foreach(Province::model()->findAll("1=1 order by pid") as $val){
		$ProvinceArr[$val->pid]=$val->pname;
	?>
	<option <?=$val->pid==$province?"selected":""?> value='<?=$val->pid?>'><?=$val->pname?></option>
	<?php }?>
	</select>
	<a style='text-decoration: none' href='javascript:csearch.submit()'>【查找】</a>
	</div>
</form>
<table class="table_01" >
<tr style='background:#E7F1FA;'>
	<td class="tit">操作</td>
	<td class="tit">院校名称</td>
	<td class="tit">院校省份</td>
    <td class="tit">历史沿革</td>
</tr>
<?php foreach($model as $data){ ?>
<tr class="">

	
	<td class="txt">
	<a href='javascript:xzyx("<?=$data->s_name?>","<?=$data->s_code?>")'>选择</a>
	</td>

	<td class="txt">
	<?php echo CHtml::encode($data->s_name); ?>
	</td>
	<td class="txt">
		<?php echo CHtml::encode($ProvinceArr[$data->s_province]); ?>
	</td>
    <td class="txt">
		<?php echo CHtml::encode($data->s_history); ?>
	</td>
</tr>

<?php } 	?>
</table>
<div class="clear ohidden">
	<div class="pagination pull-left">
	<?php 	$this->widget('CBootstraplinkPager',array(
				'pages'=>$dataProvider->pagination,
			));?>
	</div>
	<div class="pagination pull-right">
		当前第<span class="blcolor weight"><?=$dataProvider->pagination->currentPage+1?></span>页，
		共<span class="blcolor weight"><?=ceil($dataProvider->pagination->itemCount/$dataProvider->pagination->pageSize)?></span>页，
		共有<span class="blcolor weight"><?=$dataProvider->pagination->itemCount?></span>所院校。
	</div>
</div>