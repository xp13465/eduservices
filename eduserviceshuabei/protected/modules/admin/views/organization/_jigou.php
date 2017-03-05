<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->o_id?>"></td>
	<?php $model=Organization::model()->findByPk($data->o_pid);?>
	<td><?=Organization::model()->getNameByOid($model->o_pid)?></td>
	<td><?=Organization::model()->getNameByOid($data->o_pid)?></td>
	<td><?=$data->o_name?></td>
	<td>				
		<?/*
		<a href="<?=Yii::app()->createUrl("admin/organization/view",array("id"=>$data->o_id))?>">查看</a> /	*/?>
		<a href="<?=Yii::app()->createUrl("admin/organization/edit",array("id"=>$data->o_id,'type'=>'jigou'))?>">编辑</a> / 
		<a href="javascript:void(0)" onclick="deleteOne('organization','<?=$data->o_id?>')">删除</a></td>
	</td>
</tr>