<?php
$this->breadcrumbs=array(
	'修改密码',
);
?>
<style type="text/css">
    .red{color: red}
    .message{color: red;padding-left: 5px}
</style>

<?php if(Yii::app()->user->hasFlash('changepwd')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('changepwd'); ?>
    </div>
<?php endif; ?>

<div class="form">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'oprationconfig-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array("onSubmit"=>"return validateForm()")
    )); ?>
    
    <table width="100%">
        <tr>
            <td style="text-align: right;width: 15%"><font class="red">*</font>旧密码：</td>
            <td>
                <?=CHtml::passwordField("mag_oldpassword","",array('size'=>30,'maxlength'=>30,"onBlur"=>"checkPwd(this)"))?><span class="message"><?php echo $form->error($model,'mag_password'); ?></span>
            </td>
        </tr>
        <tr>
            <td style="text-align: right"><font class="red">*</font>新密码：</td>
            <td>
                <?=CHtml::passwordField("mag_password","",array('size'=>30,'maxlength'=>30,"onBlur"=>"checkPwd(this)"))?><span class="message"></span>
            </td>
        </tr>
        <tr>
            <td style="text-align: right"><font class="red">*</font>确认密码：</td>
            <td>
                <?=CHtml::passwordField("mag_password_two","",array('size'=>30,'maxlength'=>30,"onBlur"=>"comparePwd(this)"))?><span class="message"></span>
            </td>
        </tr>
    </table>
	<div class="row buttons">
		<?php echo CHtml::submitButton('修改'); ?>
	</div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    function validateForm(){
        if(!checkPwd("#mag_oldpassword")){
            return false;
        }
        if(!checkPwd("#mag_password")){
            return false;
        }
        if(!comparePwd("#mag_password_two")){
            return false;
        }
        return true;
    }
    
    function comparePwd(obj){
        var pwd = $("#mag_password").val();
        var pwd_com = $(obj).val();
        if(pwd!=pwd_com){
            $(obj).next().html("两次密码不一致！");
            return false;
        }
        $(obj).next().html("");
        return true;
    }
    function checkPwd(obj){
        var pwd = $(obj).val();
        if(!pwd){
            $(obj).next().html("密码不能为空！");
            return false;
        }
        if(pwd.length>20){
            $(obj).next().html("密码最多20位！");
            return false;
        }
        $(obj).next().html("");
        return true;
    }
</script>
