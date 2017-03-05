
<div id="login">
		<h1 style='margin-bottom:15px;'><a  href="javascript:void(0)" title="学校公共服务体系系统登录">学校公共服务体系系统登录</a></h1>
		
			<?php
			// print_r($model->errors);
			if(isset($model->errors['password'])||isset($model->errors['verifyCode'])){
					echo '<p class="message">';
                        
                            if(isset($model->errors['verifyCode'])) {
                              echo $model->errors['verifyCode'][0];
                            }else {
                                echo $model->errors['password'][0];
                            }
                        
						echo '</p>';
					} 
			   ?>
				
		<?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'memberRegister-form',
                    'enableAjaxValidation'=>false,
            )); 
			$username=$model->username?$model->username:"";
			if(!$username){
				$username=isset($_COOKIE['logname'])?$_COOKIE['logname']:"";
			}
			
			?>
			
			<p>
				<label for="user_login">帐号<br>
					<?php echo $form->textField($model,'username',array('value'=>$username,"class"=>"input")); ?>
                    
				</label>
			</p>
			<p>
				<label for="user_pass">密码<br>
				<?php echo $form->passwordField($model,'password',array("class"=>"input","autoComplete"=>"off",)); ?>
				</label>
			</p>
			<p class="pcode">
				<label for="user_code">验证码<br>
				<?php echo $form->textField($model,'verifyCode',array("class"=>"input l_code","autoComplete"=>"off",)); ?>
				<?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer'))); ?>	
				</label>
			</p>
			
			
			
			<p class="forgetmenot">
				<label for="rememberme">
					<input id="rememberme" name="rememberme" value="forever" <?=isset($_POST['rememberme'])?'checked':isset($_COOKIE['logname'])?"checked ":"";?> tabindex="90" type="checkbox"> 记住我的帐号信息
				</label>
			</p>
			<p class="submit">
				<input class="button-primary" name="loginsubmit" type="submit" value="登录" tabindex="100">
			</p>
		<?php $this->endWidget(); ?>
		<!-- <p id="nav"><a href="javascript:viod(0);" title="找回密码">忘记密码？</a></p> -->
		<!-- <p id="backtoblog"><a href="index.php" title="不知道自己在哪？">← 回到 Acking’s Info</a></p> -->
	</div>
	<div class="clear"></div>
	<?php /*
 <div class="log_cont">
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'memberRegister-form',
                    'enableAjaxValidation'=>false,
            )); ?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="log_tab">
                <tr>
                    <td width="17%" align="center">帐号：</td>
                    <td colspan="2" width="83%">
                        <?php echo $form->textField($model,'username',array('style'=>"color:#808080","class"=>"txt_07",'value'=>$model->username?$model->username:"用户名","onblur"=>"if(this.value==''){this.value='用户名';this.style.color='#808080'}","onfocus"=>"if(this.value=='用户名'){this.value='';this.style.color='black'}")); ?>
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
                        <?php //echo $form->checkBox($model,'rememberMe',array("id"=>"rememberMe")); ?>
                    </td>
                    <td width="43%" class="psw"></td>
                </tr>
                <tr>
                    <td width="17%">&nbsp;</td>
                    <td colspan="2" width="83%" class="msg" id="showloginerrormsg">
                        <?php
                        if($model->errors&&isset($model->errors['password'])) {
                            if($model->errors['password'][0]=="邮箱还未认证") {
                                echo "账号未审核，请等待审核！";
                                echo "<br />若比较急，请联系QQ：86265089！";
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
            
        </div>*/?>