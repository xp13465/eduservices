<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->s_id?>"></td>
	<td><?php echo CHtml::encode($data->s_name); ?></td>
	<td><?php echo CHtml::encode($data->s_code); ?></td>
	<td><?php echo CHtml::encode(Province::model()->getNameById($data->s_province)); ?></td>
	<td><?php echo CHtml::encode($data->s_pinyinsuoxie?"有":""); ?></td>
	<td><?php echo CHtml::encode($data->s_pinyinlongname?"有":""); ?></td>
	<td>
		<?/*
		<a href="<?=Yii::app()->createUrl("admin/organization/view",array("id"=>$data->o_id))?>">查看</a> /	*/?>
		<a href="<?=Yii::app()->createUrl("admin/school/edit",array("id"=>$data->s_id))?>">编辑</a> / 
		<a href="javascript:void(0)" onclick="deleteOne('school','<?=$data->s_id?>')">删除</a></td>
	</td>
</tr>
