<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->q_id?>"></td>
	<td><?=Questions::model()->getNameById($data->q_pid)?></td>
	<td><?=$data->q_name?></td>
	<td>
		<a href="<?=Yii::app()->createUrl("admin/examset/edit",array('type'=>'second',"id"=>$data->q_id))?>">编辑</a> / 
		<a href="javascript:void(0)" onclick="deleteOne('Examset','<?=$data->q_id?>')">删除</a>
	</td>
</tr>