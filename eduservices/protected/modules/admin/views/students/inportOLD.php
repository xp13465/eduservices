<?php 
$this->breadcrumbs=array(
	'学员管理'=>array("students/manage"),
	'北航学生学籍导入',
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
	<h1>北航学生学籍导入</h1>
	
	<?php 	
    // echo "<pre>";
    // print_r($sheetDataArr);exit;
        if($sheetDataArr){
        // echo "<pre>";
        // print_r($sheetDataArr);exit;
    ?>
		<a href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'1'))?>" style="float:right;margin:10px ">继续导入</a>
			<div id='listdiv' style='margin:10px auto;width:800px;height:400px;;border:1px solid #888;overflow:auto'>
			<?php 
            
			$fp=fopen(DOCUMENTROOT."/inlog.txt",'w');
            $time=time();
            foreach($sheetDataArr as $loadedSheetName=>$sheetData){
                if($sheetData&&count($sheetData)>=2){
                    echo "开始导入{$loadedSheetName}的记录...&nbsp;<br/>";
                }else{
                    echo "{$loadedSheetName}无记录...&nbsp;<br/>";
                }
                $curtime=time();
				$i=0;
				foreach($sheetData as $key=>$val){
					if($key<2)continue;
					if($i==0||$i%$seep==0){
						$end=($i+$seep)<count($sheetData)-1?$i+$seep:count($sheetData)-2;
						echo "正在导入第".($i+1)."-{$end}条记录...&nbsp;<br/>";
						// sleep(1);
					}
					if($i==$end-1){
						echo ceil(($i/(count($sheetData)-2))*100)."%完成<br/>";
					}
                    
                    $studentModel=new Students;
                    $studentModel->s_credentialsimg1=DEFAULTIMG;
                    $studentModel->s_headerimg=DEFAULTIMG;
                    
                    $studentModel->s_credentialsimg2=DEFAULTIMG;
                    $studentModel->s_oldimg=DEFAULTIMG;
                    $studentModel->s_idbd=3;
                    $studentModel->s_stype=2;
                    $studentModel->s_zsbzm='NULL';
                    $studentModel->s_addid=$val['A'];
                    $studentModel->s_editid=Yii::app()->user->id;
                    $studentModel->s_addtime=$studentModel->s_edittime=time();
                    
                    $YearArr=explode("年",$val['B']);
                    $MonthArr=array("春季"=>"03","秋季"=>"09");
                    $studentModel->s_pc=date("y",strtotime($YearArr[0]."-01-01")).$MonthArr[$YearArr[1]];
                    
                    $Prolevelmodel=Lookup::model()->find("lu_value='{$val['C']}'  ");
                    $studentModel->s_baokaocengci==$Prolevelmodel?$Prolevelmodel->lu_key:"";
                    
                    $Promodel=Professional::model()->find("p_name='{$val['D']}' ");
                    $studentModel->s_baokaozhuanye=$Promodel?$Promodel->p_id:"";
                    
                    $studentModel->s_name=$val['E'];
                    
                    if($SexType=array_search($val['G'],Students::$sex)){
                        $studentModel->s_sex=$SexType;
                    }
                    if($natType=array_search($val['H'],Lookup::model()->getClassInfo("nationality"))){
                        $studentModel->s_nationality=$natType;
                    }
                    $studentModel->s_birthdate=strtotime($val['I']);
                    if($polType=array_search($val['J'],Lookup::model()->getClassInfo("politicalstatus"))){
                        $studentModel->s_politicalstatus=$polType;
                    }
                    if($highType=array_search($val['K'],Students::$highesteducation)){
                        $studentModel->s_highesteducation=$highType;
                    }
                    // if($credType=array_search($val['F'],Students::$credentialstype)){
                        $studentModel->s_credentialstype=1;
                    // }
                    $studentModel->s_credentialsnumber=$val['L'];
                    if($maritalType=array_search($val['M'],Students::$marital)){
                        $studentModel->s_hunyinzhuangkuang=$maritalType;
                    }
                    $studentModel->s_familyaddress=$val['N'];
                    $studentModel->s_contactaddress=$val['N'];
                    $studentModel->s_birthaddress=$val['N'];
                    
                    $studentModel->s_phone=$val['L'];
                    $studentModel->s_email=$val['M'];
                    if($professionType=array_search($val['N'],Students::$profession)){
                        $studentModel->s_zhiyezhuangkuang=$professionType;
                    }
                    
                    
                    // $studentModel->s_gongzuodanwei=$val['Q'];
                    // $studentModel->s_youbian=$val['R'];
                    // $studentModel->s_contactaddress=$val['S'];
                    // $studentModel->s_tel=$val['T'];
                    // $studentsfromModel=Lookup::model()->find("lu_class='studentsfrom' and lu_value regexp '{$val['U']}'");
                    // $studentModel->s_sfromaddress=$studentsfromModel?$studentsfromModel->lu_key:0;
                    // $studentModel->s_birthaddress=$val['V'];
                    // if($studentsfromstatusType=array_search($val['W'],Lookup::model()->getClassInfo("studentsfromstatus"))){
                        // $studentModel->s_sfromtype=$studentsfromstatusType;
                    // }
                    // $studentModel->s_cjgztime=$val['X']&&strtotime($val['X'])?strtotime($val['X']):0;
                    $studentModel->s_oldschool=$val['AC'];
                    $studentModel->s_oldschoolcode=$val['AD'];
                    $studentModel->s_oldtime=$val['AF']&&strtotime($val['AF'])?strtotime($val['AF']):0;
                    // $studentModel->s_oldzhuanye=$val['AB'];
                    $studentModel->s_oldimgnumber=$val['AE'];
                    // if($enrollmentType=array_search($val['AD'],Students::$enrollment)){
                        // $studentModel->s_enrollment=$enrollmentType;
                    // }
                    // if($studyType=array_search($val['AE'],Students::$study)){
                        // $studentModel->s_study=$studyType;
                    // }
                    $studentModel->validate();
                    
                    echo "<pre>";
                    print_r($studentModel->errors);
                    
                    // echo $val['A'];
                    // echo $val['A'];
                    // echo $val['A'];
                    // echo $val['A'];
                    // echo $val['A'];
                    exit;
                     
                    // if($model->save()){
                        // fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["B"]} {$val["C"]} {$val["D"]} {$typeStr}成功！\n","GBK","UTF-8"));
                    // }else{
                        // echo "第{$key}行学员【{$val["B"]}】&nbsp;【{$val["C"]}】&nbsp;【{$val["D"]}】 {$typeStr}失败！<br/>";
                        // fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["B"]} {$val["C"]} {$val["D"]} {$typeStr}失败！\n","GBK","UTF-8"));
                    // }
                     
					echo '<script>	downscroll()</script>';
					$i++;
					flush(); 
					
				}
                $time3=time()-$curtime;
                if($sheetData&&count($sheetData)>=2){
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