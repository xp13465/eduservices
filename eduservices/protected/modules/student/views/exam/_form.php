<?php 
if($sjmodel->ea_stime>=time()){echo "<script>alert('尚未开考！');window.opener.location.href=window.opener.location.href;window.close()</script>";exit;}
if($sjmodel->ea_etime<time()){echo "<script>alert('考试已结束！');window.opener.location.href=window.opener.location.href;window.close()</script>";exit;}
// if($sjmodel->ea_stime<=time()&&$sjmodel->ea_etime>=time()){
     // if(time()-$sjmodel->ea_stime>1800){echo "<script>alert('考试已受限！');window.opener.location.href=window.opener.location.href;window.close()</script>";exit;}
// }
$isnew=false;      
 if($scoremodel->isNewRecord){
     $scoremodel->save();
     $isnew=true;
 }
$smodel=Students::model()->findByPk($scoremodel->sc_sid);

$userid = Yii::app()->user->id;
//$sjid=$sjmodel->ea_examid?$sjmodel->ea_examid:$_GET['exid'];
$etname = "examtime_{$_GET['id']}_{$scoremodel->sc_sjid}_{$userid}";
//echo $etname;die;
if(!isset($_COOKIE[$etname])||$_COOKIE[$etname]==''){
    setcookie($etname,0,time()+86400,"/");
    //echo "<script>window.open(window.location);</script>";die;
}elseif($scoremodel->sc_time>=$_COOKIE[$etname]){
    $_COOKIE[$etname] = $scoremodel->sc_time;
}elseif($scoremodel->sc_time<$_COOKIE[$etname]){
    $scoremodel->sc_time=$_COOKIE[$etname];
    $scoremodel->save();
}
?>
<div class="info ie6fixedTL" >
	<div class="info-box" >
		<div class="logo"><img src="/images/bhlogo-200.png" width="75" /><span>北京航空航天大学-在线考试</span></div>
		<div class="info-right">
			<div class="exam-time">考试人：<?=$smodel->s_name?> 考试总时间：
            <?php if($model->e_timecat==1){
                echo "不记时";
        
            }else if($model->e_timecat==2){
                echo "统一交卷";
        
            }else if($model->e_timecat==3){
                $Arr=explode(",",$model->e_timecat);
                echo $Arr['1']."分";
                echo "　离考试结束时间：<span id='t_fen'>".floor((($Arr['1']*60)-$scoremodel->sc_time)/60)."</span>分<span id='t_miao'>".((($Arr['1']*60)-$scoremodel->sc_time)%60)."</span>秒";
                ?>
                <script>
                var alltime=<?=($Arr['1']*60)?>
                var curtime=<?=($Arr['1']*60)-$scoremodel->sc_time?>;
                var timer4=setInterval("updatetime()",1000);
                function updatetime(){
                    if(curtime){
                        var fen=Math.floor(curtime/60);
                        var miao=curtime%60;
                        
                        document.getElementById('t_fen').innerHTML=fen;
                        document.getElementById('t_miao').innerHTML=miao;
                        curtime--;
                    }
                }
                </script>
        <?php }?>
    
        </div>
			<div class="box-save"><input type="button" onclick='saveform()' value="保存答案" /><input type="button" onclick='checkform()' value="提交试卷" /></div>
		</div>
        <?php /*入学考批次:[<i class="red"><?=Pici::model()->getPcById($smodel->s_pc)?></i>]
    性别<i class="red"><?=Students::$sex[$smodel->s_sex]?></i>&nbsp;
    报考层次<i class="red"><?=Lookup::model()->getValueName($smodel->s_baokaocengci,"professionallevel")?></i>&nbsp;
    报考专业<i class="red"><?=Professional::model()->getZyName($smodel->s_baokaozhuanye)?></i>&nbsp; */?>
	</div>
</div>
<?php 
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'exampaper',
        "htmlOptions"=>array(),
        'enableAjaxValidation'=>false,
    )); 
    if($isnew){
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
                // print_r($v->t_article);
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
    }else{
        $TMARR=unserialize($scoremodel->sc_thanswer);
    }
    //      echo "<pre>";print_r($TMARR);
    ?>  
