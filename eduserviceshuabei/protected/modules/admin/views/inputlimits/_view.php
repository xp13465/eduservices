<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->il_id?>"></td>
    <td><?=$key+1?>　[<?=$data->il_id?>]</td>
	<td><?=$data->il_pc?>批次</td>
    <td><?=$data->il_limit?>人(已录<?=$Tatol?>人)</td>
    <?php 
    $usermodel=User::model()->getUserInfoById($data->il_uid);
	$OModel = Organization::model()->getOrgnization($usermodel->user_organization);
	?>
    <td><?=$usermodel->user_name."-".$usermodel->user_nkname?>---
    [
	<?=isset($OModel[count($OModel)-1])?$OModel[count($OModel)-1]['o_name']:''?>&nbsp;
	<?=isset($OModel[count($OModel)-2])?$OModel[count($OModel)-2]['o_name']:''?>&nbsp;
	<?=isset($OModel[count($OModel)-3])?$OModel[count($OModel)-3]['o_name']:""?>&nbsp;
    ]
    </td>
	<td><?=User::model()->getUserName($data->il_editid)?></td>
    <td><?=$data->il_edittime?date("Y-m-d H:i:s",$data->il_edittime):""?></td>
	<td>
		
	</td>
</tr>