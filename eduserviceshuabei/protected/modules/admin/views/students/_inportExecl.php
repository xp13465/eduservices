   
    <tr>
    <td ><?=$data->es_id?></td>
   <?php $centci="";
        if(strpos($data->es_zy,"高起专")){
            $centci="高起专";
        }
        if(strpos($data->es_zy,"专升本")){
            $centci="专升本";
        }?>
    <td ><?=$data->es_stuid?></td>
	<td ><?=$data->es_name?></td>
	<td ><?=$data->es_pici?></td>
	<td ><?=$data->es_zy?></td>
	<td ><?=$centci?></td>
	<td ><?=$data->es_kemu?></td>
	<td ><?=$data->es_score?></td>
	<td ><?=$data->es_kaodian?></td>
	<td ><?=$data->es_cardnumber?></td>
    </tr>