<div class="wrapper">
	
	<div class="exam">
		<h1><?=$model->e_name?></h1>
		<div class="exam-note red">
            <?=nl2br($model->e_note)?>
		</div>
        <?php
            

            $examid = isset($_GET['id'])?$_GET['id']:'';
            $exammodel=Examarrangement::model()->findByPk($examid);
             $ckname = "sc_thanswer_{$exammodel->ea_id}_{$scoremodel->sc_sjid}_{$userid}";
             // @print_r($_COOKIE[$ckname]);
            $sc_thanswer = isset($_COOKIE[$ckname])?urldecode($_COOKIE[$ckname]):'';
            // print_r($sc_thanswer);
            parse_str($sc_thanswer);
            
            $tknum=$tmnum=1;
            $tmdataArr=$jsArr=array();
                foreach($TMARR as $tkid => $tkArr){
                    if(!$tkArr)continue;?>
                    <h2 class="exam-tips"><?php echo Common::$ChineseNumber[$tknum]."、".Questions::model()->getNameById($tkid)?></h2>
        <?php       $typenum=1;
                    foreach($tkArr as $typeid => $tmArr){
                       
                        if(!$tmArr)continue;?>
                        <h3 class="exam-tips"><?php echo $typenum.")、".Topic::$type[$typeid]?></h3>
        <?php           foreach($tmArr as $key=>$val){
                            $showa=false;
                            if($isnew){
                                $showa=count($val)>1&&$val[0]['t_article']!='NULL'?true:false;
                            }else{
                                $showa=count($val)>1&&$key='NULL'?true:false;
                            }
                            foreach($val as $kss=>$vss){
                                if(!$isnew){
                                 $data=Topic::model()->findByPk($vss['tid'])->attributes;
                                }else{
                                    $data=$vss;
                                }
                                if($showa){
                                    echo "<div class='exam-read'>".$data['t_article']."</div>";
                                    $showa=false;
                                }
                                $daxxs=unserialize($data['t_daxx']);
                                $daArr=$daxx=array();
                                if($daxxs&&is_array($daxxs)){
                                    $i=1;
                                    $array=array("1"=>"A","2"=>"B","3"=>"C","4"=>"D","5"=>"E","6"=>"F");
                                    if(!$isnew){
                                        foreach(explode(",",$vss['selected']) as $k=>$v){
                                                $daArr[$v]="{$array[$i]}.{$daxxs[$v]}";
                                                $daxx[$v]="{$array[$i]}";
                                                $i++;   
                                        }
                                    }else{
                                            foreach($daxxs as $k=>$v){
                                                $knum=array_rand($daxxs);
                                                $daArr[$knum]="{$array[$i]}.{$daxxs[$knum]}";
                                                $daxx[$knum]="{$array[$i]}";
                                                unset($daxxs[$knum]);
                                                $i++;
                                        }
                                    }
                                }
                                if($isnew){
                                    $tmdataArr[$tkid][$typeid][$key][$tmnum]['tid']=$data['t_id'];
                                    $tmdataArr[$tkid][$typeid][$key][$tmnum]['answer']='';
                                    $tmdataArr[$tkid][$typeid][$key][$tmnum]['status']=0;
                                    $tmdataArr[$tkid][$typeid][$key][$tmnum]['sfs']=0;
                                    $tmdataArr[$tkid][$typeid][$key][$tmnum]['selected']=join(",",array_keys($daArr));
                                }
                               $jsArr[$tmnum]=$typeid;
                                ?>
                                    <div class="exam-list">
                                        <h6 class="exam-title"><?=$tmnum?>、<?=$data['t_con']?></h6>
                                        <?php echo $key==='NULL'||count($val)==1?"<div class='exam-read' >".$data['t_article']."</div>":"";?>
                                        
                                        <input type='hidden' name='con[<?=$tmnum?>]' value='<?=$data['t_id']?>'/>
                                        <ul class="exam-answer">
                                            <?php  
                                            $listType=$typeid==2?"checkboxList":"radioButtonList";
                                            if(!$isnew){
                                                $vss['answer'] = isset($selt[$tmnum])&&$selt[$tmnum]!=''?$selt[$tmnum]:$vss['answer'];
                                                $uanswer=$vss['answer']?$typeid==2?explode(",",$vss['answer']):$vss['answer']:'';
                                            }else{
                                                $uanswer='';
                                            }
                                            echo CHtml::$listType("selt[{$tmnum}]",$uanswer,$daArr,array('template'=>'<li>{input}{label}</li>','separator'=>"    ","onchange"=>"checkselectOne(this)"));  ?>
                                        </ul>
                                        <?/*<span style="color:red" class="error" for="selt[<?=$tmnum?>]">请输入题库集名称</span>*/?>
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
<div id="albumform" style="display:none ">
	<div style='color:red;width:400px;height:200px;overflow-x:hidden;overflow-y:auto' id='checkmessage'>
    <?php   foreach($jsArr as $k=>$v){ ?>
          <span id="msgerror<?=$k?>" ><? if(!isset($selt[$k])||$selt[$k]==''){?>第<?=$k?>题未选择<br/><? }?></span>
    <?php   } ?>
    
    </div>
</div>  
<script>

function createAlbum(){
           var content = "<div id='alertform'>"+$("#albumform").html()+"</div>";
            jw.pop.customtip(
            "确认提交？",
            content,
            {
                hasBtn_ok:true,
                hasBtn_cancel:true,
                ok_label:"继续提交",
                cancel_label:"返回答题",
                zIndex:10000,
                ok: function(){
					unbindunbeforunload();
					setTimeout(function(){$('#exampaper').submit();},0);
                },
                btn_float:"center"
            }
        );
    }
</script>
<?php 

$this->endWidget(); 
// print_r(serialize($tmdataArr));
if($isnew){
    $scoremodel->sc_thanswer=serialize($tmdataArr);
    $scoremodel->save();
    if($model->e_btime<=time()&&$model->e_etime>=time()){
        setcookie("examid_{$exammodel->ea_id}_{$scoremodel->sc_sjid}_{$userid}",$scoremodel->sc_id,time()+86400,"/");
    }
}
?>


<script>	
window.opener.location.href=window.opener.location.href;







function setCookie(name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
    ((expires) ? "; expires=" + expires : "") +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") +
    ((secure) ? "; secure" : "");    
}

function getCookie(objName){//获取指定名称的cookie的值
var arrStr = document.cookie.split("; ");
for(var i = 0;i < arrStr.length;i ++){
    var temp = arrStr[i].split("=");
    if(temp[0] == objName) return unescape(temp[1]);
} 
}

function checkselectOne(obj){
    var tmh=obj.name.slice(5,obj.name.indexOf("]"));
    var flag=0;
            for(i=0;i<$("input[name='selt["+tmh+"]']").length;i++){
                if($("input[name='selt["+tmh+"]']").get(i).checked==true){
                    document.getElementById("msgerror"+tmh).innerHTML='';
                    flag=1;
                    break;
                }
            }
            if(!flag){
               document.getElementById("msgerror"+tmh).innerHTML="第"+tmh+"题未选择<br/>";
            }
            
   
}

function checkform(){
    unbindunbeforunload();
  
    <?php   /*foreach($jsArr as $k=>$v){ ?>
            var flag=0;
            for(i=0;i<$("input[name='selt[<?=$k?>]']").length;i++){
                if($("input[name='selt[<?=$k?>]']").get(i).checked==true){
                    flag=1;
                    break;
                }
            }
            if(!flag){
                checkstr+="第<?=$k?>题未选择<br/>";
            }
    <?php   } */?>
    createAlbum();
}

var ettime = "<?=isset($_COOKIE[$etname])?$_COOKIE[$etname]:$scoremodel->sc_time;?>";
var etname = "<?=$etname?>";
function changeettime(){

<?php  $ENDArr=explode(",",$model->e_timecat);
        if($ENDArr[0]==3){?>
        if(ettime>=<?=$ENDArr[1]*60?>){
            unbindunbeforunload();
            alert("考试时间已到，自动交卷");
            $('#exampaper').submit();
            clearInterval(timer2);
            return false;
        }
       <?php  }
        ?>
    
    ettime++;
}

function setettime(){
    setCookie(etname,ettime);
}
function setcurtime(time){
    ettime=time;
    curtime = alltime-time;
}
function saveform(typeid){
    datas=$('#exampaper').serialize();
    setCookie("<?=$ckname?>",datas);
    t=typeid?"1":'2';
    if(t==2){
        alert('保存成功！');
    }else{
    //datas+="&cktype="+t;
    $.ajax({
        type: "POST",  
        url:"<?=Yii::app()->createUrl("student/exam/edit/id/{$scoremodel->sc_id}")?>",  
    
        data:"&cktype="+t+"&ettime="+getCookie(etname),// 要提交的表单   
        //async:false,
        success: function(msg) {
        // alert(msg)
            if(msg=="timeover"){
                unbindunbeforunload();
                alert("您已被强制交卷！系统自动交卷！");
                $('#exampaper').submit();
            }else if(msg=='timeout'){
                unbindunbeforunload();
                alert("您的答题时间到！系统自动交卷！");
                $('#exampaper').submit();
            }else if(!isNaN(msg)){
                setcurtime(msg);
            }else if(msg=="noexam"){
                // window.opener.location.href=window.opener.location.href;
                unbindunbeforunload();
                alert("试卷已作废，自动关闭");
                window.close();
            }
        }  
    
    }); 
    }
}

function bindunbeforunload(){
window.onbeforeunload=perforresult;
}
function unbindunbeforunload(){
window.onbeforeunload=null;
}
function perforresult(){
	return"当前操作未保存，如果你此时离开，所做操作信息将全部丢失，是否离开?";
}
$(document).ready(function() {
bindunbeforunload();
var timer1=setInterval("saveform(1)", 60000);
var timer2=setInterval("changeettime()", 1000);
var timer3=setInterval("setettime()", 1000);
})
</script>
    

