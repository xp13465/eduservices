<?php 
$this->breadcrumbs=array(
	'学员管理'=>array("students/manage"),
	'北航录取学生信息导入',
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
	<h1>北航录取学生信息导入</h1>
	
	<?php 	
    // echo "<pre>";
    // print_r($sheetDataArr);exit;
        if($sheetDataArr){
    ?>
		<a href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'2'))?>" style="float:right;margin:10px ">继续导入</a>
			<div id='listdiv' style='margin:10px auto;width:800px;height:400px;;border:1px solid #888;overflow:auto'>
			<?php 
            
			$fp=fopen(DOCUMENTROOT."/inlog.txt",'w');
            $time=time();
            foreach($sheetDataArr as $loadedSheetName=>$sheetData){
                if($sheetData&&count($sheetData)>=8){
                    echo "开始导入{$loadedSheetName}的记录...&nbsp;<br/>";
                }else{
                    echo "{$loadedSheetName}无记录...&nbsp;<br/>";
                }
                $curtime=time();
				$i=0;
				foreach($sheetData as $key=>$val){
					if($key<4)continue;
					if($i==0||$i%$seep==0){
						$end=($i+$seep)<count($sheetData)-1?$i+$seep:count($sheetData)-2;
						echo "正在导入第".($i+1)."-{$end}条记录...&nbsp;<br/>";
						// sleep(1);
					}
					if($i==$end-1){
						echo ceil(($i/(count($sheetData)-2))*100)."%完成<br/>";
					}
                    $criteria=new CDbCriteria;
                    $criteria->with='studentinfo'; 
                    // $criteria->compare('sm_bmorder', $val['B']);
                    $criteria->compare('s_name', $val['C']);
                    $criteria->compare('s_credentialsnumber', $val['D']);
                    $model=StudentsManage::model()->find($criteria);
                    
                    if($model){
                    // echo $val['F'];
                        $model->sm_bmorder=$val['B'];
                        $model->sm_status=$val['F']=="录取"||$val['F']=="免试合格，予以录取"?2:3;
                        $model->sm_statusabout=$val['F']; 
                        $typeStr="设置";
                        
                        if($model->save()){
                            fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["B"]} {$val["C"]} {$val["D"]} {$typeStr}成功！\n","GBK","UTF-8"));
                        }else{
                            echo "第{$key}行学员【{$val["B"]}】&nbsp;【{$val["C"]}】&nbsp;【{$val["D"]}】 {$typeStr}失败！<br/>";
                            fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["B"]} {$val["C"]} {$val["D"]} {$typeStr}失败！\n","GBK","UTF-8"));
                        }
                    }else{
                        echo "第{$key}行学员【{$val["B"]}】&nbsp;【{$val["C"]}】&nbsp;【{$val["D"]}】 不存在或数据错误！<br/>";
                        fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["B"]} {$val["C"]} {$val["D"]}不存在或数据错误！\n","GBK","UTF-8"));
                    }
					echo '<script>	downscroll()</script>';
					$i++;
					flush(); 
					
				}
                $time3=time()-$curtime;
                if($sheetData&&count($sheetData)>=8){
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
				<td height="89" align="left">北航导出确认录取execl表格:
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