<?php 
$this->breadcrumbs=array(
	'题库管理'=>array("questions/index"),
	'导入题库',
);
?>
<script>
function downscroll(){
	document.getElementById("listdiv").scrollTop = document.getElementById("listdiv").scrollHeight;
}
</script>
<div style='margin:10px auto;width:500px;border:0px solid #888;overflow:hidden'>
	<h1>北航学生考试题库导入</h1>			
	<?php
        $pre = 0;
        $next = 0;
        function judge($A){
            $pos = strpos($A, 'NO.');            
            if ($pos === false) {return false;} else {return true;}
        }
        function getKey($tikucat){
            $type=Topic::$type;
            foreach($type as $key=>$val){
                if($tikucat == $val){
                    return $key;
                }
            }
            return '';
        }
        function getAnswerNum($answer){
            $answer=strtoupper($answer);
            $answer = explode(',',$answer);
            $arr = array(1=>'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');  
            foreach($answer as &$value){
                foreach($arr as $key=>$val){
                    if(trim($value) == $val){
                        $value = $key;
                    }
                }
            }
            sort($answer);
            return implode (',',$answer);
        }
        if($sheetDataArr){        
    ?>
		<a href="<?=Yii::app()->createUrl("admin/questions/importq")?>" style="float:right;margin:10px ">继续导入</a>
			<div id='listdiv' style='margin:10px auto;width:800px;height:400px;;border:1px solid #888;overflow:auto'>
			<?php 
            
			$fp=fopen(DOCUMENTROOT."/inlog.txt",'w');
            $time=time();            
            foreach($sheetDataArr as $loadedSheetName=>$sheetData){
                if($sheetData&&count($sheetData)>=4){
                    echo "开始导入{$loadedSheetName}的记录...&nbsp;<br/>";
                }else{
                    echo "{$loadedSheetName}无记录...&nbsp;<br/>";
                }
                $curtime=time();
				$i=0;
				foreach($sheetData as $key=>$val){
					if($key<4)continue;
					if($i==0||$i%$seep==0){
						$end=($i+$seep)<=count($sheetData)?$i+$seep:count($sheetData);
						echo "正在导入第".($i+1)."-{$end}条记录...&nbsp;<br/>";
						// sleep(1);
					}
                    
					if($i==$end-1){
						echo ceil(($i/(count($sheetData)))*100)."%完成<br/>";
					}
                    
                    //记录上一个题目和下一个题目开始位置
                    if(judge($val['A'])&&$key==4){
                        $pre = $key;
                    }elseif(judge($val['A'])&&$key!=4){
                        $next = $key;
                    }
                    //设置一个最后题目位置
                    if($key == count($sheetData)){
                        $next = $key+2;
                    }
                    //但遍历到下一个题目开始时插入前一个题目数据
                    if($key > 4 && $pre != $next && $next > 4){                        
                        $data = new Topic;
                        $data->t_qid = Questions::model()->getTikuIdByName($sheetData[$pre]['C']);
                        $data->t_type = getKey($sheetData[$pre]['D']);
                        $data->t_know = $sheetData[$pre]['E'];
                        $data->t_level = $sheetData[$pre]['F'];
                        //$data->t_score = $sheetData[$pre]['G'];
                        $data->t_validity = $sheetData[$pre]['G']?strtotime($sheetData[$pre]['G']):strtotime('2029-01-01');                        
                        $data->t_answer = getAnswerNum($sheetData[$pre]['H']);
                        $data->t_con = $sheetData[$pre+1]['B'];
                        $data->t_article = $sheetData[$pre+2]['B'];
                        
                        $t_daxx = array();                        
                        for($i=$pre+3;$i<$next-1;$i++){
                            $t_daxx[getAnswerNum($sheetData[$i]['B'])] = $sheetData[$i]['C'];
                        }
                        $data->t_daxx = serialize($t_daxx);
                        $criteria = new CDbCriteria;
                        if($data->t_article == ''){
                            $criteria->compare("t_con",$data->t_con);
                        }else{
                            $criteria->compare("t_con",$data->t_con);
                            $criteria->compare("t_article",$data->t_article);
                        }
                        if(Topic::model()->count($criteria)){
                            echo "第".$pre."行题目已经存在,导入失败<br/>";
                            fwrite($fp,mb_convert_encoding("第".$pre."行题目已经存在,导入失败\n","GBK","UTF-8"));
                        }else{
                            if($data->save()){
                                echo "第".$pre."行题目导入成功<br/>";
                                fwrite($fp,mb_convert_encoding("第".$pre."行题目导入成功\n","GBK","UTF-8"));
                            }else{
                                 echo "第".$pre."行题目导入失败,格式或者数据错误<br/>";
                                fwrite($fp,mb_convert_encoding("第".$pre."行题目导入失败,格式或者数据错误\n","GBK","UTF-8"));
                            }
                        }
                        
                        $pre = $next;
                    }
					echo '<script>	downscroll()</script>';
					$i++;
					flush(); 					
				}
                $time3=time()-$curtime;
                if($sheetData&&count($sheetData)>=3){
                   echo "{$loadedSheetName}导入完成，用时{$time3}秒<br/><br/>";
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
				<td height="89" align="left">execl表格:
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