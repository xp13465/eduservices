<?php //if($this->beginCache($data->mk_id, array('duration'=>0))) { ?>
<tr>
    <td><input type="checkbox" name="selectdel[]" value="<?=$data->mk_id?>"></td>
    <td><?=($key+1)." [".$data->mk_id."]"?></td>
    <td><?=$data->mk_xh?></td>
    <td><?=$data->mk_sname?></td>
    <td class="algin-left"><?=Emapp::$credentialstype[$data->mk_cardtype]?>:<?=$data->mk_cardnumber?></td>
    <?php /* <td><?=$data->mk_sdgx?></td>
    <td><?=Emapp::$arrsex[$data->mk_sex]?></td>
    <td><?php $aa=Lookup::model()->find("lu_class='nationality' and lu_key={$data->mk_ethnic}"); echo $aa->lu_value;?></td> */?>
    <td class='showtype2' title='<?=Professional::model()->getZyName($data->mk_specialty)?>'><?=Common::strCut(Professional::model()->getZyName($data->mk_specialty),21)?></td>
    <td class='showlist' ><?=$data->mk_moblie?></td>
    <td class='showlist' ><?=$data->mk_tel?></td>
    <td><?=Emapp::$subject[$data->mk_subject]?></td>
    <?php
    $jigou=User::model()->findByPk($data->mk_addid);
    $jigoutitle=Organization::model()->getNameByOid($jigou["user_organization"]);
    ?>
    <td class="showlist"><?=$jigoutitle?></td>
    <td class="showlist <?=$data->mk_status!=3?$data->mk_status==2?'blcolor1':'ycolor':'rcolor'?>" >
        <?=Emapp::$status[$data->mk_status]?>
    </td>
    <td>
    <a href="<?=Yii::app()->createUrl("admin/emapp/view",array("id"=>$data->mk_id))?>">查看</a>
    <?php if(Yii::app()->user->role==4||$data->mk_status!=2): ?>
         / <a href="<?=Yii::app()->createUrl("admin/emapp/edit",array("id"=>$data->mk_id))?>"><?=$data->mk_isdel=="1"?"编辑":"恢复"?></a> 
    <?php endif; ?>
    <?php if($data->mk_isdel==1&&(Yii::app()->user->role==4||$data->mk_status!=2)): ?>
         / <a href="javascript:void(0)" onclick="deleteOne('emapp','<?=$data->mk_id?>')">删除</a>
    <?php endif; ?>
    </td>
</tr>
<?php //$this->endCache(); } ?>
