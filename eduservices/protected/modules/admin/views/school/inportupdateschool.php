<?php 
$this->breadcrumbs=array(
	'院校管理'=>array("school/index"),
	'学院信息导入更新',
);
?>
<script>
function downscroll(){
	document.getElementById("listdiv").scrollTop = document.getElementById("listdiv").scrollHeight;
}
</script>
<div style='margin:10px auto;width:500px;border:0px solid #888;overflow:hidden'>
	<h1>学院信息导入更新</h1>
	
	<?php 	if($sheetData){?>
		<a href="" style="float:right;margin:10px ">继续导入</a>
			<div id='listdiv' style='margin:10px auto;width:490px;height:400px;;border:1px solid #888;overflow:auto'>
			<?php 
				$time=time();
				$i=0;
				$fp=fopen(DOCUMENTROOT."/inschoollog.txt",'w');
				foreach($sheetData as $key=>$val){
					if($key<2)continue;
					if($i==0||$i%$seep==0){
						$end=($i+$seep)<count($sheetData)-1?$i+$seep:count($sheetData)-1;
						echo "正在导入第".($i+1)."-{$end}条记录...&nbsp;<br/>";
						// sleep(1);
					}
					if($i==$end-1){
						echo ceil(($i/(count($sheetData)-1))*100)."%完成<br/>";
					}
                    $ProModel=Province::model()->find("pname = '{$val["C"]}'");
                    if($ProModel){
                        $data=School::model()->count("s_code = '{$val["A"]}' ")?School::model()->find("s_code = '{$val["A"]}' "):new School;
                        $data->s_name=$val["B"];
                        $data->s_province=$ProModel->pid;
                        $data->s_history=$val["D"];
                        $typeStr=$data->isNewRecord?"导入":"更新";
                        if($data->save()){
                            fwrite($fp,iconv("utf-8","gbk","第{$key}行{$val["B"]} {$val["A"]} {$val["C"]},{$typeStr}成功！\n"));
                        }else{
                            echo "第{$key}行{$val["B"]}&nbsp;{$val["A"]}&nbsp;{$val["C"]},{$typeStr}失败!<br/>";
                            fwrite($fp,iconv("utf-8","gbk","第{$key}行{$val["B"]} {$val["A"]} {$val["C"]},{$typeStr}失败！\n"));
                        }
                    }else{
                        echo "第{$key}行{$val["B"]}&nbsp;{$val["A"]}&nbsp;的省份 {$val["C"]} 本站不存在，无法导入！联系管理员<br/>";
                        fwrite($fp,iconv("utf-8","gbk","第{$key}行{$val["B"]} {$val["A"]} 的省份{$val["C"]} 本站不存在，无法导入！联系管理员\n"));
                    }
					echo '<script>	downscroll()</script>';
					$i++;
					flush(); 
					
				}
				$time2=time()-$time;
				echo "100%完成<br/>表格导入成功，用时{$time2}秒";
				
			?>
			
			</div>
		 <a href="<?=DOMAIN?>/inschoollog.txt" target='_blank'>查看本次导入详细记录</a> 


<?php	}else{?>
			<form action="" enctype="multipart/form-data" method="post" name="upform">
			<table width="425" height="148" style="font-size:12px">
			  <tr>	
				<td height="89" align="left">execl表格:
				  <input name="upfile" type="file"  /></td>
			  </tr>
			  <tr>
				<td height="26" align="left" bgcolor=""><input name="submit" type="submit" value="开始导入" /></td>
			  </tr>
			</table>
			</form>
<?php }?>
</div>
<script>downscroll()</script>
</body>
</html>