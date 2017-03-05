<?php
/* @var $this ExamarrangementController */
/* @var $model Examarrangement */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jsdate/WdatePicker.js",CClientScript::POS_END);
?>


<div class="modal-header">
    <h3>排考管理-编辑</h3>
</div>
<div class="modal-body" style="max-height:600px;">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'examarrangement-form',
	'enableAjaxValidation'=>false,
    )); ?>
    <div>
        <div class="control-group">
            <label class="control-label" for=""><b>入学考试批次</b></label>
            <div class="controls">
                <div class="input-append">
                    <?php   echo CHtml::activeDropDownList($model, 'ea_pkid',Pici::model()->getAllPC(true,false), array(
					'empty'=>'请选择入学考批次',
					"name"=>"ea_pkid",
					'class'=>"pull-left"
                    )); ?>
                </div>
                <span for="ea_pkid" class="error" style=""><?=isset($model->errors['ea_pkid'])?join('',$model->errors['ea_pkid']):""?></span>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for=""><b>入学考试试卷</b></label>
            <div class="controls">
                <div class="input-append">
                    <?php   echo CHtml::activeDropDownList($model, 'ea_examid',Exampaper::model()->getAllExam(), array(
					'empty'=>'系统判断层次专业出卷',
					"name"=>"ea_examid",
					'class'=>"pull-left"
                    )); ?>
                </div>
                <span for="ea_examid" class="error" style=""><?=isset($model->errors['ea_examid'])?join('',$model->errors['ea_examid']):""?></span>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for=""><b>入学考试时间安排</b></label>
            <div class="controls">
                <div class="">
                <?php 
                $hour=$mintue=array();
                for($i=0;$i<=60;$i++){
                    if($i<24){
                        $hour[str_pad($i,2,0,STR_PAD_LEFT)]=str_pad($i,2,0,STR_PAD_LEFT);
                    }
                    $mintue[str_pad($i,2,0,STR_PAD_LEFT)]=str_pad($i,2,0,STR_PAD_LEFT);
                }
                $shour=$model->ea_stime?date("H",$model->ea_stime):00;
                $smintue=$model->ea_stime?date("i",$model->ea_stime):23;
                $ehour=$model->ea_etime?date("H",$model->ea_etime):00;
                $emintue=$model->ea_etime?date("i",$model->ea_etime):00;
                
                $model->ea_stime=$model->ea_stime?date("Ymd",$model->ea_stime):$model->ea_stime;
                
                echo $form->textField($model,'ea_stime',array('class'=>'span2','maxlength'=>100,'name'=>"ea_stime",'onclick'=>"WdatePicker()")); 
                   ?>
                   <br/>从
                    <?php echo CHtml::DropDownList('shour',$shour, $hour, array(
                    "name"=>"shour",
                    'class'=>"wauto")); ?>时
                    <?php echo CHtml::DropDownList('smintue',$smintue, $mintue, array(
                    "name"=>"smintue",
                    'class'=>"wauto")); ?>分
                    
                    
                    
                    <br/>到
                    <?php echo CHtml::DropDownList('ehour',$ehour, $hour, array(
                    "name"=>"ehour",
                    'class'=>"wauto")); ?>时
                    <?php echo CHtml::DropDownList('emintue',$emintue, $mintue, array(
                    "name"=>"emintue",
                    'class'=>"wauto")); ?>分
                    <span for="o_pid" class="error" style=""><?=isset($newmodel->errors['o_pid'])?join('',$newmodel->errors['o_pid']):""?></span>
                    <span class="help-inline rcolor"></span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for=""><b>入学考试试卷</b></label>
            <div class="controls">
                <div class="input-append">
                    <?php   echo CHtml::activeDropDownList($model, 'ea_type',Examarrangement::$type, array(
                        "name"=>"ea_type",
                        'class'=>"pull-left"
                    )); ?>
                </div>
                <span for="ea_type" class="error" style=""><?=isset($model->errors['ea_type'])?join('',$model->errors['ea_type']):""?></span>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary"  name="addsubmit" value="add">确认修改</button>&nbsp;
        <a href="<?=isset($_COOKIE['examarrangementreturnurl'])?$_COOKIE['examarrangementreturnurl']:""?>" class="btn" closeTime">返回</a>
	</div>
    <?php $this->endWidget(); ?>
</div>
<script>
$(function(){
			$("#examarrangement-form").validate({
				// debug: true,
				autoCreateRanges:true	,
				errorClass: "error",
				errorElement: "span",
				rules: {
					// ea_examid: 'required',
                    ea_pkid: 'required'
				},
				messages: {
					// ea_examid: '考试试卷为必填',
                    ea_pkid: '批次为必填项'
				}
			});
		
		})
</script>
<?/*<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'examarrangement-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ea_pkid'); ?>
		<?php echo $form->textField($model,'ea_pkid'); ?>
		<?php echo $form->error($model,'ea_pkid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ea_examid'); ?>
		<?php echo $form->textField($model,'ea_examid'); ?>
		<?php echo $form->error($model,'ea_examid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ea_stime'); ?>
		<?php echo $form->textField($model,'ea_stime'); ?>
		<?php echo $form->error($model,'ea_stime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ea_etime'); ?>
		<?php echo $form->textField($model,'ea_etime'); ?>
		<?php echo $form->error($model,'ea_etime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ea_status'); ?>
		<?php echo $form->textField($model,'ea_status'); ?>
		<?php echo $form->error($model,'ea_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>*/?>
<!-- form -->