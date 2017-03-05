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
	<tr <?=$data->s_sleavetype=="2"?"style='background-color:#F93'":"style=''"?>>
	<td><input type="checkbox" name="selectdel[]" value="<?=$data->s_id?>"></td>
	<td><?=$key+1?>&nbsp;&nbsp;[<?=$data->s_id?>]</td>
    <td class='showlist'><?=$data->s_rpc?></td>
    <?php $rxkPcArr=Pici::model()->getAllPC(false,false);?>
	<td>
        <?=isset($rxkPcArr[$data->s_pc])?$rxkPcArr[$data->s_pc]:$data->s_pc.""?>
        <?php   
            if($data->s_enrollment==1){
                if(isset($_GET['s_pc'])&&$_GET['s_pc']){
                    $EAmodels=Examarrangement::model()->findAll("ea_pkid ='{$data->s_pc}'");
                    if($EAmodels){
                        $PKarr=array();
                        foreach($EAmodels as $val)$PKarr[]=$val->ea_id;
                        $num=Score::model()->count("sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->s_id}' ");
                        // echo "sc_pkid ='{$data->s_pc}' and sc_sid ='{$data->s_id}'";
                        if($num){
                            // echo "sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->s_id}' and sc_status != 0  order by sc_kgmark desc";
                            $Score=Score::model()->find("sc_pkid in(".join(",",$PKarr).") and sc_sid ='{$data->s_id}' and sc_status != 0  order by sc_kgmark desc");
                            echo $Score?$Score->sc_kgmark?"[".$Score->sc_kgmark."]":"<font color='red'>未考</font>":"<font color='red'>未交卷</font>";
                        }else{
                            echo "<font color='red'>未考</font>";
                        }
                    }else{
                        echo "<font color='red'>未排</font>";
                    }
                }
            }elseif($data->s_enrollment==2){
                echo "免试";
            }
        ?>
    </td>
	<td><a href="<?=Yii::app()->createUrl("admin/students/view",array("id"=>$data->s_id))?>"><?=$data->s_name?></a></td>
	<td class="algin-left"><?=Students::$credentialstype[$data->s_credentialstype]."："?><?=$SFCardNum?></td>
	<td class='showtype1' title='<?=$data->s_birthaddress?>'><?=Common::strCut($data->s_birthaddress,18)?></td>
	<td class='showlist' ><?=$data->s_phone?></td>
	<td title='<?=Professional::model()->getZyName($data->s_baokaozhuanye)?>'><?=Lookup::model()->getValueName($data->s_baokaocengci,'professionallevel')?></td>
	<td class='showlist showtype2' title='<?=Professional::model()->getZyName($data->s_baokaozhuanye)?>'><?=Common::strCut(Professional::model()->getZyName($data->s_baokaozhuanye),21)?></td>
	
    <td><?=$data->s_sleavetype==2?"<span>":"<span class='".($data->s_status!=1?$data->s_status==2?'blcolor1':'rcolor':'ycolor')."'>"?><?=$data->s_sleavetype==2?"<font color='red'>已退学</font>":Students::$status[$data->s_status]?></span></td>
    <td title='<?=User::model()->getCnameByUid($data->s_addid)?>'><?=Common::strCut(User::model()->getCnameByUid($data->s_addid),15)?></td>
	<td class='showlist'><?=date("Y-m-d",$data->s_addtime)?></td>
    <?php /*if(isset($_GET['smtype'])&&$_GET['smtype']==2){ ?>
        <td class='showlist'><?=isset($data->manageinfo)?StudentsManage::$status[$data->manageinfo->sm_status]:"录入阶段"?></td>
    <?php   }*/?>
	<td>
	<a href="<?=Yii::app()->createUrl("admin/students/view",array("id"=>$data->s_id))?>">查看</a> 
	<?php  if(Yii::app()->user->role==4||$data->s_status!=2){?>
	 / <a href="<?=Yii::app()->createUrl("admin/students/edit",array("id"=>$data->s_id))?>"><?=$data->s_isdel=="1"?"编辑":"恢复"?></a>
	<?php }?>
	<?php  if($data->s_isdel==1&&(Yii::app()->user->role==4||$data->s_status!=2)){?>
	 / <a href="javascript:void(0)" onclick="deleteOne('students','<?=$data->s_id?>')">删除</a></td>
	<?php }?>
	<?//=$data->s_sleavetype=="2"?"</font>":""?></tr>