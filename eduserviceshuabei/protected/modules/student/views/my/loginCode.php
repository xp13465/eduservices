
<div align="center">
  <center>
            <?php
			// print_r($model->errors);
			if(isset($model->errors['password'])||isset($model->errors['verifyCode'])){
                        
                            if(isset($model->errors['verifyCode'])) {
                              echo "<script>alert('{$model->errors['verifyCode'][0]}');</script>";
                            }else {
                              echo "<script>alert('{$model->errors['password'][0]}');</script>";
                            }
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
    <table width="602" cellspacing="0" cellpadding="0" border="0" background="/images/studentlogin.jpg" align="center" height="419" style="border-collapse: collapse; border: 1px solid #000000" id="AutoNumber1">
        <tbody><tr valign="top">
          <td width="100%" style="height: 120"></td>
        </tr>        
        <tr valign="top">
          <td width="100%" height="212">
          <div align="center">
            <table width="70%" cellspacing="0" cellpadding="0" bordercolor="#111111" border="0" height="212" style="border-collapse: collapse" id="AutoNumber5">
              <tbody><tr>
                <td width="35%" style="height:172px"></td>
                <td width="60%"></td>
              </tr>
              <tr valign="middle">
                  <td align="right" style="height:31px"><font color="white">身份证号：</font></td>
                <td align="left"><?php echo $form->textField($model,'username',array('value'=>$username)); ?></td>
              </tr>
              <tr valign="middle">
                  <td align="right" style="height:31px"><font color="white">手机号：</font></td> 
                <td align="left"><?php echo $form->textField($model,'password',array("autoComplete"=>"off",)); ?></td>
                </tr>
              <tr valign="middle">
                  <td align="right" style="height:31px"><font color="white">验证码：</font></td> 
                <td align="left" style="height: 5"><label for="user_code"><?php echo $form->textField($model,'verifyCode',array("class"=>"l_code","autoComplete"=>"off",)); ?>
				<?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','width'=>45,'height'=>25,'style'=>'cursor:pointer;margin:0px;padding:0px;vertical-align:middle;'))); ?>
                </label>
                </td>
                </tr>
                <? /*<tr valign="top">
                    <td style="height: 5" colspan="2"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;
                      <input id="rememberme" name="rememberme" value="forever" <?=isset($_POST['rememberme'])?'checked':isset($_COOKIE['logname'])?"checked ":"";?> tabindex="90" type="checkbox"> 记住我的帐号信息</td>
                </tr> */?>
                <tr valign="top">
                    <td style="height: 5" colspan="2"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;
                      <input name="loginsubmit" type="submit" class="s02" name="B1" value="登 陆">&nbsp;&nbsp;&nbsp;&nbsp;                   
                       <input type="reset" class="s02" name="submit2" value="取 消">
                    </div></td>
                </tr>
                  
            </tbody>
            </table>
          </div>
          </td>
        </tr>
        <tr valign="top" align="center">
          <td width="100%" valign="top"><a href="#"><font color="white"></font></a></td>
         </tr>
         <tr valign="top" align="center">
          <td width="100%" valign="top"></td>
         </tr>
      </tbody>
      </table>     
      <?php $this->endWidget(); ?>      
    </center>
</div>