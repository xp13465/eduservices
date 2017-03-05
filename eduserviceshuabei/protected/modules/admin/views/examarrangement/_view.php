<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->ea_id?>"></td>
    <td><?=$key+1?>　[<?=$data->ea_id?>]</td>
    <?php $rxkPcArr=Pici::model()->getAllPC(false);?>
	<td><?=isset($rxkPcArr[$data->ea_pkid])?$rxkPcArr[$data->ea_pkid]:$data->ea_pkid.""?></td>
	<td title='<?=$data->ea_examid?Exampaper::model()->getExamName($data->ea_examid):"系统判断层次专业"?>'><?=$data->ea_examid?Common::strCut(Exampaper::model()->getExamName($data->ea_examid),20):"系统判断层次专业出卷"?></td>
    <td><?=date("Y-m-d  H:i:s",$data->ea_stime)?>--<?=date("H:i:s",$data->ea_etime)?></td>
    <td><span><?=Examarrangement::$type[$data->ea_type]?></span></td>
    <td><span class='<?=$data->ea_status==1?"blcolor1":"rcolor"?>'><?=Examarrangement::$status[$data->ea_status]?></span></td>
    <td>
		<?/*
		<a href="<?=Yii::app()->createUrl("admin/organization/view",array("id"=>$data->o_id))?>">查看</a> /	*/?>
		<a href="javascript:void(0)" onclick="StatusOne('examarrangement','<?=$data->ea_id?>',<?=$data->ea_status?>)"><?=$data->ea_status==1?"禁用":"启用"?></a> / 
        <a href="<?=Yii::app()->createUrl("admin/examarrangement/edit",array("id"=>$data->ea_id))?>">编辑</a> /
        <a href="javascript:void(0)" onclick="deleteOne('examarrangement','<?=$data->ea_id?>')">删除</a>
    </td>
	</td>
</tr>