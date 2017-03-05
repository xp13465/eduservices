<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jsdate/WdatePicker.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/kindeditor-4.1.2/kindeditor.js",CClientScript::POS_END ); 
// echo "<pre>";
// print_r($model->attributes);
?>
<script type="text/javascript">
$(document).ready(function(){
	KindEditor.ready(function(K) {
				var editor = K.create('textarea[id="i_con"]', {
						allowFileManager : false,
						afterBlur: function(){this.sync();}
					});

	});
	})
</script>
<div>
    <div class="form-horizontal userform">
    <?php 
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'information-form',
            'enableAjaxValidation'=>false,
            "htmlOptions"=>array("enctype"=>"multipart/form-data"),
        ));
        // ,"readonly"=>"readonly"
    ?>
    <?php echo $form->errorSummary($model); ?>
        <fieldset>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>
                            <?/*<div class="control-group">
                                <label class="control-label" for="i_class">新闻类型</label>
                                <div class="controls">
                                    <p class="text"><?=Information::$class[$model->i_class]?></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="i_label">标签</label>
                                <div class="controls">
                                    <?php
                                        echo $form->textField($model,'i_label',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>'i_label'));
                                    ?>
                                </div>
                            </div>
                            */?>
                            <div class="control-group">
                                <label class="control-label" for="i_title">标题 <span class="rcolor">*</span></label>
                                <div class="controls">
                                    <?php
                                        echo $form->textField($model,'i_title',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>'i_title'));
                                    ?>
                                    <p class="error  pull-left pl8">不能为空！</p>
                                    <p for="i_title" class="error" style=""><?=isset($model->errors['i_title'])?join('',$model->errors['i_title']):""?></p>
                                </div>
                            </div>
                            
                            <?/*
                            <div class="control-group ">
                                <label class="control-label" for="i_pic">标题图 </label>
                                <div class="controls">
                                    <?php 
                                        if($model->isNewRecord){
                                            echo $form->fileField($model,'i_pic',array('class'=>'input-large pull-left')); 
                                        }
                                        echo !$model->isNewRecord?empty($model->i_pic)?"<span class='pull-left' style='padding-top:4px; color:red;'>无图片</span>":"<a href='".$model->i_pic."' class='pull-left'>下载</a>":"";
                                    ?>
                                </div>
                            </div>
                            */?>
                            <div class="control-group "><?//=$model->i_pic?>
                                <label class="control-label" for="i_pic">标题图</label>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model,'i_pic',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"i_pic")); ?>
                                    <div class="pull-left">
                                        <a class="btn btn-mini btn-danger 	"  onclick="openUploadZJ('i_pic','picimg','picimgbtn')">标题图<?=!$model->i_pic?"上传":"修改"?></a>&nbsp;
                                        <a class="btn btn-mini btn-success" style='<?=$model->i_pic?"":"display:none"?>'id="picimgbtn">标题图预览</a>
                                        <img src='<?=$model->i_pic?>' class='hide showimg' style='width:500px;' id="picimg">
                                    </div>
                                     <p for="i_pic" class="error" style=""><?=isset($model->errors['i_pic'])?join('',$model->errors['i_pic']):""?></p>
                                    <p class="error  pull-left pl8" style='<?=isset($model->errors['i_pic'])?"display:none":""?>'>标题图250K以下!</p>
                                </div>
                            </div>
                            <?/*
                            <div class="control-group ">
                            <label class="control-label" for="s_oldimg">毕业证书扫描件 <span class="rcolor">*</span></label>
                            <div class="controls">
                            <?php echo $form->hiddenField($model,'s_oldimg',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>"s_oldimg")); ?>
                            <div class="pull-left">
                            <a class="btn btn-mini btn-danger 	"  onclick="openUploadZJ('s_oldimg','oldimg','oldimgbtn')">毕业证书扫描件<?=!$model->s_oldimg?"上传":"修改"?></a>&nbsp;
                            <a class="btn btn-mini btn-success" style='<?=$model->s_oldimg?"":"display:none"?>'id="oldimgbtn">毕业证书扫描件预览</a>
                            <img src='<?=$model->s_oldimg?>' class='hide showimg' style='width:500px;' id="oldimg">

                            </div>
                             <p for="s_oldimg" class="error" style=""><?=isset($model->errors['s_oldimg'])?join('',$model->errors['s_oldimg']):""?></p>
                            <p class="error  pull-left pl8" style='<?=isset($model->errors['s_zsbzm'])?"display:none":""?>'>毕业证书扫描件250K以下!</p>
                            </div>
                            </div>*/?>
                            
                            
                            <div class="control-group ">
                                <label class="control-label" for="i_con">详情 <span class="rcolor">*</span></label>
                                <div class="controls">
                                    <?php 
                                        echo $form->textArea($model,'i_con',array('name'=>'i_con','style'=>"width:700px;height:700px;"));
                                    ?>
                                    <p for="i_con" class="error" style=""><?=isset($model->errors['i_con'])?join('',$model->errors['i_con']):""?></p>
                                </div>
                            </div>
                            <?/*
                            <div class="control-group">
                                <label class="control-label" for="i_click">点击量</label>
                                <div class="controls">
                                    <?php
                                        echo $form->textField($model,'i_click',array('class'=>'input-large pull-left','name'=>'i_click'));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="i_bool">是否推荐</label>
                                <div class="controls">
                                    <div class="pull-left">
                                        <?php
                                            echo CHtml::activeDropDownList($model,'i_bool',Information::$isbool,array(
                                                "name"=>"i_bool",
                                                "class"=>"pull-left",
                                            ));
                                        ?>
                                    </div>
                                    
                                    <p for="i_bool" class="error" style=""><?=isset($model->errors['i_bool'])?join('',$model->errors['i_bool']):""?></p>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="i_form">来源</label>
                                <div class="controls">
                                    <?php
                                        echo $form->textField($model,'i_form',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>'i_form'));
                                    ?>
                                </div>
                            </div>
                            */?>
                            <div class="control-group">
                                <label class="control-label" for="i_author">署名</label>
                                <div class="controls">
                                    <?php
                                        echo $form->textField($model,'i_author',array('class'=>'input-large pull-left','maxlength'=>100,'name'=>'i_author'));
                                    ?>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" name="addsubmit" value="add" onclick='unbindunbeforunload()' ><?=!$model->isNewRecord?"修改":"添加"?></button> &nbsp;
                                <?php
                                    if(isset($_GET['return'])&&$_GET['return']=='view'){
                                        $url = Yii::app()->createUrl("admin/information/view",array("id"=>$model->i_id));
                                    }else{
                                        $url = isset($_COOKIE['ggnewslistreturnurl'])?$_COOKIE['ggnewslistreturnurl']:Yii::app()->createUrl("admin/information/index");
                                    }
                                ?>
                                <a href="<?=$url?>" class="btn btn-primary">返回</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("#information-form").validate(
            autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
                i_title: {
                    required: true,
                    maxlength:200
                },
                // i_con: {
                    // required: true,
                    
                // } 
                
            },
            
            messages: {
                i_title:{
                    required: '请输入标题内容',
                    maxlength:'不得超过200字'
                },
                // i_con:{
                    // required: "请输入公告内容"
                // }
            }
        );
    })
</script> 

