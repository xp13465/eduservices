<?php
/* @var $this ExampaperController */
/* @var $data Exampaper */


?>

<tr class="odd gradeX" align="center">
    <td>
        <?=$k+1;?>
    </td>
    <td>
        <?=$val->ea_id;?>场次
    </td>
    <td>
       <?=$exmodel->e_name;?>
    </td>
     
    <td>
        <?=date('Y-m-d H:i:s',$val->ea_stime)?>
    </td>
    <td>
        <?=date('Y-m-d H:i:s',$val->ea_etime)?>
    </td>
    <td>
        <?             
            echo floor(($val->ea_etime-$val->ea_stime)/3600)."小时".floor(($val->ea_etime-$val->ea_stime)%3600/60)."分";
        ?>
    </td>
    <td>
<?php 
       $mark=Score::model()->count("sc_kgmark >='{$exmodel->e_passs}' and sc_status!=0 and sc_isdel = 1 and sc_sjid  ='{$exmodel->e_id}' and sc_pkid = '{$val->ea_id}' and sc_sid=".Yii::app()->user->id);
?>

        <?php  
        if($mark){
            echo "考试已合格";
        }else{
        
             if($val->ea_stime>=time()){
             echo "未开考";
             }
             if($val->ea_etime<time()){
             echo "已结束";
             }
            if($val->ea_stime<=time()&&$val->ea_etime>=time()){
 
            ?>
                <a href='javascript:void(0)' onclick='openwin("<?=Yii::app()->createUrl('student/exam/add',array('id'=>$val->ea_id,'exid'=>$exmodel->e_id));?>")' ><?php $user_id = Yii::app()->user->id;echo isset($_COOKIE["examid_{$val->ea_id}_{$exmodel->e_id}_{$user_id}"])?"恢复考试":"参加考试"?></a> 
           <?php 
            }     
        }
           ?>
    </td>
</tr>