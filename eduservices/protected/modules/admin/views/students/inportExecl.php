<?php 
$this->breadcrumbs=array(
	'学员管理'=>array("students/manage"),
	'合并导入',
);

?>
<?php if(isset($_GET['inport'])&&in_array($_GET['inport'],array(1,2))){?>
<script>
function downscroll(){
	document.getElementById("listdiv").scrollTop = document.getElementById("listdiv").scrollHeight;
}
</script>
<div style='margin:10px auto;width:800px;border:0px solid #888;overflow:hidden'>
        
        <?php  if($sheetDataArr){ ?>
        <a class='btn'  href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'5'))?>" style="float:left;margin:10px ">返回列表</a>
		<a class='btn'  href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'5','inport'=>$_GET['inport']))?>" style="float:right;margin:10px ">继续导入</a>
			<div id='listdiv' style='margin:10px auto;width:800px;height:400px;;border:1px solid #888;overflow:auto'>
			<?php 
            
			$fp=fopen(DOCUMENTROOT."/EXECLlog.txt",'w');
            $time=time();
            foreach($sheetDataArr as $loadedSheetName=>$sheetData){
            $start=false;
            
                $type=0;
                if($sheetData&&count($sheetData)>=2){
                    echo "开始导入{$loadedSheetName}的记录...&nbsp;<br/>";
                }else{
                    echo "{$loadedSheetName}无记录...&nbsp;<br/>";
                }
                $curtime=time();
				$i=0;
				foreach($sheetData as $key=>$val){
                    if($i==0||$i%$seep==0){
                        $end=($i+$seep)<count($sheetData)-1?$i+$seep:count($sheetData)-2;
                        echo "正在导入第".($i+1)."-{$end}行记录...&nbsp;<br/>";
                        // sleep(1);
                    }
                    //登分表导入
                    if($_GET['inport']==1){
                        if(trim($val['A'])=="序号"){
                            $temp1=$sheetData[($key-1)]["A"];
                            $temp2=$sheetData[($key-2)]["A"];
                            $temp1start=strpos($temp1,"考场编号：");
                            $temp1end=strpos($temp1,"考试科目：");
                            $temp2start=strpos($temp2,"考点名称：");
                            $temp2end=strpos($temp2,"入学批次：");
                            $bianhao=trim(substr($temp1,$temp1start+15,$temp1end-15));
                            $kemu=trim(substr($temp1,$temp1end+15)); 
                            $kdmc=trim(substr($temp2,$temp2start+15,$temp2end-15));
                            $rxpc=trim(substr($temp2,$temp2end+15)); 
                            $start=true;
                            $type=1;
                        }else if(trim($val['A'])=="座号"){
                            $bianhao="";
                            $type=2;
                            $kemu=trim(substr($sheetData[($key-2)]['E'],strpos($sheetData[($key-2)]['E'],"课程名称：")+15)); 
                            $kdmc=trim(substr($sheetData[($key-2)]['A'],strpos($sheetData[($key-2)]['E'],"学习中心：")+15));
                            $kdmc=str_replace("：","",$kdmc);
                            $start=true;
                        }
                        if(stripos($val['A'],"考人数总计")||stripos($val['A'],"实到人数")){
                            $start=false;
                            $bianhao="";
                            $kemu="";
                            $kdmc="";
                            $rxpc="";
                            $type=0;
                        }
                        if(!$start||trim($val['A'])=="序号"||trim($val['A'])=="座号")continue;
                        // echo "<pre>";
                        // print_r($val);
                        foreach($val as $valkey=>$valval)$val[$valkey]=str_replace(" ","",$valval);
                        if($val['C']&&$val['B']&&$val['E']){
                            if($type==1){
                                $model=Execlscore::model()->find("es_zy='{$val['D']}' and es_kemu='{$kemu}' and es_stuid='{$val['C']}' and es_name='{$val['B']}' and es_cardnumber='{$val['E']}' and es_pici='{$rxpc}'");
                                $execlscore=$model?$model:new Execlscore;
                                
                                $execlscore->es_stuid=$val['C'];
                                $execlscore->es_name=$val['B'];
                                $execlscore->es_zy=$val['D'];
                                $execlscore->es_cardnumber=$val['E'];
                                $execlscore->es_qiandao=$val['F'];
                                if($val['G']){
                                    $execlscore->es_score=$val['G'];
                                }
                                
                                $execlscore->es_pici=$rxpc;
                                $execlscore->es_kaodian=$kdmc;
                                $execlscore->es_kaochangbianhao=$bianhao;
                                $execlscore->es_kemu=$kemu;
                                $execlscore->es_execlname=$loadedSheetName;
                                
                                $typeStr=$execlscore->isNewRecord?"导入":"更新";
                                if($execlscore->save()){
                                    fwrite($fp,mb_convert_encoding("{$rxpc}第{$key}行学员{$val["C"]} {$val["B"]} {$val["E"]} {$typeStr}成功！\n","GBK","UTF-8"));
                                }else{
                                    echo "$rxpc}第{$key}行学员【{$val["C"]}】&nbsp;【{$val["B"]}】&nbsp;【{$val["E"]}】 {$typeStr}失败！<br/>";
                                    fwrite($fp,mb_convert_encoding("{$rxpc}第{$key}行学员{$val["C"]} {$val["B"]} {$val["E"]} {$typeStr}失败！\n","GBK","UTF-8"));
                                }
                            }else if($type==2){
                                $rxpc=trim($val['B']);
                                $model=Execlscore::model()->find("es_zy='{$val['C']}' and es_kemu='{$kemu}' and es_stuid='{$val['D']}' and es_name='{$val['E']}' and es_cardnumber='{$val['F']}' and es_pici='{$rxpc}'");
                                $execlscore=$model?$model:new Execlscore;
                                
                                $execlscore->es_stuid=$val['D'];
                                $execlscore->es_name=$val['E'];
                                $execlscore->es_zy=$val['C'];
                                $execlscore->es_cardnumber=$val['F'];
                                $execlscore->es_qiandao=$val['G'];
                                if($val['H']){
                                    $execlscore->es_score=$val['H'];
                                }
                                $execlscore->es_pici=$rxpc;
                                $execlscore->es_kaodian=$kdmc;
                                $execlscore->es_kaochangbianhao=$bianhao;
                                $execlscore->es_kemu=$kemu;
                                $execlscore->es_execlname=$loadedSheetName;
                                $typeStr=$execlscore->isNewRecord?"导入":"更新";
                                if($execlscore->save()){
                                    fwrite($fp,mb_convert_encoding("{$rxpc}第{$key}行学员{$val["D"]} {$val["E"]} {$val["F"]} {$typeStr}成功！\n","GBK","UTF-8"));
                                }else{
                                    print_r($execlscore->errors);
                                    echo "$rxpc}第{$key}行学员【{$val["D"]}】&nbsp;【{$val["E"]}】&nbsp;【{$val["F"]}】 {$typeStr}失败！<br/>";
                                    fwrite($fp,mb_convert_encoding("{$rxpc}第{$key}行学员{$val["D"]} {$val["E"]} {$val["F"]} {$typeStr}失败！\n","GBK","UTF-8"));
                                }
                                
                            }
                            
                        
                        }
                        
                        
                        
                        
                    }else if($_GET['inport']==2){
                        if($key<2)continue;
                        $esmdel=Execlscore::model()->find("es_stuid = '{$val['A']}' and es_name  = '{$val['B']}' and es_pici = '{$val['C']}' and  es_zy = '{$val['D']}'  and es_kemu = '{$val['F']}'  ");
                        if($esmdel){
                            if($esmdel->es_kaodian!=$val['H']){
                                $esmdel->es_kaodian=$val['H'];
                                if($esmdel->save()){
                                    fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["A"]} {$val["B"]} {$val["C"]}  {$val["D"]} {$val['F']} 修改成功！\n","GBK","UTF-8"));
                                }else{
                                    echo "第{$key}行学员【{$val["A"]}】&nbsp;【{$val["B"]}】&nbsp;【{$val["C"]}】&nbsp;【{$val["D"]}】&nbsp;【{$val["F"]}】 修改失败！！<br/>";
                                    fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["A"]} {$val["B"]} {$val["C"]}  {$val["D"]} {$val['F']} 修改失败！\n","GBK","UTF-8"));
                                }
                            }
                        }else{
                            echo "第{$key}行学员【{$val["A"]}】&nbsp;【{$val["B"]}】&nbsp;【{$val["C"]}】&nbsp;【{$val["D"]}】&nbsp;【{$val["F"]}】 无此记录！<br/>";
                            fwrite($fp,mb_convert_encoding("第{$key}行学员{$val["A"]} {$val["B"]} {$val["C"]}  {$val["D"]} {$val['F']} 无此记录！\n","GBK","UTF-8"));
                        }
                    }
                    if($i==$end-1){
                        echo ceil(($i/(count($sheetData)-2))*100)."%完成<br/>";
                    }
                    $i++;
                    
				}
                $time3=time()-$curtime;
                if($sheetData&&count($sheetData)>=2){
                   echo "导入完成，用时{$time3}秒<br/><hr/>";
                }
            }
				$time2=time()-$time;
				echo "表格导入成功，共用时{$time2}秒";
                
				
			?>
			
			</div>
		 <a class='btn' href="<?=DOMAIN?>/EXECLlog.txt" target='_blank'>查看本次导入详细记录</a> 


