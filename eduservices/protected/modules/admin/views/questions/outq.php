<?php 
$this->breadcrumbs=array(
	'题库管理'=>array("questions/index"),
	'北航学员考试题库导出',
);
?>
<div style='margin:10px auto;width:500px;border:0px solid #888;overflow:hidden'>
	<h1>北航学生入学考试题库导出</h1>
    <div id="albumform" style="display:">
        <form id="qform" action='<?=Yii::app()->createUrl("admin/questions/outquestions")?>' target="_blank" method="get">
        <table width="500px">
            <tr style="line-height: 35px;">
                <td align="right" width="120px">题库集：</td>
                <td align="left" >
                    <?php 
                     echo CHtml::dropDownList('q_id','', Questions::model()->getAllTK(0),
                    array(
                        'empty'=>'请选择题库集',
                        'class'=>"wauto",
                        'ajax' => array(
                        'type'=>'GET', 
                        'url'=>CController::createUrl('admin/gettk'),
                        'update'=>'#t_qid',
                        'data'=>array('mid'=>"js:this.value")
                    )));
                    ?>
                </td>
            </tr>
            <tr style="line-height: 35px;">
                <td align="right" width="120px">题库：</td>
                <td align="left" >
                     <?php echo CHtml::dropDownList('t_qid','',array(),array('name'=>"t_qid","empty"=>"请选择题库", 'class'=>"wauto")); ?>
                </td>
            </tr>
           
            <tr style="line-height: 35px;">
                <td align="right" >题型：</td>
                <td align="left">
                   <?php 
                   echo CHtml::DropDownList('t_type','',Topic::$type, array(
                        "name"=>"t_type",
                        'class'=>"wauto",
                        'empty'=>'全部'));
                    ?>
                </td>
            </tr>
            <tr>
                <td align="right" >难度OR分数：</td>
                <td align="left">
                    <?php 
                        echo CHtml::DropDownList('t_level','',Topic::$level, array(
                            "name"=>"t_level",
                            'class'=>"wauto",
                            'empty'=>'全部'));
                    ?>
                </td>
            </tr>
            <? /*<tr>
                <td align="right" >分数：</td>
                <td align="left">
                   <input class="wauto" type="text" name='t_score' value="" />
                </td>
            </tr>*/?>
            <tr>
                <td align="right" >题目内容：</td>
                <td align="left">
                   <input class="wauto" type="text" name='t_con' value="" />
                </td>
            </tr>
            <tr>
                <td align="right" >知识点：</td>
                <td align="left">
                   <input class="wauto" type="text" name='t_know' value="" />
                </td>
            </tr>
            <tr><td align="right" >&nbsp;</td><td align = "left"><a class='btn btn-inverse' href='javascript:void()' onclick="outQuestions()"><span>题库导出</span></a></td></tr>
        </table>
    </form>
    </div>
</div>
</div>
<script type = "text/javascript">
function outQuestions(){
    $("#qform").submit();
}
</script>