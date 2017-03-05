<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->p_id?>"></td>
    <td><?=$key+1?>　[<?=$data->p_id?>]</td>
	<td><?=$data->p_value?></td>
	<td><span class='<?=$data->p_status==1?"blcolor1":"rcolor"?>'><?=Pici::$status[$data->p_status]?><span></td>
	<td>
		<?/*
		<a href="<?=Yii::app()->createUrl("admin/organization/view",array("id"=>$data->o_id))?>">查看</a> /	*/?>
		<a href="javascript:void(0)" onclick="StatusOne('pici','<?=$data->p_id?>',<?=$data->p_status?>)"><?=$data->p_status==1?"禁用":"启用"?></a> / 
		<a href="javascript:void(0)" onclick="deleteOne('pici','<?=$data->p_id?>')">删除</a></td>
	</td>
</tr>