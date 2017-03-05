<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->p_id?>"></td>
	<td><?=$data->p_pid?></td>
	<td><?=Lookup::model()->getValueName($data->p_pid,"professionallevel")?></td>
	<td><?=$data->p_code?></td>
	<td><?=$data->p_name?></td>
    <td><?=isset(Professional::$type[$data->p_type])?Professional::$type[$data->p_type]:''?></td>
    <td><span class='<?=$data->p_status==1?"blcolor1":"rcolor"?>'><?=Professional::$status[$data->p_status]?><span></td>
	<td>
		<?/*
		<a href="<?=Yii::app()->createUrl("admin/organization/view",array("id"=>$data->o_id))?>">查看</a> /	*/?>
        <a href="javascript:void(0)" onclick="StatusOne('professional','<?=$data->p_id?>',<?=$data->p_status?>)"><?=$data->p_status==1?"禁用":"启用"?></a> /
		<a href="<?=Yii::app()->createUrl("admin/professional/edit",array("id"=>$data->p_id))?>">编辑</a> / 
		<a href="javascript:void(0)" onclick="deleteOne('professional','<?=$data->p_id?>')">删除</a></td>
		</td>
</tr>