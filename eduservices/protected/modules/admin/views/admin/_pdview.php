<tr class="info-center">
	<td><?=$organmodel->o_name?></td>
	<td><?=$val["user_name"]?></td>
	<td><?=$val["user_nkname"]?></td>
	<td><a href='<?=Yii::app()->createUrl('admin/students/'.$action,array("s_pc"=>$data->ea_pkid,"s_status"=>"2","s_addid"=>$val["user_id"],"marktype"=>$data->ea_type==2?2:""))?>' ><font style="font-size:16px";><?=$fsdNum?></font></a></td>
	<td><a href='<?=Yii::app()->createUrl('admin/students/'.$action,array("s_pc"=>$data->ea_pkid,"s_status"=>"2","s_addid"=>$val["user_id"],"marktype"=>$data->ea_type==2?2:""))?>' >查看</a></td>
</tr>