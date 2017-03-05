<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->q_id?>"></td>	
	<td><?=$data->q_name?></td>
	<td>
		<?/*
		<a href="<?=Yii::app()->createUrl("admin/examset/view",array("id"=>$data->q_id))?>">查看</a> /	*/?>
		<a href="<?=Yii::app()->createUrl("admin/examset/edit",array("id"=>$data->q_id))?>">编辑</a> / 
		<a href="javascript:void(0)" onclick="deleteOne('examset','<?=$data->q_id?>')">删除</a></td>
	</td>
</tr>