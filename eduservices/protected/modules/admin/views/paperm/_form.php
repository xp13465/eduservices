<?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jsdate/WdatePicker.js",CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'exampaper',
	"htmlOptions"=>array('class'=>'form-horizontal userform','onsubmit'=>'return checkform()',),
	'enableAjaxValidation'=>false,
    
    )); ?>  
    
    <?php echo $form->errorSummary($model); ?>
	<div class="tab-content" id="myTabContent">
		<!--基本信息 Begin-->
		<div id="home" class="tab-pane fade active in">
			<label>
				<span>试卷名称：</span>
                <?php echo $form->textField($model,'e_name',array('class'=>'span6','maxlength'=>100,'name'=>"e_name")); ?>                
			</label>            
			<label class="radio ">
				<input type="radio" name="e_cat" id="e_cat1" value="1"  checked <?=$model->e_cat=="1"?"checked":""?> />固定试卷 （所有的学员共用一套考题进行考试）
			</label>
			<div class="radio hide">
				<input style="margin-top: 12px;" type="radio" name="e_cat" id="e_cat2" value="2" <? $cat = explode(',',$model->e_cat); echo $cat[0]=="2"?"checked":""?>/>随机试卷&nbsp;&nbsp;<input class="span1" type="text" id = "hcat" name="hcat" value="<?=isset($cat[1])?$cat[1]:1; ?>">套（学员从多套题中随机取一套进行考试）
			</div>
            <div style = "margin:3px 0px">
				<span>适用层次</span>
                <?php echo $form->dropDownList($model,'e_cc',Lookup::model()->getClassInfo('professionallevel'),$htmlOptions=array ('name'=>"e_cc",'class'=>"span2","empty"=>"全部")); ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>适用科别</span>
                <?php echo $form->dropDownList($model,'e_ktype',Professional::$type,$htmlOptions=array ('name'=>"e_ktype",'class'=>"span2","empty"=>"全部")); ?>
			</div>
            
			<div style = "margin:3px 0px">
				<span>显示方式：</span>
                <?php echo $form->dropDownList($model,'e_display',Exampaper::$display,$htmlOptions=array ('name'=>"e_display",'class'=>"span2","empty"=>"请选择显示方式")); ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>最多考试次数：</span>
                <?php echo $form->textField($model,'e_maxenum',array('class'=>'span2','maxlength'=>100,'name'=>"e_maxenum")); ?>
			</div>
			<div class="show-grid">
				<div class="span4" style="border: 1px solid #ddd; height:150px;">
					<label><font color="#003399">时间参考：</font></label>
					<label style="padding-top:5px;">
						<span class="tjk-inline">有效开始时间：</span>
                        <?php echo $form->textField($model,'e_btime',array('class'=>'span5','maxlength'=>100,'name'=>"e_btime",'onclick'=>"WdatePicker()")); ?>
					</label>
					<label style="padding-top:5px;">
						<span class="tjk-inline">有效终止时间：</span>
                        <?php echo $form->textField($model,'e_etime',array('class'=>'span5','maxlength'=>100,'name'=>"e_etime",'onclick'=>"WdatePicker()")); ?>						
					</label>
				</div>
				<div class="span4" style="border: 1px solid #ddd; height:150px;">
					<label><font color="#003399">考试计时选项：</font></label>
					<label class="radio" style="margin-left:5px; padding-top:5px;">
						<input class="" type="radio" <?=$model->e_timecat?$model->e_timecat==1?"checked":"":'checked';?> value="1" name="e_timecat">&nbsp;考试不计时
					</label>
					<label class="radio" style="margin-left:5px;padding-top:5px;">
						<input class="" type="radio" <?=$model->e_timecat==2?"checked":"";?> value="2" name="e_timecat">&nbsp;统一交卷
					</label>
					<div class="radio" style="margin-left:5px;">
						<input style="margin-top:10px;" type="radio" <? $timecat = explode(',',$model->e_timecat);echo isset($timecat[0])&&$timecat[0]==3?"checked":"";?> value="3" name="e_timecat">&nbsp;答题时间<input class="span2" type="text" name="timecat" value="<?=isset($timecat[1])?$timecat[1]:60?>">分钟
					</div>
                    <? //echo $form->dropDownList($model, "e_display", array('1'=>'1','3'=>'1',4), array('name'=>'e_display'));?>
				</div>
			</div>
			<div class="clear" style="padding-top:5px;">
				<label><font color="#003399">防舞弊：</font></label>
				<div class="show-grid">
					<div class="span4">
                        <?php 
                            $e_trip = unserialize($model->e_treap);
                        ?>
						<label style="padding-top:5px;">
							<input type="checkbox" name="e_treap1" value="1" <?=$e_trip[0]==1?"checked":"";?> >&nbsp;&nbsp;考试分数保密
						</label>
						<label style="padding-top:5px;">
							<input type="checkbox" name="e_treap2" value="2" <?=$e_trip[1]==1?"checked":"";?> >&nbsp;&nbsp;选择题候选项随机
						</label>
					</div>
					<div class="span4">
						<label class="radio" style="margin-left:5px; padding-top:5px;">
							<input class="" type="radio"  value="1" name="e_treap3" <?=$e_trip[2]==1?"checked":"";?> checked >&nbsp;不限制移出WEB页
						</label>
						<div class="radio" style="margin-left:5px;">
                            <? $e_trip[3] = explode(',',$e_trip[3]);?>
							<input style="margin-top:10px;" type="radio" value="2" name="e_treap3" <?=isset($e_trip[3][0])&&$e_trip[3][0]==1?"checked":"";?> >&nbsp;移出考试页面达到<input class="span2" type="text" name="e_treap4" value="<?=isset($e_trip[3][1])?$e_trip[3][1]:5?>">次判为舞弊自动交卷
						</div>
					</div>
				</div>
			</div>
			<div class="clear" style="padding-top:5px;">
				<label><font color="#003399">考试安全：</font></label>
				<div class="show-grid">
					<div class="span4">
                        <?php 
                            $e_tsecurity = unserialize($model->e_tsecurity);
                        ?>
						<label style="padding-top:5px;">
							<input type="checkbox" name="e_tsecurity1" <?=$e_tsecurity[0]==1?"checked":"";?>  value="1">&nbsp;考试分数保密
						</label>
					</div>
					<div class="span4">
						<label style="padding-top:5px;">
							<input type="checkbox" name="e_tsecurity2" <?=$e_tsecurity[1]==1?"checked":"";?>  value="1">&nbsp;允许考生交卷后查看答卷和答案
						</label>
					</div>
				</div>
			</div>
			<div class="clear" style="padding-top:5px;">
				<label><font color="#003399">试卷安全：</font></label>
				<label class="radio " style="margin-left:5px;padding-top:5px;">
					<input type="radio" value="1" name="e_esecurity" <?=$model->e_esecurity?$model->e_esecurity==1?"checked":"":'checked';?> >&nbsp;不支持中途保存答卷，不支持恢复考试功能
				</label>
				<label class="radio hide" style="margin-left:5px;padding-top:5px;">
					<input type="radio" value="2" name="e_esecurity" <?=$model->e_esecurity==2?"checked":"";?> >&nbsp;手工保存答卷：考试过程中允许考生手工保存答卷，允许中途退出考试，适合布置不计时的作业
				</label>
				<div class="radio hide" style="margin-left:5px;padding-top:5px;">
					<input style="margin-top:12px;" type="radio" value="3" name="e_esecurity" <? $esecurity = explode(',',$model->e_esecurity);echo isset($esecurity[0])&&$esecurity[0]==3?"checked":"";?>>&nbsp;每隔<input class="span1" type="text" name="e_esecurity3" value="<?=isset($esecurity[1])?$esecurity[1]:60?>">分钟自动保存答卷（只能输入正整数）
				</div>
				<label class="radio hide" style="margin-left:5px;padding-top:5px;">
					<input type="radio" value="4" name="e_esecurity" <?=$model->e_esecurity==4?"checked":"";?> >&nbsp;启用本地缓存功能：在考试机器中即时保存答卷，出错后可以恢复答卷（推荐）
				</label>
			</div>
			<div>
                    试卷说明：
                    <?php echo $form->textField($model,'e_edescription',array('class'=>'span3','maxlength'=>100,'name'=>"e_edescription")); ?>
                    
				顺序号：
                <?php echo $form->textField($model,'e_snum',array('class'=>'span1','maxlength'=>100,'name'=>"e_snum")); ?>
                
			</div>
            <div style="padding-top:5px;">
                    注意事项：
                    <?php echo $form->textarea($model,'e_note',array('name'=>"e_note",'style'=>"width:600px;height:100px")); ?>
               
                
			</div>
            
            
			<div>
				<label><font color="#FF6600">友情提示</font></label>
				<hr style="border:1px dashed #A0A0A0;">
				<ul><li>
					<font color="#A0A0A0">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx。</font>
				</li></ul>
			</div>

		</div>
		<!--基本信息 End-->
		
		<!--高级设置 Begin-->
		<div id="profile" class="tab-pane fade">
			<div class="clear" style="margin-left:10px;">
				<label><font color="#003399">考生及评卷人</font></label>
				<label class="radio">
					<input type="radio" class="" name="e_scat" value="1" <?=$model->e_scat==1?"checked":""?> >&nbsp;允许所有账户参加考试
				</label>
				<label class="radio">
					<input type="radio" class="" name="e_scat" value="2" <?=$model->e_scat==2?"checked":""?> >&nbsp;在考试控制台中安排学生考试
				</label>
				<label>
					<span>阅卷人员：</span>
					<div class="input-append">
                        <?php //echo $form->textField($model,'e_rpeople',array('class'=>'span10','maxlength'=>100,'name'=>"e_rpeople")); ?>						
						
                        <?php
                            $this->widget('CAutoComplete',
                                    array(
                                    "id"=>"e_rpeople",
                                    'name'=>'e_rpeople',
                                    "value"=>$model->e_rpeople,
                                    'url'=>array('admin/ajaxautocomplete'),
                                    'max'=>8,//显示最大数
                                    'minChars'=>1,//最小输入多少开始匹配
                                    'delay'=>500, //两次按键间隔小于此值，则启动等待
                                    'scrollHeight'=>200,
                                    "extraParams"=>array("type"=>"1"),//表示是楼盘、商业广场还是小区
                                    'htmlOptions'=>array("class"=>"width1 input-large",'onblur'=>'selectCode(this)'),
                                    // 'resultsClass'=>"bh_results"
                            ));
                        ?>
                        <button type="button" class="btn">Search</button>
					</div>
				</label>
			</div>
			<div class="clear hide" style="margin-left:10px;padding-top:15px; ">
				<label><font color="#003399">题型与分数设置</font></label>
                <?php $e_scoreset = explode(',',$model->e_scoreset);?>
				<div class="radio">
					<input type="radio" style="margin-top:12px;" name="e_scoreset" value="1" <?=isset($e_scoreset[0])&&$e_scoreset[0]==1?"checked":""?> checked>&nbsp;使用题库中设置的分数 并将总分设算为<input type="text" class="span1" name="scoreset" value="<?=isset($e_scoreset[1])?$e_scoreset[1]:"100"?>">分
				</div>
				<label class="radio hide">
					<input type="radio" class="" name="e_scoreset" value="2">&nbsp;忽略试题原分数，按题型指定分数
				</label>
				<table class="table table-bordered userlist hide">
					<thead>
						<tr>
							<th width="5%"><input type="checkbox" value="" name=""></th>
							<th width="15%">题型标题</th>
							<th width="10%">分数</th>
							<th width="50%">说明</th>
							<th width="20%">顺序号</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox" value="" name=""></td>
							<td>单选题</td>
							<td>
								<input class="span5" type="text" name="" value="390">
							</td>
							<td>
								<textarea class="span">输入文本...</textarea>
							</td>
							<td>
								<input class="span5" type="text" name="" value="1">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox" value="" name=""></td>
							<td>多选题</td>
							<td>
								<input class="span5" type="text" name="" value="390">
							</td>
							<td>
								<textarea class="span">输入文本...</textarea>
							</td>
							<td>
								<input class="span5" type="text" name="" value="2">
							</td>
						</tr>
						<tr>
							<td><input type="checkbox" value="" name=""></td>
							<td>判断题</td>
							<td>
								<input class="span5" type="text" name="" value="390">
							</td>
							<td>
								<textarea class="span">输入文本...</textarea>
							</td>
							<td>
								<input class="span5" type="text" name="" value="3">
							</td>
						</tr>
					</tbody>
				</table>
				<div>
					<label><font color="#FF6600">友情提示</font></label>
					<hr style="border:1px dashed #A0A0A0;">
					<ul><li><font color="#A0A0A0">选择“在考试控制台中安排考生考试”的试卷，需要在“考试管理”中指定参加考试的学员。 </font></li></ul>
				</div>
				
				
			</div>
		</div>
		<!--高级设置 End-->
		
		<!--试卷策略 Begin-->
		<div id="dropdown" class="tab-pane fade">
			<div class="clear" style="margin-left:10px;">
                    <p>   
                    <span>题集库：</span>
					<?php   
                    echo CHtml::dropDownList('t_questionsid','', Questions::model()->getAllTK(0),
                        array(
                            'empty'=>'请选择题库集',
                            'class'=>"span3",
                            'ajax' => array(
                            'type'=>'GET', 
                            'url'=>CController::createUrl('admin/gettk'),
                            'update'=>'#t_qid',
                            'data'=>array('mid'=>"js:this.value")
                            )
                        )
                    );      ?>
					<span>题库：</span>
					<?php   
                    echo CHtml::dropDownList('t_qid','',array(),
                        array(
                            'empty'=>'请选择题库集',
                            'class'=>"span3",
                            'ajax' => array(
                            'type'=>'GET', 
                            'url'=>CController::createUrl('admin/getzs'),
                            'update'=>'#t_know',
                            'data'=>array('mid'=>"js:this.value")
                            )
                        )
                    );  ?>
                    </p>
                    <p>
					<span>知识点：</span>
					<?php   
                            echo CHtml::dropDownList('t_know','', array(),
                                array(
                                    'empty'=>'所有',
                                    'class'=>"span3"
                                )
                            );      
                        ?>
					<span>难度:</span>
					<?php   
                            echo CHtml::dropDownList('t_level','2', Topic::$level,
                                array(
                                    // 'empty'=>'所有',
                                    'class'=>"span3"
                                )
                            );      
                        ?>
					<a href="#" onclick='addCL()' class="btn btn-success "><i class="icon-plus icon-white"></i>增加策略</a>
                    </p>
			</div>
			<div class="clear" style="margin-left:10px;">
				<label>试题策略</label>
				<table class="table table-bordered userlist">
					<thead>
						<tr>
							<th width="25%">题库集</th>
							<th width="15%">题库</th>
							<th width="10%">知识点</th>
							<th width="10%">难度</th>
							<th width="20%">题目</th>
							<th width="20%">操作</th>
						</tr>
					</thead>
					<tbody id='cltbody'>
						<?php 
                            $Array=$model->e_pstrategy?unserialize($model->e_pstrategy):array();
                            foreach($Array as $key=>$val){  
                            $criteria=new CDbCriteria;
                            $criteria->addCondition("t_qid ='{$val['tkcltk']}'");
                            $criteria->addCondition("t_level ='{$val['tkcllevel']}'");
                            if($val['tkclknowName']!=='所有')$criteria->addCondition("t_know ='{$val['tkclknowName']}'");
                            $count=Topic::model()->count($criteria);
                            ?>
                            <tr>
                                <td><?=Questions::model()->getNameById($val['tkcltkj'])?></td>
                                <td><?=Questions::model()->getNameById($val['tkcltk'])?></td>
                                <td><?=$val['tkclknowName']?></td>
                                <td><?=$val['tkcllevel']?></td>
                                <td>
                                    
                                    <input class='span2' type='hidden' name='tkcltkj[]' value='<?=$val['tkcltkj']?>'>
                                    <input class='span2' type='hidden' name='tkcltk[]' value='<?=$val['tkcltk']?>'>
                                    <input class='span2' type='hidden' name='tkcllevel[]' value='<?=$val['tkcllevel']?>'>
                                    <input class='span2' type='hidden' name='tkclknowName[]' value='<?=$val['tkclknowName']?>'>
                                    <input class='span2' type='text' onchange='checktmnum(this)' name='tkclvalue[]' value='<?=$val['tkclvalue']?>'>
                                    <span>&nbsp;/&nbsp;</span>
                                    <font><?=$count?></font>
                                </td>
                                <td>
                                    <a href="">查看</a> / <a href="#">编辑</a> / <a href="">删除</a>
                                </td>
                            </tr>
                            
                         <?php    }
                        
                        ?>
					</tbody>
				</table>
			</div>
			<div class="clear" style="margin-left:10px;">
				总分：
                <?php echo $form->textField($model,'e_totals',array('class'=>'span2','maxlength'=>100,'name'=>"e_totals",'readonly'=>"readonly")); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
				及格分：
                <?php echo $form->textField($model,'e_passs',array('class'=>'span2','maxlength'=>100,'name'=>"e_passs")); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<div>
				<label><font color="#FF6600">友情提示</font></label>
				<hr style="border:1px dashed #A0A0A0;">
				<ul>
					<li><font color="#A0A0A0">试卷所需的试题需要先在题库管理中建立。允许从不同题库中抽取试题。</font></li>
					<li><font color="#A0A0A0">题库集、题库、知识点、难度限制的越细，抽取的试题越准确。</font></li>
				</ul>
			</div>
		</div>
		<!--试卷策略 End-->
	</div>
    <input type="submit" value="提交" class='btn '>
    <?php $this->endWidget(); ?>
