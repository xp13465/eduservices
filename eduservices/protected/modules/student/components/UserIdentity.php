<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
    public $phoneCode;
	const ERROR_EMAIL_UNCHECK=10;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $verifyType=Config::model()->getConfig('verifyType');
        if($verifyType==2||$verifyType==3){
            $user = Students::model()->find("s_credentialsnumber='{$this->username}' and s_status ='2' and s_isdel ='1'");
            if($user)
            $Codemodel=Phonemsgcode::model()->find("pmc_phone ='{$user->s_phone}' and pmc_time >=".time()." order by pmc_time desc" );
            
            $phoCode=isset($_POST['LoginFormPhone'])&&isset($_POST['LoginFormPhone']['phoneCode'])?$_POST['LoginFormPhone']['phoneCode']:"";
            if($user===null)
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            else if(!$Codemodel||$phoCode!=$Codemodel->pmc_code)
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            elseif($user->s_status!=2){
                $this->errorCode=self::ERROR_EMAIL_UNCHECK;
            }else{
                $IP=Yii::app()->request->userHostAddress;
                $loginlog=new Studentloginlog;
                $loginlog->sll_sid=$user->s_id;
                $loginlog->sll_ipaddress=$IP;
                $loginlog->sll_logintime=time();
                $loginlog->sll_msgid=$Codemodel?$Codemodel->pmc_id:0;
                $loginlog->save();
                $this->_id=$user->s_id;
                //$this->username=$user->user_email;
                $this->setState('role','9999');
                $this->setState("adminisGuest",'');
                $this->setState("studentisGuest",'yes');
                $this->errorCode=self::ERROR_NONE;
            }
            return $this->errorCode==self::ERROR_NONE;
            
        }else {
            $user = Students::model()->find("s_credentialsnumber='{$this->username}' and s_status ='2' and s_isdel ='1'");
            if($user===null)
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            else if($this->password!=$user->s_phone)
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            elseif($user->s_status!=2){
                $this->errorCode=self::ERROR_EMAIL_UNCHECK;
            }else{
                $this->_id=$user->s_id;
                //$this->username=$user->user_email;
                $this->setState('role','9999');
                $this->setState("adminisGuest",'');
                $this->setState("studentisGuest",'yes');
                $this->errorCode=self::ERROR_NONE;
            }
            return $this->errorCode==self::ERROR_NONE;
        }
        
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}