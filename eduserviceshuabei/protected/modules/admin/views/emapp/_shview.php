<?php //if($this->beginCache($data->mk_id, array('duration'=>0))) { ?>
<tr>
    <td><input type="checkbox" name="selectdel[]" value="<?=$data->mk_id?>"></td>
    <td><?=($key+1)." [".$data->mk_id."]"?></td>
    <td><?=$data->mk_xh?></td>
    <td><?=$data->mk_sname?></td>
    <td class="algin-left"><?php foreach(Emapp::$credentialstype as $k=>$v) if($data->mk_cardtype==$k) echo $v;?>:<?=$data->mk_cardnumber?></td>
    <?php /* <td><?=$data->mk_sdgx?></td>
    <td><?php foreach(Emapp::$arrsex as $k=>$v) if($data->mk_sex==$k) echo $v; ?></td>
    <td><?php $aa=Lookup::model()->find("lu_class='nationality' and lu_key={$data->mk_ethnic}"); echo $aa->lu_value;?></td> */?>
    <td class='showtype2' title='<?=Professional::model()->getZyName($data->mk_specialty)?>'><?=Common::strCut(Professional::model()->getZyName($data->mk_specialty),21)?></td>
    <td class='showlist' ><?=$data->mk_moblie?></td>
    <td class='showlist' ><?=$data->mk_tel?></td>
    <td><?php foreach(Emapp::$subject as $k=>$v) if($data->mk_subject==$k) echo $v;?></td>
    <td class="showlist">上海学习中心</td>
    <td class="showlist <?=$data->mk_status!=3?$data->mk_status==2?'blcolor1':'ycolor':'rcolor'?>" >
        <?php foreach(Emapp::$status as $k=>$v) if($data->mk_status==$k) echo $v; ?>
    </td>
    <td><a href="<?=Yii::app()->createUrl("admin/emapp/shedit",array("id"=>$data->mk_id))?>">审核</a>   
</tr>
<?php //$this->endCache(); } ?>