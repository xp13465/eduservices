<tr>
    <td><input type="checkbox" name="selectdel[]" value="<?=$data->sc_id?>"></td>
    <td><?=$data->sc_id?> / [<?=$data->sc_pkid?>]</td>
    <td><?=Exampaper::model()->getExamName($data->sc_sjid)?></td>
    <td><?=Students::model()->getNameById($data->sc_sid,"s_name")?></td>
    <td><?=Students::model()->getNameById($data->sc_sid,'s_credentialsnumber')?></td>
    <td><?=$cat=="3"?date("Y-m-d H:i:s",$data->sc_ldt):date("Y-m-d H:i:s",$data->sc_sdt)?>&nbsp;&nbsp;(<?=ceil($data->sc_time/60)?>分钟)</td>
    <?=$cat=="3"?"<td>{$data->sc_kgmark}</td>":""?>
    <?=$cat=="3"?"<td><font color='#ccc'>暂无</font></td>":""?>
    <?=$cat=="3"?"<td>{$data->sc_kgmark}</td>":""?>
    <?=$cat=="3"?"<td>".($data->sc_status=='1'?'机阅':'人阅')."</td>":""?>
    <?=$cat=="3"?"<td>".($data->sc_status=='2'?User::model()->getUserName($data->sc_readerid):'')."</td>":""?>
    <td><?php if($data->sc_status){?>
        <?php if(Yii::app()->user->role==4){?>
        <a href="<?=Yii::app()->createUrl("admin/exam/manualmark",array("id"=>$data->sc_id))?>">手工阅卷</a>/
        <?php }?>
		<a href="<?=Yii::app()->createUrl("admin/exam/view",array("id"=>$data->sc_id))?>">查看答卷</a>
    <?php }else{?>
        <a href="javascript:stopExamOne('exam','<?=$data->sc_id?>')">强制交卷</a>
    <?php }?>
    </td>
</tr>