<?php	}else{?>
			<form action="" enctype="multipart/form-data" method="post" name="upform">
			<table width="425" height="148" style="font-size:12px">
			  <tr>	
				<td height="89" align="left">execl表格:
				  <input name="upfile[]" type="file"  multiple="true"  /></td>
			  </tr>
			  <tr>
				<td height="26" align="left" bgcolor="">
                <input class='btn btn-primary' name="submit"  type="submit" value="开始导入" />　　　　
                <a class='btn'  href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'5'))?>">返回列表</a>
                </td>
			  </tr>
			</table>
			</form>
<?php }?>
</div>
<script>downscroll()</script>
<?php }else{?>

<form id='searchmenu' action="" method="get" >
 <input class="width80" type="text" name='searchid' onfocus='checkifocus("ID..",this)' onblur='checkiout("ID..",this)'  value="<?=isset($_GET['searchid'])&&$_GET['searchid']?$_GET['searchid']:"ID.."?>">
  <input class="span4" type="text" name='name' onfocus='checkifocus("姓名..",this)' onblur='checkiout("姓名..",this)'  value="<?=isset($_GET['name'])&&$_GET['name']?$_GET['name']:"姓名.."?>">
 <input class="span4" type="text" name='number' onfocus='checkifocus("学号..",this)' onblur='checkiout("学号..",this)'  value="<?=isset($_GET['number'])&&$_GET['number']?$_GET['number']:"学号.."?>">
 <input class="width80" type="text" name='card' onfocus='checkifocus("身份证..",this)' onblur='checkiout("身份证..",this)'  value="<?=isset($_GET['card'])&&$_GET['card']?$_GET['card']:"身份证.."?>">
<?php /*<input class="width80" type="text" name='pici' onfocus='checkifocus("批次..",this)' onblur='checkiout("批次..",this)'  value="<?=isset($_GET['pici'])&&$_GET['pici']?$_GET['pici']:"批次.."?>">*/?>
<input class="width80" type="text" name='zhongxin' onfocus='checkifocus("中心..",this)' onblur='checkiout("中心..",this)'  value="<?=isset($_GET['zhongxin'])&&$_GET['zhongxin']?$_GET['zhongxin']:"中心.."?>">
<br/>
&nbsp;&nbsp;<button type="button" onclick="return ckform(1)" class="btn btn-inverse serach">搜索</button>
&nbsp;&nbsp;<a class="btn btn-primary serach" href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'5','inport'=>'1'))?>">导入</a>
&nbsp;&nbsp;<a class="btn btn-primary serach" href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'5','inport'=>'2'))?>">学习中心变更导入</a>
&nbsp;&nbsp;<button type="button" onclick="return ckform(2)" class="btn btn-success serach">导出统计表</button>
&nbsp;&nbsp;<button type="button" onclick="return ckform(3)" class="btn btn-success serach">导出签到表</button>
&nbsp;&nbsp;<a class="btn btn-danger serach" target="_blank" href="<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'clear'))?>" onclick="return confirm('是否清空数据？')">清空数据</a>
</form>
 <script>
 function ckform(type){
    if(type==1){
        $("#searchmenu").attr("method","get").attr("action","<?=Yii::app()->createUrl("admin/students/inportSM",array('type'=>'5'))?>").submit();
    }else if(type==2){
        $("#searchmenu").attr("method","post").attr("action","<?=Yii::app()->createUrl("admin/students/OutExcelhz")?>").submit();
    }else if(type==3){
        $("#searchmenu").attr("method","post").attr("action","<?=Yii::app()->createUrl("admin/students/OutExceldfb")?>").submit();
    }
    return false;
 }
 </script>
        <?php  
    $criteria=new CDbCriteria;
    foreach($_GET as $key=>$val){
        $val = addslashes($val);
        if($key=="searchid"&&$val&&$val!="ID..")$criteria->addCondition("es_id  = '{$val}' ");
        // if($key=="name"&&$val&&$val!="姓名..")$criteria->addCondition("es_name  regexp '{$val}' ");
		if($key=="name"&&$val&&$val!="姓名.."){
            $Arr=explode("|",$val);
            foreach($Arr as $k=>$v)$Arr[$k]=trim($v);
            if(count($Arr)>1){
                $criteria->addInCondition("es_name",$Arr);
            }else{
                $criteria->addCondition("es_name  regexp '{$val}' ");
            }
        }
        if($key=="number"&&$val&&$val!="学号.."){
            $Arr=explode("|",$val);
            foreach($Arr as $k=>$v)$Arr[$k]=trim($v);
            if(count($Arr)>1){
                $criteria->addInCondition("es_stuid",$Arr);
            }else{
                $criteria->addCondition("es_stuid  regexp '{$val}' ");
            }
        }
		if($key=="card"&&$val&&$val!="身份证..")$criteria->addCondition("es_cardnumber  regexp '{$val}' ");
		if($key=="pici"&&$val&&$val!="批次..")$criteria->addCondition("es_pici  regexp '{$val}' ");
		if($key=="zhongxin"&&$val&&$val!="中心..")$criteria->addCondition("es_kaodian  regexp '{$val}' ");
	}
    $pageSize=isset($_COOKIE['countpage'])?$_COOKIE['countpage']:"20";
    $criteria->order="es_stuid desc";
    $dataProvider =  new CActiveDataProvider("Execlscore", array(
		'criteria'=>$criteria,
		'pagination'=>array(
				'pageSize'=>$pageSize,
		),
	));
    $Arrays=$dataProvider->getData();
