<div class="bs-docs-example">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#home">试题属性</a></li>
	</ul>
   <script type="text/javascript" src="http://latex.codecogs.com/editor3.js"></script>
   <link href="/css/student/exam-public.css" rel="stylesheet" type="text/css" />
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-form',
	"htmlOptions"=>array('class'=>'',"onsubmit"=>"return checkform()"),
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>
	<div class="tab-content" id="myTabContent">
		<div id="home" class="tab-pane fade active in">
            <div class='pull-left ' style='width:500px;height:200px;margin-right:30px;'>
                <p>
                <a href="javascript:OpenLatexEditor('editbox','html','')"> 数学公式代码编辑 </a>
                </p>
                <textarea id="editbox" style='width:490px;height:150px;' ></textarea>
                
            </div>
             <div class='pull-left' style='width:500px;height:200px;'>
                <p>
                 <a href="javascript:void()" onclick='showview("editbox",2)'> 预览 </a>
                </p>
                <div id='showbox' style='border:1px solid #ccc;width:500px;height:160px;' ></div>
             </div>
            <div class='clear'></div>
            
			<div class="controls">
				<label><font color="#003399">基本信息</font></label>
                
                        <span class="tjk-inline">题&nbsp;集&nbsp;库：</span>
             
			 <?php 
                    
                    if($model->questionsid){
                        $data= Questions::model()->getAllTK($model->questionsid);
                    }else if($model->t_qid){
                        $pmodel=Questions::model()->findByPk($model->t_qid);
                        $model->questionsid=$pmodel->q_pid;
                        $data=Questions::model()->getAllTK($pmodel->q_pid);
                    }else{
                        $data=array();
                    }
                    echo CHtml::dropDownList('questionsid',$model->questionsid, Questions::model()->getAllTK(0),
                    array(
                        'empty'=>'请选择题库集',
                        'class'=>"span3",
                        'ajax' => array(
                        'type'=>'GET', 
                        'url'=>CController::createUrl('admin/gettk'),
                        'update'=>'#t_qid',
                        'data'=>array('mid'=>"js:this.value")
                    )));
                                                    
                                                    
                                                 			
                ?>
                <span class="tjk-inline">&nbsp;题　库：</span>
                
                <?php echo $form->dropDownList($model,'t_qid',$data,$htmlOptions=array ('name'=>"t_qid","empty"=>$model->questionsid?"请选择题库":"选择题库集加载题库", 'class'=>"span3")); ?>
                
                
                <?//=isset($model->errors['t_qid'])?join('',$model->errors['t_qid']):""?>
                
			</div>          
            
            
			<div class="controls">
				<span class="tjk-inline">知 识 点：</span>
				<?php echo $form->textField($model,'t_know',array('class'=>'span3','maxlength'=>100,'name'=>"t_know")); ?>
                <?//=isset($model->errors['t_know'])?join('',$model->errors['t_know']):""?>
                
				<span class="tjk-inline">难　度：</span>
                 <?php echo $form->dropDownList($model,'t_level',Topic::$level,$htmlOptions=array ('name'=>"t_level", 'class'=>"span1")); ?>
                <?//=isset($model->errors['t_level'])?join('',$model->errors['t_level']):""?>                
				
				<?php  /*<span class="tjk-inline">默认分数：</span>*/?>
				
                <?php //echo $form->textField($model,'t_score',array('class'=>'span5','maxlength'=>100,'name'=>"t_score")); ?>
                <?//=isset($model->errors['t_score'])?join('',$model->errors['t_score']):""?>
			</div>           
            
			<div class="controls">
				<span class="tjk-inline"> 题目类型：</span>
                <?php echo $form->dropDownList($model,'t_type',Topic::$type,$htmlOptions=array ('name'=>"t_type", 'class'=>"span3",'onchange'=>"changeSelect(this)")); ?>
                <?//=isset($model->errors['t_type'])?join('',$model->errors['t_type']):""?>
                
				<span class="tjk-inline">有 效 期：&nbsp;</span>
                <?php echo $form->textField($model,'t_validity',array('class'=>'span2','maxlength'=>100,'name'=>"t_validity")); ?>
                <?//=isset($model->errors['t_validity'])?join('',$model->errors['t_validity']):""?><span><font>格式:1980-01-02</font></span>
               <span for="t_validity" class="error"></span>
			</div>
			<div class="controls">
				<label>
					<font color="#003399">题目内容</font> <a href="javascript:void()" onclick='showview("t_con",2)'> 预览 </a>
					<span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font>填空题需要添加答案的地方用三个英文下滑线“___”来表示</span>
				</label>
                <?php echo $form->textarea($model,'t_con',array('class'=>'span9','maxlength'=>5000,'name'=>"t_con")); ?>
                <?//=isset($model->errors['t_con'])?join('',$model->errors['t_con']):""?>
                
			</div>
            <div class="controls">
				<label>
					<font color="#003399">参考文章</font> <a href="javascript:void()" onclick="showview('t_article',2)"> 预览 </a>
					<span><font color="#CC3300"></font>需要的参考文宪</span>
				</label>
                <?php echo $form->textarea($model,'t_article',array('class'=>'span9','maxlength'=>5000,'name'=>"t_article")); ?>
                <?//=isset($model->errors['t_con'])?join('',$model->errors['t_con']):""?>
			</div>
			<div class="controls" >
				<span>
					<font color="#003399">候选项 项数</font>
                     <?php 
                     echo $form->dropDownList($model,'zhselect',Topic::$hselect,$htmlOptions=array ('name'=>"zhselect", 'class'=>"span1",'onchange'=>'changess(this)')); ?>					
                    <span   id='optionsRadioserror' class="rcolor" style=""> <?=isset($model->errors['zhselect'])?join('',$model->errors['zhselect']):""?></span>
                </span>
                <div  id='selectOptions'>
                    <?php if($model->t_daxx){
                            $Arr=unserialize($model->t_daxx);
                            $checkArr=explode(",",$model->t_answer);
                            foreach($Arr as $key=>$val){
                            $inputtype=$model->t_type=="2"?"checkbox":"radio";
                            ?>
                            <div class="radio">
                                <input type="<?=$inputtype?>" <?=in_array($key,$checkArr)?"checked":""?> name="optionsRadios<?=$model->t_type=="2"?"[{$key}]":""?>" class="checkradio" class="cccc" value="<?=$key?>"  style="margin-top:10px;">
                                <input type="text" name='optionsValue[<?=$key?>]'  class="span9" value="<?=htmlspecialchars($val)?>"><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span>
                            </div>
                    <?php   }
                        }else{?>
                    <div class="radio">
                        <input type="radio" name="optionsRadios" class="checkradio" class="cccc" value="1"  style="margin-top:10px;">
                        <input type="text" name='optionsValue[1]'  class="span9" value=""><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span>
                    </div>
                    <div class="radio">
                        <input type="radio" name="optionsRadios" class="checkradio" class="cccc"  value="2"   style="margin-top:10px;">
                        <input type="text" name='optionsValue[2]'  class="span9" value=""><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span>
                    </div>
                    <div class="radio">
                        <input type="radio" name="optionsRadios" class="checkradio" class="cccc"  value="3"  style="margin-top:10px;">
                        <input type="text" name='optionsValue[3]'  class="span9" value=""><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span>
                    </div>
                    <div class="radio">
                        <input type="radio" name="optionsRadios" class="checkradio" class="cccc" value="4"  style="margin-top:10px;">
                        <input type="text" name='optionsValue[4]' class="span9" value=""><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span>
                    </div>
                    <?php }?>
                </div>
			</div>
			<div class="controls">
				<label><font color="#003399">答题要点</font></label>
                <?php echo $form->textarea($model,'t_leaflet',array('class'=>'span11','maxlength'=>1000,'name'=>"t_leaflet")); ?>
                <?=isset($model->errors['t_leaflet'])?join('',$model->errors['t_leaflet']):""?>
			</div>
			<div class="clear">
                <button type="submit" class="btn btn-primary"  name="addsubmit" value="add" onclick='unbindunbeforunload()' ><?=!$model->isNewRecord?"修改":"添加"?>数据</button>&nbsp;
			</div>
            <?php $this->endWidget(); ?>
		</div>
	</div>
