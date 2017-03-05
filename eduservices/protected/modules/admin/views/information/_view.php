<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->i_id?>"></td>
	<td><?=$key+1?>[<?=$data->i_id?>]</td>
    <td><a href="<?=Yii::app()->createUrl("admin/information/view",array("id"=>$data->i_id))?>"><?=$data->i_title?></a></td>
    <td><?=date("Y-m-d",$data->i_submitdate)?></td>
    <td>
        <a href="<?=Yii::app()->createUrl("admin/information/view",array("id"=>$data->i_id))?>">查看</a>
        <?php if(Yii::app()->user->role==4){?>
            /<a href="<?=Yii::app()->createUrl("admin/information/edit",array("id"=>$data->i_id))?>"><?=$data->i_isdel==1?"编辑":"恢复"?></a>
            <?php if($data->i_isdel==1){?>
            /<a href="javascript:void(0)" onclick="deleteOne('information','<?=$data->i_id?>')">删除</a>
            <?php }?>
        <?php }?>
    </td>
</tr>