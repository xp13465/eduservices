<?php
/* @var $this ExamController */
/* @var $data Score */
?>
<tr class="gradeA"  align="center">
    <td>
       <?=$data["sc_id"]?> <?//=$key+1?><?=$index+1;?>/[<?=$data["sc_pkid"]?>]
    </td>
    <td>
        <?php 
        
            $model = Exampaper::model()->findByPk($data['sc_sjid']);
            echo $model->e_name;
        ?>
    </td>
    <td>
    <?php 
            echo date("Y-m-d H:i:s",$data['sc_sdt']);?>----<?php echo date("Y-m-d H:i:s",$data->sc_ldt);
    ?>
        (<?php  echo floor(($data->sc_time)/60)."分钟";?>)
        
    </td>    
    <td>
        <?php
            echo ($data['sc_kgmark']+$data['sc_zgmark'])>=$model->e_passs?"及格":"不及格"; ?>
    </td>
    

</tr>