?>
<table class="table table-bordered margin0 userlist ">
	<thead>
	<tr>
    <th>ID</th>
	<th>学号</th>
    <th>姓名</th>
    <th>批次</th>
    <th>专业</th>
    <th>层次</th>
    <th>科目</th>
    <th>分数</th>
    <th>中心</th>
    <th>身份证</th>
	</tr>
    </thead>
    
    <?php 
	if(!$Arrays){?>
	<tr>
	<td colspan='14'>没有找到数据</td>
	</tr>
        <?php }else{
            foreach($Arrays as $key=>$data){
                   $this->renderPartial('_inportExecl',array("data"=>$data,"key"=>$key));
            ?>
        <?php }
        }?>
</table>
<div class="clear ohidden margin-t20">
	<p class="pull-left">
    </p>
	<p class="input-append pull-right">
		<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("countpage",this.value)}' type="text" value="<?=isset($_COOKIE['countpage'])?$_COOKIE['countpage']:"20"?>">
		<button class="btn btn-info" type="button" onclick='setpagesize("countpage",$("#pagesize").val())'>设置每页显示条数</button>
	</p>
</div>
<div class="clear ohidden">
	<div class="pagination pull-left">
	<?php 	$this->widget('CBootstraplinkPager',array(
				'pages'=>$dataProvider->pagination,
			));?>
	</div>
	<div class="pagination pull-right">
		当前第<span class="blcolor weight"><?=$dataProvider->pagination->currentPage+1?></span>页，
		共<span class="blcolor weight"><?=ceil($dataProvider->pagination->itemCount/$dataProvider->pagination->pageSize)?></span>页，
		共有<span class="blcolor weight"><?=$dataProvider->pagination->itemCount?></span>条数据。
	</div>
</div>
<?php }?>