<?php
$this->breadcrumbs=array(
	'考试管理'=>array('index'),
    '查看答案'
);
$url=isset($_COOKIE['ksgllistreturnurl'])?$_COOKIE['ksgllistreturnurl']:array("index");
$lbtitle=strstr($url,"scorelist.html")==false?"返回考试管理列表":"返回成绩查询列表";
$this->menu=array(
	array('label'=>$lbtitle, 'url'=>$url),
);
$sjModel=Exampaper::model()->findByPk($model->sc_sjid);//试卷表 成绩表 sc_sjid = e_id 
$smodel=Students::model()->findByPk($model->sc_sid);
?>
<style>
label {
  display: inline;
}
input[type="checkbox"] {
  margin: 0px;
}
</style>
<div class="controls" style="text-align:center;">
	<label style="font-size:25px; font-weight:bold;">试卷名称：<?php echo $sjModel['e_name']?></label>
	<label style="font-family:微软雅黑;font-size:13px;font-weight:normal;font-style:normal;text-decoration:none;">成绩： <?php echo $model->sc_kgmark + $model->sc_zgmark?>分</label>
</div>
<?php
    $TMARR=unserialize($model->sc_thanswer); //题号与答题内容序列化
            $tknum=$tmnum=1;
            $tmdataArr=array();
                foreach($TMARR as $tkid => $tkArr){//tkArr: 题目id 考生答案 题目对错 题目分数 选项排序
                    if(!$tkArr)continue;?>
                    <h2 class="exam-tips"><?php echo Common::$ChineseNumber[$tknum]."、".Questions::model()->getNameById($tkid)?></h2>
        <?php       $typenum=1;
                    foreach($tkArr as $typeid => $tmArr){
                        if(!$tmArr)continue;?>
                        <h3 class="exam-tips"><?php echo $typenum.")、".Topic::$type[$typeid]?></h3><?/*题目类型如：单选多选等*/?>
        <?php           foreach($tmArr as $key=>$val){
                            $showa=count($val)>1&&$key='NULL'?true:false;
                            foreach($val as $kss=>$vss){
                                $data=Topic::model()->findByPk($vss['tid'])->attributes;
                                if($showa){
                                    echo "<div class='exam-read'>".$data['t_article']."</div>";
                                    $showa=false;
                                }
                                $daxxs=unserialize($data['t_daxx']);
                                $daArr=$daxx=array();
                                if($daxxs&&is_array($daxxs)){
                                    $i=1;
                                    $array=array("1"=>"A","2"=>"B","3"=>"C","4"=>"D","5"=>"E","6"=>"F");
                                    foreach(explode(",",$vss['selected']) as $k=>$v){
                                            $daArr[$v]="{$array[$i]}.{$daxxs[$v]}";
                                            $daxx[$v]="{$array[$i]}";
                                            $i++;
                                    }  
                                }
                                ?>
                                    <div class="exam-list">
                                        <h6 class="exam-title"><?=$tmnum?>、<?=$data['t_con']?>&nbsp;本题：<?=$data['t_level']?>分</h6>
                                        <?php echo $key==='NULL'||count($val)==1?"<div class='exam-read' >".$data['t_article']."</div>":"";?>
                                        
                                        <input type='hidden' name='con[<?=$tmnum?>]' value='<?=$data['t_id']?>'/>
                                        <ul class="exam-answer" style="list-style-type:none;">
                                            <?php  
                                            $listType=$typeid==2?"checkboxList":"radioButtonList";
                                            if(!$model->isNewRecord){
                                                $uanswer=$vss['answer']?$typeid==2?explode(",",$vss['answer']):$vss['answer']:'';
                                            }else{
                                                $uanswer='';
                                            }
                                            echo CHtml::$listType("selt[{$tmnum}]",$uanswer,$daArr,$htmlOptions=array ('template'=>'<li>{input}{label}</li>','separator'=>"    " ,'disabled'=>"disabled"));  ?>
                                        </ul>
                                        <label class="label-con"><font color="#666666">答题要点：<?=$data['t_leaflet']?></font></label>
                                        <label class="label-con">
                                            <font color="#0000FF">标准答案：
                                            <?php $answer=explode(",",$data['t_answer']);
                                               foreach($answer as $bzk=>$bzv){echo $bzk===0?$daxx[$bzv]:',　'.$daxx[$bzv];}
                                            ?>
                                            </font>
                                        </label>
                                        <label class="label-con"><font color="#666666">考生答案：
                                        <?php
                                            $tempstr='';
                                            $ksanswer=explode(",",$vss['answer']);
                                            foreach($ksanswer as $ksk=>$ksv){
                                                if(isset($daxx[$ksv])&&$daxx[$ksv]){
                                                    $tempstr.=!$tempstr?$daxx[$ksv]:',　'.$daxx[$ksv];
                                                }
                                            }
                                            echo $tempstr;
                                        ?>
                                        </font></label>
                                        <label class="label-con"><font color="#666666">本题对错： <?php if($vss['status'] ==0){echo "错误";}else{ echo "正确";}?></font></label>
                                        <label class="label-con"><font color="#666666">本题得分：<?=$vss['sfs']?> </font></label> 
                                    </div>
        <?php                $tmnum++;
                            }
                        }
                        $typenum++;
                    }
                    $tknum++;
                }
        ?>