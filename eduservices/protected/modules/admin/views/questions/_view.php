<tr>
		<td><input type="checkbox" name="selectdel[]" value="<?=$data["t_id"]?>"></td>
        <td><?echo ($k+1)."[".$data["t_id"]."]"?></td>
		<td>
        <?php
        foreach($type as $k=>$val){
          if($k==$data["t_type"]) echo $val;//  echo $k."--".$val."<br>";               
        }
        ?>
        </td>
		<td><?=$data["t_know"]?></td>
		<td><?=$data["t_level"]?></td>
		<td><?=$data["t_level"]?></td>
		<td><?=$data["t_con"]?></td>
        <?$t_ansarr = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G');?>
		<td><?=$t_ansarr[$data["t_answer"]]?></td>
		<td>
			<a href="<?=Yii::app()->createUrl("admin/questions/view",array("id"=>$data["t_id"]))?>">预览</a>/
			<a href="<?=Yii::app()->createUrl("admin/questions/edit",array("id"=>$data["t_id"]))?>">修改</a>/
			<?php  if($data->t_isdel==1){?>
            <a href="javascript:void(0)" onclick="deleteOne('questions','<?=$data->t_id?>')">删除</a>
            <?php }?>
		</td>
</tr>