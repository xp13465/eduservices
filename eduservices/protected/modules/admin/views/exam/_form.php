<?php
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'exampaper',
            "htmlOptions"=>array(),
            'enableAjaxValidation'=>false,
        ));
        // print_r($model->attributes);
        $TMARR=unserialize($model->sc_thanswer);
            $tknum=$tmnum=1;
            $tmdataArr=array();
                foreach($TMARR as $tkid => $tkArr){
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
                                        <h6 class="exam-title"><?=$tmnum?>、<?=$data['t_con']?>&nbsp;<?=$data['t_level']?>分</h6>
                                        <?php echo $key==='NULL'||count($val)==1?"<div class='exam-read' >".$data['t_article']."</div>":"";?>
                                        <?/*<input type='hidden' name='con[<?=$tmnum?>]' value='<?=$data['t_id']?>'/>*/?>
                                        <ul class="exam-answer" style="list-style-type:none;">
                                            <?php  
                                            $listType=$typeid==2?"checkboxList":"radioButtonList";
                                            if(!$model->isNewRecord){
                                                $uanswer=$vss['answer']?$typeid==2?explode(",",$vss['answer']):$vss['answer']:'';
                                            }else{
                                                $uanswer='';
                                                
                                            }//'template'=>'<li>{input}{label}</li>','separator'=>"    "  
                                            // print_r($uanswer);
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
                                        <div class="label-con">
                                            <input type="radio" name="status[<?=$kss?>]" value="0" <?=$vss['status']==="0"?'checked="checked"':''?> class="radio"  > 错 
                                            <input type="radio" name="status[<?=$kss?>]" value="1" <?=$vss['status']==1?'checked="checked"':''?> class="radio" > 对 
                                            <input type="text" name="sfs[<?=$kss?>]" value="<?=$vss['sfs']?>">分
                                        </div>
                                    </div>
        <?php                $tmnum++;
                            }
                        }
                        $typenum++;
                    }
                    $tknum++;
                }
        ?>
        <div class="exam-submit"><input type="submit"  value="试卷答题完成,提交试卷"/></div>
        <?php
            $this->endWidget(); 
        ?>