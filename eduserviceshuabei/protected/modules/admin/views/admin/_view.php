<tr class="info-center">	
    <td><font color='red'>[<?=$data->ea_id?>]</font></td>
    <?php $rxkPcArr=Pici::model()->getAllPC(true,false);?>
    <td><?=isset($rxkPcArr[$data->ea_pkid])?$rxkPcArr[$data->ea_pkid]:$data->ea_pkid.""?></td>
    <td title='<?=$data->ea_examid?Exampaper::model()->getExamName($data->ea_examid):"系统判断层次专业"?>'><?=$data->ea_examid?Common::strCut(Exampaper::model()->getExamName($data->ea_examid),20):"系统判断层次专业出卷"?></td>
    <td><?=date("Y-m-d  H:i:s",$data->ea_stime)?>--<?=date("H:i:s",$data->ea_etime)?></td>
    <td><span><?=Examarrangement::$type[$data->ea_type]?></span></td>
    <td><a href='<?=Yii::app()->createUrl('admin/students/index',array("s_pc"=>$data->ea_pkid,"s_status"=>"2"))?>' >查看</a></td>
</tr>