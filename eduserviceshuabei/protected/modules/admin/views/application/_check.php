<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->sa_id?>"></td>
	<td><?=$key+1?>　[<?=$data->sa_id?>]</td>
    <td class='showlist'><?=$data->studentinfo->s_rpc?></td>
	<td><a href="<?=Yii::app()->createUrl("admin/application/audit",array('id'=>$data->sa_id))?>"><?=$data->studentinfo->s_name?></a></td>
	<td class="algin-left"><?=Students::$credentialstype[$data->studentinfo->s_credentialstype].":"?><?=$data->studentinfo->s_credentialsnumber?></td>
	<td title='<?=$data->studentinfo->s_birthaddress?>'><?=Common::strCut($data->studentinfo->s_birthaddress,18)?></td>
	<td class='showlist'><?=$data->studentinfo->s_phone?></td>
    <td><?=Lookup::model()->getValueName($data->studentinfo->s_baokaocengci,'professionallevel')?></td>
	<td class='showlist' title='<?=Professional::model()->getZyName($data->studentinfo->s_baokaozhuanye)?>'><?=Common::strCut(Professional::model()->getZyName($data->studentinfo->s_baokaozhuanye),24)?></td>
    <td class='showlist'><span class="<?=$data->sa_status==1?"ycolor":$data->sa_status==2?"blcolor1":"rcolor"?>"><?=Application::$astatus[$data->sa_status]?></span></td>
    <td><span style="color:#5BB75B;"><?=Application::$type[$data->sa_type]?></span></td>
	<td class="showlist"><?=date("Y-m-d",$data->sa_sqtime)?></td>
    <td title='<?=User::model()->getCnameByUid($data->studentinfo->s_addid)?>'><?=Common::strCut(User::model()->getCnameByUid($data->studentinfo->s_addid),24)?></td>
    <td><a  href="<?=Yii::app()->createUrl("admin/application/audit",array("id"=>$data->sa_id))?>">审核</a></td> 
</tr>