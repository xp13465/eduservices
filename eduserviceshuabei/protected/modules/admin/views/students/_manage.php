<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->studentinfo->s_id?>"></td>
	<td><?=$key+1?>&nbsp;&nbsp;[<?=$data->studentinfo->s_id?>]</td>
    <td><?=$data->sm_bmorder?></td>
    <td class='showlist'><?=$data->studentinfo->s_rpc?></td>
    <?php $rxkPcArr=Pici::model()->getAllPC(false,false);?>
	<td class='showlist'>
        <?=isset($rxkPcArr[$data->studentinfo->s_pc])?$rxkPcArr[$data->studentinfo->s_pc]:$data->studentinfo->s_pc.""?>
        <?php   
            if($data->studentinfo->s_enrollment==1){
                if(isset($_GET['s_pc'])&&$_GET['s_pc']){
                    $EAmodels=Examarrangement::model()->findAll("ea_pkid ='{$data->studentinfo->s_pc}'");
                    if($EAmodels){
                        $PKarr=array();
                        foreach($EAmodels as $val)$PKarr[]=$val->ea_id;
                        $num=Score::model()->count("sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->studentinfo->s_id}' ");
                        // echo "sc_pkid ='{$data->s_pc}' and sc_sid ='{$data->s_id}'";
                        if($num){
                            // echo "sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->s_id}' and sc_status != 0  order by sc_kgmark desc";
                            $Score=Score::model()->find("sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->studentinfo->s_id}' and sc_status != 0  order by sc_kgmark desc");
                             echo $Score?$Score->sc_kgmark?"[".$Score->sc_kgmark."]":"<font color='red'>未考</font>":"<font color='red'>未交卷</font>";
                        }else{
                            echo "<font color='red'>未考</font>";
                        }
                    }else{
                        echo "<font color='red'>未排</font>";
                    }
                }
            }elseif($data->studentinfo->s_enrollment==2){
                echo "免试";
            }
        ?>
    
    </td>
	<td><a href="<?=Yii::app()->createUrl("admin/students/view",array("id"=>$data->studentinfo->s_id))?>"><?=$data->studentinfo->s_name?></a></td>
	<td class="algin-left"><?=Students::$credentialstype[$data->studentinfo->s_credentialstype]."："?><?=$data->studentinfo->s_credentialsnumber?></td>
	<td class='showtype1' title='<?=$data->studentinfo->s_birthaddress?>'><?=Common::strCut($data->studentinfo->s_birthaddress,18)?></td>
	<td class='showlist'><?=$data->studentinfo->s_phone?></td>
	<td title='<?=Professional::model()->getZyName($data->studentinfo->s_baokaozhuanye)?>'><?=Lookup::model()->getValueName($data->studentinfo->s_baokaocengci,'professionallevel')?></td>
	<td class='showlist showtype2' title='<?=Professional::model()->getZyName($data->studentinfo->s_baokaozhuanye)?>'><?=Common::strCut(Professional::model()->getZyName($data->studentinfo->s_baokaozhuanye),15)?></td>
	<td title=' <?=$data->studentinfo->s_stype=="1"?User::model()->getCnameByUid($data->studentinfo->s_addid):'北航导出'?>'><?=$data->studentinfo->s_stype=="1"?Common::strCut(User::model()->getCnameByUid($data->studentinfo->s_addid),15):'<span class="blcolor1">北航导出</span>'?></td>
	<td><span class="<?=$data->sm_status!=1?$data->sm_status==2?"blcolor1":"rcolor":"ycolor"?>"><?=StudentsManage::$status[$data->sm_status]?></span></td>
    <td> 
	<a href="<?=Yii::app()->createUrl("admin/students/view",array("id"=>$data->studentinfo->s_id))?>">查看</a>

    <?php  if(Yii::app()->user->role==4){?>
	 / <a href="<?=Yii::app()->createUrl("admin/students/edit",array("id"=>$data->studentinfo->s_id))?>"><?=$data->studentinfo->s_isdel=="1"?"编辑":"恢复"?></a> 
	<?php }?>   
    </td>
	</tr>