</div>
<script>
function showview(idname,type){
        var html='';
        if(type&&type==1){
            html=$(idname).prev('input').val()
        }else{
            html = $("#"+idname).val()
        }
        $("#showbox").html(html)
    }
    
function changeSelect(obj){
    var num=4;
    var typeStr='radio';
   // var opname='';
    if($(obj).val()=='2'){
        var num=5;
        typeStr='checkbox';
    }else if($(obj).val()=='3'){
        num=2;
    }
     $("select[name='zhselect'] option").each(function(){
        if($(this).val() == num){
        $(this).attr("selected" , "selected");   

           }
     });
    var html='';
   for (var i=1; i<=num; i++){
        if(typeStr=='radio'){
            html+='<div class="radio"><input type="'+typeStr+'" class="checkradio" name="optionsRadios" value="'+i+'"  style="margin-top:10px;"><input type="text"  name="optionsValue['+i+']" class="span9" value=""><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span></div>';
       }       
        if(typeStr=='checkbox'){
           html+='<div class="radio"><input type="'+typeStr+'" class="checkradio" name="optionsRadios['+i+']"  value="" style="margin-top:10px;"><input type="text"  name="optionsValue['+i+']" class="span9" value=""><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span></div>';  
         }
       
   }
     $("#selectOptions").html(html)

}
function  changess(obj){
    var num=$(obj).val();
    var radio=$('#t_type').val();
    // alert(radio)
    var inputtype=radio==2?"checkbox":"radio";
    // alert(num)
    // alert(checkhtml);
    var html='';
        for (var i=1; i<=num; i++)
      {      
            if(inputtype=='radio'){
            var checkhtml='<div class="radio"><input type="'+inputtype+'" class="checkradio" name="optionsRadios" value="'+i+'" class="cccc"  style="margin-top:10px;"><input type="text" name="optionsValue['+i+']" class="span9" value=""><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span></div>';
            }
            if(inputtype=='checkbox'){
            var checkhtml='<div class="radio"><input type="'+inputtype+'" class="checkradio" name="optionsRadios['+i+']" class="cccc"  style="margin-top:10px;"><input type="text" name="optionsValue['+i+']" class="span9" value=""><a href="javascript:void()" onclick="showview(this,1)"> 预览 </a><span><font color="#CC3300"><带格式、公式的先编辑后拷贝黏贴></font></span></div>';
            }
            html+=checkhtml;
      }
         $("#selectOptions").html(html)
}
function checkform(){
   var rtun=false;
   checkObjs=$("input.checkradio");
   var aa= $("input.checkradio").length
   for(i=0;i<checkObjs.length;i++){
        if(checkObjs[i].checked){
            $("#optionsRadioserror").html('')
            rtun=true;
            break
        }
        // alert(checkObjs[i].checked)
   }
   if(!rtun){
        $("#optionsRadioserror").html('请选择一个正确选项')
   }
    return rtun;
}
$(document).ready(function(){
        jQuery.validator.addMethod("cndate", function(value, element) {   
        var ereg = /^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/;	var r = value.match(ereg);	if (r == null) {		return false;	}	var d = new Date(r[1], r[3] - 1, r[5]);	var result = (d.getFullYear() == r[1] && (d.getMonth() + 1) == r[3] && d.getDate() == r[5]);	return this.optional(element) || (result);
		 
		});
        $("#question-form").validate({
            // debug: true,
			autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "span",
            rules: {     
                questionsid:'required',   
                t_qid:'required',
                t_con:'required',
				t_validity: {
					required:true,
					cndate:true
				}
                // optionsRadios:'required'
                    
            },
            messages: {     
                questionsid:'请选择题库集',   
                t_qid:'请选择题库',   
                t_con:'请输入题目内容',   
				t_validity: {
					required:'请输入有效期',
					cndate:'格式错误 '
				}
                // optionsRadios:'请选择一个正确选项'
            }
        });
});

</script>
