<?php
Yii::app()->clientScript->registerMetaTag(Yii::app()->params->keywords,'keywords');
Yii::app()->clientScript->registerMetaTag(Yii::app()->params->description,'description');
?>

<div class="log_logo"></div>
<div class="login_m">
    
    <div class="login">
        <h2></h2>
        <div class="log_cont">
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'memberRegister-form',
                    'enableAjaxValidation'=>false,
            )); ?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="log_tab">
                <tr>
                    <td width="17%" align="center">EMAIL：</td>
                    <td colspan="2" width="83%">
                        <?php echo $form->textField($model,'username',array('style'=>"color:#808080","class"=>"txt_07",'value'=>$model->username?$model->username:"user@jialixiuxiu.com","onblur"=>"if(this.value==''){this.value='user@jialixiuxiu.com';this.style.color='#808080'}","onfocus"=>"if(this.value=='user@jialixiuxiu.com'){this.value='';this.style.color='black'}")); ?>
                    </td>
                </tr>
                <tr>
                    <td width="17%" align="center">密 码：</td>
                    <td colspan="2" width="83%">
                        <?php echo $form->passwordField($model,'password',array('style'=>"color:#808080","class"=>"txt_07","autoComplete"=>"off",'value'=>$model->password?$model->password:"******","onblur"=>"if(this.value==''){this.value='******';this.style.color='#808080'}","onfocus"=>"if(this.value=='******'){this.value='';this.style.color='black'}")); ?>
                    </td>
                </tr>
                <tr>
                    <td width="17%">&nbsp;</td>
                    <td width="40%" class="psw">
                        <?php echo $form->checkBox($model,'rememberMe',array("id"=>"rememberMe")); ?>
                        <label for="rememberMe">一周内自动登录</label>
                    </td>
                    <td width="43%" class="psw"><a href="<?=Yii::app()->createUrl("/passwordfind/index");?>">忘记密码？</a></td>
                </tr>
                <tr>
                    <td width="17%">&nbsp;</td>
                    <td colspan="2" width="83%" class="msg" id="showloginerrormsg">
                        <?php
                        if($model->errors&&isset($model->errors['password'])) {
                            if($model->errors['password'][0]=="邮箱还未认证") {
                                // echo "账号未审核，请等待审核！";
                                // echo "<br />若比较急，请联系QQ：86265089！";
                            }else {
                                echo $form->error($model,'password');
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><input type="submit" class="btn_12" value="登录"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><input type="button" class="btn_13" value="注册" onclick="window.location.href='/user/register'" /></td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div>
    </div>
	<?php if($this->beginCache('siteindex', array('duration'=>600))) { ?>
    <?php // $this->renderPartial("_memberpic")?>
	<?php $this->endCache(); } ?>
</div>
<div class="adlogin">
    <div class="adl_lf">在这里可以浏览真实的佳丽展示，可以点评，可以看到大家对她的喜爱程度，还可以约会哦！</div>
    <div class="adl_rt">
        <div id="allMemberNum" class="mp_cnt mp_t">
            <div class="mp_cnt_num">
            </div>位佳丽静候您的加入！<a href="<?=Yii::app()->createUrl("/site/home");?>">随便看看</a>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        showAllMember();
    });
    function showAllMember(){
        var num = "00000000<?=User::model()->count();?>";
        num = num.replace(/^(\d+)(\d{8})$/,"$2");
        num=num.replace(/^(\d*)$/,"$1,");
        var re=/(\d)(\d{3},)/;
        while(re.test(num)){
            num=num.replace(re,"$1,$2");
        }
        num=num.replace(/^([0-9,]*),$/,"$1");
        var i=0;
        var ch;
        while(i<num.length){
            ch = num.charAt(i);
            if(ch==","){
                $("#allMemberNum .mp_cnt_num").append('<span class="mp_cnt_d mp_cnt_space"></span>');
            }else{
                $("#allMemberNum .mp_cnt_num").append('<span class="mp_cnt_d mp_cnt_d_'+ch+'"></span>');
            }
            i++;
        }
    }
    function reSendCheckMail(){
        var email = $.trim($("#LoginForm_username").val());
        if(email==""){
            $("#showloginerrormsg").html("请填写邮箱");
            return false;
        }
        var preg = /^.*@.*\..*$/;
        if(preg.test(email)){
            $.post("/user/reSendCheckMail", {"email":email}, function(msg){
                if(msg=="success"){
                    jw.pop.alert("重发邮件成功！请登录邮箱进行认证！",{icon:1,autoClose:1500});
                }else{
                    jw.pop.alert(msg,{icon:2,autoClose:1000});
                }
            }, "text")
        }else{
            $("#showloginerrormsg").html("邮件格式不对");
        }
    }
</script>