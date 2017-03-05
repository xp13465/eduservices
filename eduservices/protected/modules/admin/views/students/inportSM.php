<?php 
$this->breadcrumbs=array(
	'学员管理'=>array("students/manage"),
	'北航未确认学生信息导入',
);
$url=isset($_COOKIE['xylistreturnurl'])?$_COOKIE['xylistreturnurl']:array("manage");
$this->menu=array(
    array('label'=>'返回学员管理', 'url'=>$url),
);
?>
<script>
function downscroll(){
	document.getElementById("listdiv").scrollTop = document.getElementById("listdiv").scrollHeight;
}
</script>
<div style='margin:10px auto;width:800px;border:0px solid #888;overflow:hidden'>
	<h1>北航未确认学生信息导入</h1>
        
	<?php 	
        if($sheetDataArr){
        
    ?>
    
        <span style="float:left;margin:10px "><?=$error?></span>
		<a href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'1'))?>" style="float:right;margin:10px ">继续导入</a>
		
        <div id='listdiv' style='margin:10px auto;width:800px;height:400px;;border:1px solid #888;overflow:auto'>
			<?php 
            
			$fp=fopen(DOCUMENTROOT."/inlog.txt",'w');
            $time=time();
            foreach($sheetDataArr as $loadedSheetName=>$sheetData){
                if($sheetData&&count($sheetData)>=3){
                    echo "开始导入{$loadedSheetName}的记录...&nbsp;<br/>";
                }else{
                    echo "{$loadedSheetName}无记录...&nbsp;<br/>";
                }
                $curtime=time();
				$i=0;
				foreach($sheetData as $key=>$val){
					if($key<3)continue;
					if($i==0||$i%$seep==0){
						$end=($i+$seep)<count($sheetData)-1?$i+$seep:count($sheetData)-2;
						echo "正在导入第".($i+1)."-{$end}条记录...&nbsp;<br/>";
						// sleep(1);
					}
					if($i==$end-1){
						echo ceil(($i/(count($sheetData)-2))*100)."%完成<br/>";
					}
                    $model=Students::model()->find("s_name ='{$val["D"]}' and s_credentialsnumber ='{$val["G"]}' and s_isdel='1' and (s_status = '2' or s_stype ='2' ) ");
                    $phone=$val["L"];
                    if($model&&$model->s_phone!=$phone){
                        $phone.="手机号码不匹配";
                    }
                    if($model&&$model->s_stype=='1'){
                        
                        $data=StudentsManage::model()->count("sm_sid ='{$model->s_id}'")?StudentsManage::model()->find("sm_sid ='{$model->s_id}'"):new StudentsManage();
                        $data->sm_sid=$model->s_id;
                        $data->sm_bmorder=$val["C"];
                        $data->sm_zknumber=$val["C"];
                        $typeStr=$data->isNewRecord?"导入":"更新"; 
                        
                        if($data->save()){
                            if($model->s_phone!=$val["L"]){
                                echo "第{$key}行学员【{$val["D"]}】&nbsp;【{$val["G"]}】&nbsp;【{$phone}】 {$typeStr}成功！<br/>";
                            }
                            fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["D"]} {$val["G"]} {$phone} {$typeStr}成功！\n","GBK","UTF-8"));
                        }else{
                            echo "第{$key}行学员【{$val["D"]}】&nbsp;【{$val["G"]}】&nbsp;【{$phone}】 {$typeStr}失败！<br/>";
                            fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["D"]} {$val["G"]} {$phone} {$typeStr}失败！\n","GBK","UTF-8"));
                        }
                    }else{
                        echo "第{$key}行学员【{$val["D"]}】&nbsp;【{$val["G"]}】&nbsp;【{$phone}】 不存在或未审核！<br/>";
                        fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["D"]} {$val["G"]} {$phone}不存在或未审核！\n","GBK","UTF-8"));
                    }
					echo '<script>	downscroll()</script>';
					$i++;
					flush(); 
					
				}
                $time3=time()-$curtime;
                if($sheetData&&count($sheetData)>=3){
                   echo "导入完成，用时{$time3}秒<br/><hr/>";
                }
            }
				$time2=time()-$time;
				echo "表格导入成功，共用时{$time2}秒";
				
			?>
			
			</div>
		 <a href="<?=DOMAIN?>/inlog.txt" target='_blank'>查看本次导入详细记录</a> 

<?php	}else{?>
			<form action="" enctype="multipart/form-data" method="post" name="upform">
			<table width="425" height="148" style="font-size:12px">
			  <tr>	
				<td height="89" align="left">北航导出未确认表execl表格:
				  <input name="upfile" type="file"  /></td>
			  </tr>
			  <tr>
				<td height="26" align="left" bgcolor=""><input class='btn' name="submit" type="submit" value="开始导入" /></td>
			  </tr>
			</table>
			</form>
<?php }?>
</div>
<script>downscroll()</script>
</body>
</html>