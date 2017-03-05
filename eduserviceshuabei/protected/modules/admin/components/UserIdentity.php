<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	const ERROR_EMAIL_UNCHECK=10;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $loginStr="and user_role in(1,2,3,4,5)";
        if(isset($_POST['logintype'])&&in_array($_POST['logintype'],array(1,2))){
            if($_POST['logintype']==1){
                $loginStr="and ( user_role = 4 or user_role = 5)";
            }else if($_POST['logintype']==2){
                $loginStr="and (user_role = 1 or user_role = 2 or user_role = 3)";
            }
        }
        
		$user = User::model()->find("user_name='{$this->username}' {$loginStr}  and user_isdel ='1'");
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(md5($this->password)!=$user->user_pwd)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		elseif($user->user_status!=1){
            $this->errorCode=self::ERROR_EMAIL_UNCHECK;
        }else
		{
            $IP=Yii::app()->request->userHostAddress;
			$this->_id=$user->user_id;
			//$this->username=$user->user_email;
            $this->setState('role',$user->user_role);
			$this->setState("adminisGuest",'yes');
            $this->setState("studentisGuest",'');
            $user->user_loginnum = $user->user_loginnum+1;
            $user->user_lastip = $IP;
            $ipArr=$user->user_iparr!=" "?explode(",",$user->user_iparr):array();
            if(!in_array($IP,$ipArr)){
                $ipArr[]=$IP;
                $user->user_iparr=join(",",$ipArr);
            }
            $user->user_lasttime = time();
            $user->update();
            if($user->user_loginnum==1){
                $cookie = Yii::app()->request->getcookies();
            }
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}