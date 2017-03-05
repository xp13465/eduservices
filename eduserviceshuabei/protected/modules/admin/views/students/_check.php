<?php 
	// $array=Students::model()->getCardInfoByWeb($data->s_credentialsnumber);
	
    $id=$data->s_addid;
    $user=User::model()->findByPk($id);
    $checkArr=$user->user_bddm?explode(",",$user->user_bddm):array();
    $sfcode=substr(strtolower(trim($data->s_credentialsnumber)),0,2);
    $valid=false;
    if(in_array($sfcode,$checkArr)){
        $valid = true;
    }
    
	if($valid){
		$CardDate=Students::model()->getIDCardInfo($data->s_credentialsnumber);	
		$SFCardNum=$data->s_credentialsnumber;
		if($data->s_credentialstype==1&&$CardDate!=date("Ymd",$data->s_birthdate)){
			$SFCardNum=str_replace($CardDate,"<span style='color:red;'>{$CardDate}</span>",$data->s_credentialsnumber);	
		}
	}else{
		$SFCardNum="<span style='color:red;'>{$data->s_credentialsnumber}</span>";
	}
?>
<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->s_id?>"></td>
	<td><?=$key+1?>　[<?=$data->s_id?>]</td>
    <td><?=$data->s_rpc?></td>
	<td><a  href="<?=Yii::app()->createUrl("admin/students/checku",array("id"=>$data->s_id))?>"><?=$data->s_name?></a></td>
	<td class="algin-left"><?=Students::$credentialstype[$data->s_credentialstype]."："?><?=$SFCardNum?></td>
	<td title='<?=$data->s_birthaddress?>'><?=Common::strCut($data->s_birthaddress,18)?></td>
	<td class='showlist'><?=$data->s_phone?></td>
    <td><?=Lookup::model()->getValueName($data->s_baokaocengci,'professionallevel')?></td>
	<td class='showlist' title='<?=Professional::model()->getZyName($data->s_baokaozhuanye)?>'><?=Common::strCut(Professional::model()->getZyName($data->s_baokaozhuanye),24)?></td>

	<td class='showlist'><span class="<?=$data->s_status==1?"ycolor":$data->s_status==2?"blcolor1":"rcolor"?>"><?=Students::$status[$data->s_status]?></span></td>
	<td title='<?=User::model()->getCnameByUid($data->s_addid)?>'><?=Common::strCut(User::model()->getCnameByUid($data->s_addid),15)?></td>
	<td ><?=date("Y-m-d",$data->s_addtime)?></td>
	<td>
	<a  href="<?=Yii::app()->createUrl("admin/students/checku",array("id"=>$data->s_id))?>">审核</a> 
	</tr>