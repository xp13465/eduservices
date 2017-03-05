<?php 
$this->breadcrumbs=array(
	'题库管理'=>array("questions/index"),
	'预览试题',
);
$this->menu=array(
	array('label'=>'编辑', 'url'=>array('edit',"id"=>$model->t_id)),
);
$url=isset($_COOKIE['tkreturnurl'])?$_COOKIE['tkreturnurl']:array("index");

$this->menu=array(
    array('label'=>'返回列表', 'url'=>$url),
    array('label'=>'编辑', 'url'=>array("questions/edit","id"=>$model->t_id)),
);

?>
<link href="/css/student/exam-public.css" rel="stylesheet" type="text/css" />
<div class="breadcrumb">
	知识点：<font color="#0089F8"><?=$model->t_know?></font>&nbsp;&nbsp;
	题型：<font color="#0089F8"><?=Topic::$type[$model->t_type]?></font>&nbsp;&nbsp;
	难度：<font color="#0089F8"><?=$model->t_level?></font>
</div>	
<div class="breadcrumb">
	<label>题目内容：<?=$model->t_con?></label>
    <label>参考文章：<?=$model->t_article?></label>
   <?php
        $Arr=unserialize($model->t_daxx);
                            $checkArr=explode(",",$model->t_answer);
                            $i=1;
                            $array=array("1"=>"A","2"=>"B","3"=>"C","4"=>"D","5"=>"E","6"=>"F");
                            foreach($Arr as $key=>$val){
                            $inputtype=$model->t_type=="2"?"checkbox":"radio";
                            ?>
                            <label class="radio label-mag">
                                <input type="<?=$inputtype?>" <?=in_array($key,$checkArr)?"checked":""?> name="optionsRadios<?=$model->t_type=="2"?"[{$key}]":""?>" class="checkradio" class="cccc" value="<?=$key?>"  style="margin-top:10px;">
                                
                               <?php echo  "{$array[$i]}.{$val}"?>
                            </label>
    
   <?php  $i++;
   }?>
   
	<label class="radio">标准答案：
    <?php 
        
        $answer=explode(",",$model['t_answer']);
        foreach($answer as $k=>$v)echo $k===0?$array[$v]:','.$array[$v];
    ?>
   
    </label>		
</div>
<?/*<button class="btn btn-primary" type="submit" name="addsubmit" value="add">返回</button >*/?>