<script>
function refreshCode(){
 document.getElementById('captchacode').src='/admin/manageuser/captcha/v/51cbac3fe18ad.html';
}
</script>
<?php
	if(isset($model->errors['password'])||isset($model->errors['verifyCode'])){
			echo '<script>';
                
                    if(isset($model->errors['verifyCode'])) {
                        echo "alert('{$model->errors['verifyCode'][0]}')";
                    }else {
                        echo "alert('{$model->errors['password'][0]}')";
                    }
                
				echo '</script>';
			} 
	   ?>


<div id="main">
	<div id="login">
    
	<?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'memberlogin-form',
                    'enableAjaxValidation'=>false,
                    "htmlOptions"=>array(
                    'onSubmit'=>"if(document.getElementById('logintype').value!='SITEMANAGER'){alert('请选择身份');return false;}",
                    )
            )); 
			$username=$model->username?$model->username:"";
			if(!$username){
				$username=isset($_COOKIE['logname'])?$_COOKIE['logname']:"";
			}
			
			?>
            
	 <table cellspacing="0" cellpadding="0" border="0">
	          <tbody>
              
              <tr>
	            <td width="30%" height="30px">用户ID：</td>
	            <td colspan="2" align="left"><?php echo $form->textField($model,'username',array('value'=>$username,"size"=>"23")); ?></td>
              </tr>
	          <tr>
	            <td height="30px">密&nbsp;码：</td>
	            <td colspan="2" align="left"><?php echo $form->passwordField($model,'password',array("size"=>"23","autoComplete"=>"off",)); ?></td>
              </tr>
	          <tr>
	            <td height="30px">身&nbsp;份：</td>
	            <td colspan="2"  align="left">
                        <select id="logintype"  name="type">
						
						<option <?=isset($_POST['type'])&&$_POST['type']=="STUDENT"?"selected='selected'":""?> value="STUDENT">学生</option>
						
						<option <?=isset($_POST['type'])&&$_POST['type']=="TEACHER"?"selected='selected'":""?> value="TEACHER">教师</option>
						
						<option <?=isset($_POST['type'])&&$_POST['type']=="MANAGER"?"selected='selected'":""?> value="MANAGER">管理员</option>
						
						<option <?=isset($_POST['type'])&&$_POST['type']=="SITETEACHER"?"selected='selected'":""?> value="SITETEACHER">指导教师</option>
						
						<option <?=isset($_POST['type'])&&$_POST['type']=="SITEMANAGER"?"selected='selected'":""?> value="SITEMANAGER">学习中心管理员</option>
						
                  		</select>
	              </td>
              </tr>
	          <tr>
	            <td height="30px">验证码：</td>
	            <td height="30" width="25%" align="left">
                <?php echo $form->textField($model,'verifyCode',array("size"=>"8","autoComplete"=>"off",)); ?></td>
	            <td width="31%" height="30px" align="left">
				<?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('id'=>'captchacode','alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer'))); ?>
                </td>
              </tr>
	     
        
	    <tr>
        	<td></td>
            <td></td>
	      <td height="15" colspan="3"><a href="javascript:refreshCode()">刷新验证码</a></td>
          
        </tr>
        <tr>
	      <td height="30" colspan="3" align="center"><input type='image' style='width:88px;height:26px' src="/images/button1.gif" /></td>
        </tr>
	 </tbody></table>
	 <?php $this->endWidget(); ?>
	</div>
</div>
    