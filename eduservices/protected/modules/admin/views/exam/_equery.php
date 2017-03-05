<tr>
    <td><input type="checkbox" name="selectdel[]" value="<?=$data->sc_id?>"></td>
    <td><?=$data->sc_id?> / [<?=$data->sc_pkid?>]</td>
    <td><?=Students::model()->getNameById($data->sc_sid,"s_name")?></td>
    <td><?=Students::model()->getNameById($data->sc_sid,'s_credentialsnumber')?></td>
    <td>
        <?=Exampaper::model()->getExamName($data->sc_sjid,'e_name')?>
        [<font color="#CC0000"><?=Exampaper::model()->getExamName($data->sc_sjid,'e_totals')?></font>]
    </td>
    <td><?=ceil($data->sc_time/60)?>分钟</td>
    <td><?=$data["sc_kgmark"]+$data["sc_zgmark"]?></td>
    <td><?=$data["sc_source"]?></td>
    <td><a href="<?=Yii::app()->createUrl("admin/exam/view",array("id"=>$data->sc_id))?>">查看</a></td>
</tr>