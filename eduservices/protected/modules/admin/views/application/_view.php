<tr>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->sa_id?>"></td>
	<td><?=$key+1?>[<?=$data->sa_id?>]</td>
    <td class='showlist'><?=$data->studentinfo->s_rpc?></td>
    <?php $rxkPcArr=Pici::model()->getAllPC(false,false);?>
    <td>
        <?=isset($rxkPcArr[$data->studentinfo->s_pc])?$rxkPcArr[$data->studentinfo->s_pc]:$data->studentinfo->s_pc.""?>
        <?php   
            if(isset($_GET['s_pc'])&&$_GET['s_pc']){
                $EAmodels=Examarrangement::model()->findAll("ea_pkid ='{$data->studentinfo->s_pc}'");
                if($EAmodels){
                    $PKarr=array();
                    foreach($EAmodels as $val)$PKarr[]=$val->ea_id;
                    $num=Score::model()->count("sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->studentinfo->s_id}' ");
                    // echo "sc_pkid ='{$data->studentinfo->s_pc}' and sc_sid ='{$data->studentinfo->s_id}'";
                    if($num){
                        // echo "sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->studentinfo->s_id}' and sc_status != 0  order by sc_kgmark desc";
                        $Score=Score::model()->find("sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->studentinfo->s_id}' and sc_status != 0  order by sc_kgmark desc");
                        echo $Score?$Score->sc_kgmark?"[".$Score->sc_kgmark."]":"<font color='red'>未考</font>":"<font color='red'>未交卷</font>";
                    }else{
                        echo "<font color='red'>未考</font>";
                    }
                }else{
                    echo "<font color='red'>未排</font>";
                }
            }
        ?>
    </td>
	<td><a href="<?=Yii::app()->createUrl("admin/application/view",array('id'=>$data->sa_id))?>"><?=$data->studentinfo->s_name?></a></td>
	<td class="algin-left"><?=Students::$credentialstype[$data->studentinfo->s_credentialstype].":"?><?=$data->studentinfo->s_credentialsnumber?></td>
	<td title='<?=$data->studentinfo->s_birthaddress?>'><?=Common::strCut($data->studentinfo->s_birthaddress,18)?></td>
	<td class='showlist'><?=$data->studentinfo->s_phone?></td>
    <td><?=Lookup::model()->getValueName($data->studentinfo->s_baokaocengci,'professionallevel')?></td>
	<td class='showlist' title='<?=Professional::model()->getZyName($data->studentinfo->s_baokaozhuanye)?>'><?=Common::strCut(Professional::model()->getZyName($data->studentinfo->s_baokaozhuanye),36)?></td>
    <td><span class="<?=$data->sa_status!=1?$data->sa_status==2?"blcolor1":"rcolor":"ycolor"?>"><?=Application::$astatus[$data->sa_status]?></span></td>
    <td class='showlist'><span style="color: #5BB75B;"><?=Application::$type[$data->sa_type]?></span></td>
    
    <td class='showlist'><?=User::model()->getUserName($data->sa_proposerid)?></td>
    
	<td class='showlist'><?=date("Y-m-d",$data->sa_sqtime)?></td>
    <td title='<?=User::model()->getCnameByUid($data->studentinfo->s_addid)?>'><?=Common::strCut(User::model()->getCnameByUid($data->studentinfo->s_addid),15)?></td>
    <td>
        <a href="<?=Yii::app()->createUrl("admin/application/view",array("id"=>$data->sa_id))?>">查看</a>
        <?php if(Yii::app()->user->role==4||$data->sa_status!=2){?>
            /<a href="<?=Yii::app()->createUrl("admin/application/edit",array("id"=>$data->sa_id))?>"><?=$data->sa_isdel==1?"编辑":"恢复"?></a>
        <?php  }?>
        
        <?php /*if($data->sa_type==4 && $data->sa_status==2){ $data->sa_type=5?>
                /<a href="<?=Yii::app()->createUrl("admin/application/add",array("sid"=>$data->sa_sid,"type"=>$data->sa_type))?>">
                恢复申请</a>
        <?php }*/?>
        <?php  if($data->sa_isdel==1&&(Yii::app()->user->role==4||$data->sa_status!=2)){?>
        / <a href="javascript:void(0)" onclick="deleteOne('application','<?=$data->sa_id?>')">删除</a>
        <?php }?>
    </td>
</tr>