<?php if($this->beginCache($data->user_id, array('duration'=>60))) { ?>
<tr>
	<td  class="algin-left"><input type="checkbox" name="selectdel[]" value="<?=$data->user_id?>">&nbsp;<?="[".$data->user_id."]"?></td>
	<td><a href="<?=Yii::app()->createUrl("admin/account/view",array("id"=>$data->user_id))?>"><?=$data->user_name?></a></td>
	<td><?=$data->user_nkname?></td>
	<?php 
	$OModel = Organization::model()->getOrgnization($data->user_organization);
    $O1=isset($OModel[count($OModel)-1])?$OModel[count($OModel)-1]['o_name']:'';
	$O2=isset($OModel[count($OModel)-2])?$OModel[count($OModel)-2]['o_name']:'';
    $O3=isset($OModel[count($OModel)-3])?$OModel[count($OModel)-3]['o_name']:"";
    ?>
	<td title="<?=$O1?>"><?=Common::strCut($O1,24)?></td>
	<td title="<?=$O2?>"><?=Common::strCut($O2,24)?></td>
	<td title="<?=$O3?>"><?=Common::strCut($O3,24)?></td>
	<td class='showlist'><?=$data->user_tel?></td>
	<td class='showlist' title='<?=$data->user_adderss?>'><?=Common::strCut($data->user_adderss,30)?></td>
	<td><span class="<?=$data->user_status==1?"blcolor1":"rcolor"?>"><?=User::$Status[$data->user_status]?></span></td>
	<td><?php 
    if($data->user_id=="1"){
        echo '超级管理员';
    }else if($data->user_id=="2"){
        echo '系统管理员';
    }else{
        echo User::$RoleName[$data->user_role];
    }
    ?></td>
	<td><?php if(!in_array($data->user_role,array(4,5))){?>
	<a href="<?=Yii::app()->createUrl("admin/account/view",array("id"=>$data->user_id))?>">查看</a> /
	<a href="<?=Yii::app()->createUrl("admin/account/edit",array("id"=>$data->user_id))?>">编辑</a> /
	<a href="javascript:void(0)" onclick="deleteOne('account','<?=$data->user_id?>')">删除</a></td>
	<?php }?>
</tr>
<?php $this->endCache(); } ?>


