<?php
$this->breadcrumbs=array(
	'试卷内容'
);


?>
<link href="/css/student/exam-public.css" rel="stylesheet" type="text/css" />

<div class="controls" style="text-align:center;">
	<label style="font-size:25px; font-weight:bold;"><?=$model->e_name?></label><br/>
	<?/*<label style="font-family:微软雅黑;font-size:13px;font-weight:normal;font-style:normal;text-decoration:none;color:#FF0000; ">! </label>*/?>
	<label class=''>
		<?/*<button class="btn btn-inverse serach">生成WORD试卷</button>
		<button class="btn btn-inverse serach">导出EXECL文件</button>
		<button class="btn btn-inverse serach">关闭</button> */?>
	</label>
</div>
<?php
        $Arr=$model->e_pstrategy?unserialize($model->e_pstrategy):array();
        $TMARR=array();
        foreach($Arr as $v)$TMARR[$v['tkcltk']]=array();
        $article=array();
        foreach($Arr as $val){
            foreach(Topic::$type as $k=>$v){
                $TMARR[$val['tkcltk']][$k]=isset($TMARR[$val['tkcltk']][$k])&&$TMARR[$val['tkcltk']][$k]?$TMARR[$val['tkcltk']][$k]:array();
            }
            $criteria=new CDbCriteria;
            $criteria->addCondition("t_qid ='{$val['tkcltk']}' ");
            $criteria->addCondition("t_level ='{$val['tkcllevel']}'");
            if($val['tkclknowName']!='所有')$criteria->addCondition("t_know ='{$val['tkclknowName']}'");
            $criteria->limit=$val['tkclvalue'];
            $criteria->order="rand()";
            $models=Topic::model()->findAll($criteria);
            
            foreach($models as $v){
                if($v->t_article){
                    if(in_array($v->t_article,$article)){
                        $akey=array_search($v->t_article,$article);
                    }else{
                        $article[]=$v->t_article;
                        $akey=array_search($v->t_article,$article);
                    }
                }else{
                    $akey='NULL';
                }
                $TMARR[$val['tkcltk']][$v['t_type']][$akey][]=$v->attributes;
            }
        }
?>
<div class="wrapper">
	<div class="exam">
		<div class="exam-note red">
            <?=nl2br($model->e_note)?>
		</div>
        <?php   
            $tknum=$tmnum=1;
            $tmdataArr=array();
                foreach($TMARR as $tkid => $tkArr){
                    if(!$tkArr)continue;?>
                    <h2 class="exam-tips"><?php echo Common::$ChineseNumber[$tknum]."、".Questions::model()->getNameById($tkid)?></h2>
        <?php       $typenum=1;
                    foreach($tkArr as $typeid => $tmArr){
                        if(!$tmArr)continue;?>
                        <h3 class="exam-tips"><?php echo $typenum.")、".Topic::$type[$typeid]?></h3>  <?/*题目类型的小类如单选 多选等*/?>
        <?php           foreach($tmArr as $key=>$val){
                            $showa=count($val)>1&&$val[0]['t_article']!='NULL'?true:false;
                            
                            foreach($val as $kss=>$vss){
                                $data=$vss;
                                if($showa){
                                    echo "<div class='exam-read'>".$data['t_article']."</div>";
                                    $showa=false;
                                }
                                $daxxs=unserialize($data['t_daxx']);
                                $daArr=$daxx=array();
                                if($daxxs&&is_array($daxxs)){
                                    $i=1;
                                    $array=array("1"=>"A","2"=>"B","3"=>"C","4"=>"D","5"=>"E","6"=>"F");
                                    foreach($daxxs as $k=>$v){
                                        $knum=array_rand($daxxs);
                                        $daArr[$knum]="{$array[$i]}.{$daxxs[$knum]}";
                                        $daxx[$knum]="{$array[$i]}";
                                        unset($daxxs[$knum]);
                                        $i++;
                                    }
                                }
                                ?>
                                    <div class="exam-list">
                                        <h6 class="exam-title"><?=$tmnum?>、<?=$data['t_con']?></h6>
                                        <?php echo $key==='NULL'||count($val)==1?"<div class='exam-read' >".$data['t_article']."</div>":"";?>
                                        
                                        <input type='hidden' name='con[<?=$tmnum?>]' value='<?=$data['t_id']?>'/>
                                        <ul class="exam-answer">
                                            <?php  
                                            $listType=$typeid==2?"checkboxList":"radioButtonList";
                                            // if(!$scoremodel->isNewRecord){
                                            if($model->isNewRecord){
                                                $uanswer=$vss['answer']?$typeid==2?explode(",",$vss['answer']):$vss['answer']:'';
                                            }else{
                                                $uanswer='';
                                            }
                                            echo CHtml::$listType("selt[{$tmnum}]",$uanswer,$daArr,array('template'=>'<li>{input}{label}</li>','separator'=>"    "));  ?>
                                        </ul>
                                    </div>
        <?php                $tmnum++;
                            }
                        }
                        $typenum++;
                    }
                    $tknum++;
                }
        ?>
	</div>
	<div class="exam-submit"><input type="button" onclick='checkform()' value="试卷答题完成,提交试卷"/></div>
</div>