<script type="text/javascript">
function checkform(){
    clobj=$('input[name="tkclvalue[]"]');
    // alert(clobj.length)
    if(clobj.length<1){
        alert('请添加试卷策略')
        return false;
    }
}
function checktmnum(obj){
    if(obj.value>$(obj).parent('td').find('font').html()){
        alert('选题数请别大于题目数！')
        $(obj).val(0).focus()
    }
    checkfsnum();
   
    
}
function checkfsnum(){
    fsnum=0;
    clobj=$('input[name="tkclvalue[]"]');
    for(var i=0;i<clobj.length;i++){
        fsnum+=clobj.eq(i).val()*clobj.eq(i).parent('td').find('input[name="tkcllevel[]"]').val()
        // alert(clobj.eq(i).val())
        // alert(clobj.eq(i).parent('td').find('input[name="tkcllevel[]"]').val())
    }
    $('#e_totals').val(fsnum)
}
function addCL(){
	var tkj=$("#t_questionsid").val();
    var tk=$("#t_qid").val();
    var know=$("#t_know").val();
    var level=$("#t_level").val();
    if(!tkj){
        alert("请选择题库集");
        $("#t_questionsid").focus();
        return false;
    }
    if(!tk){
        alert("请选择题库");
        $("#t_qid").focus();
        return false;
    }
    if(!level){
        alert("请选择难度");
        $("#t_level").focus();
        return false;
    }
    $.ajax({
			type: "GET",
			url: '/admin/admin/getstcl',
			data: {'tkj':tkj,'tk':tk,'know':know,'level':level},
			async:true,
			success: function(msg){
				// alert(msg)
                $(msg).appendTo($("#cltbody"));
			}
		});
    
}
function delcl(obj){
    var ok=confirm("确认删除此策略?")
    if(ok){
        $(obj).parent("td").parent("tr").remove()
        checkfsnum();
    }
    
}
</script>