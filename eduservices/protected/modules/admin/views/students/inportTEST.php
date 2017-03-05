<?php 
$this->breadcrumbs=array(
	'学员管理'=>array("students/manage"),
	'北航学生照片导入测试',
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
	<h1>北航学生照片导入测试</h1>
	
	<?php 	
    // echo "<pre>";
    // print_r($sheetDataArr);exit;
        if($sheetDataArr){
      
    ?>
		<a href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'4'))?>" style="float:right;margin:10px ">继续导入</a>
			<div id='listdiv' style='margin:10px auto;width:800px;height:400px;;border:1px solid #888;overflow:auto'>
			<?php 
            
			$fp=fopen(DOCUMENTROOT."/inlog.txt",'w');
            $time=time();
            foreach($sheetDataArr as $loadedSheetName=>$sheetData){
                if($sheetData&&count($sheetData)>=7){
                    echo "开始导入{$loadedSheetName}的记录...&nbsp;<br/>";
                }else{
                    echo "{$loadedSheetName}无记录...&nbsp;<br/>";
                }
                $curtime=time();
				$i=$num=0;
				foreach($sheetData as $key=>$val){
					if($key<7)continue;
					if($i==0||$i%$seep==0){
						$end=($i+$seep)<count($sheetData)-1?$i+$seep:count($sheetData)-7;
						echo "正在导入第".($i+1)."-{$end}条记录...&nbsp;<br/>";
						// sleep(1);
					}
					if($i==$end-1){
						echo ceil(($i/(count($sheetData)-7))*100)."%完成<br/>";
					}
                    
                      // echo "<pre>";
                      
                    // print_r($val['D']);
                    $url="http://202.43.154.166/incoming/photo/201309/recruit/{$val['D']}.jpg";
                    if( !@fopen( $url, 'r' ) ) 
                    {   $num++;
                        echo "{$val['B']}　{$val['C']}　{$val['D']}学员照片不存在<br/>";
                        fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["B"]} {$val["C"]} {$val["D"]} 学员照片不存在！\n","GBK","UTF-8"));
                    } 
                    
                    // exit;
                    
					echo '<script>	downscroll()</script>';
					$i++;
					flush(); 
					
				}
                fwrite($fp,mb_convert_encoding("共{$num}条记录照片不存在\n","GBK","UTF-8"));
                $time3=time()-$curtime;
                if($sheetData&&count($sheetData)>=7){
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
				<td height="89" align="left">审核登记execl表格:
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