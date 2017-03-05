<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	const ERROR_EMAIL_UNCHECK=10;//用户未启用
	const ERROR_AUTHORIZE_INVALID=11;//用户未授权
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        
		$user = User::model()->find("user_name='{$this->username}' and user_role in(1,2,3,4) and user_isdel ='1'");
        if($user) {
            if($user->user_status!=1) {
                $this->errorCode=self::ERROR_EMAIL_UNCHECK;
            } else {
                $authorize=unserialize($user->user_authorize);
                switch ($authorize['synlogin']) {
                case 1:
                    if($this->password!=$user->user_pwd) {
                        $this->errorCode=self::ERROR_PASSWORD_INVALID;
                    } else {
                        $this->_id=$user->user_id;
                        $this->setState('role',$user->user_role);
                        $this->setState("adminisGuest",'yes');
                        $this->setState("studentisGuest",'');
                        $user->user_loginnum = $user->user_loginnum+1;
                        $user->user_lasttime = time();
                        $IP=Yii::app()->request->userHostAddress;
                        $user->user_lastip = $IP;
                        $ipArr=$user->user_iparr!=" "?explode(",",$user->user_iparr):array();
                        if(!in_array($IP,$ipArr)){
                            $ipArr[]=$IP;
                            $user->user_iparr=join(",",$ipArr);
                        }
                        $user->update();
                        if($user->user_loginnum==1){
                            $cookie = Yii::app()->request->getcookies();
                        }
                        $this->errorCode=self::ERROR_NONE;
                    }
                    break;
                case 2:
                    $this->_id=$user->user_id;
                    $this->setState('role',$user->user_role);
                    $this->setState("adminisGuest",'yes');
                    $user->user_loginnum = $user->user_loginnum+1;
                    $user->user_lasttime = time();
                    $IP=Yii::app()->request->userHostAddress;
                    $user->user_lastip = $IP;
                    $ipArr=$user->user_iparr!=" "?explode(",",$user->user_iparr):array();
                    if(!in_array($IP,$ipArr)){
                        $ipArr[]=$IP;
                        $user->user_iparr=join(",",$ipArr);
                    }
                    $user->update();
                    if($user->user_loginnum==1){
                        $cookie = Yii::app()->request->getcookies();
                    }
                    $this->errorCode=self::ERROR_NONE;
                    break;
                default:
                    $this->errorCode=self::ERROR_AUTHORIZE_INVALID;
                    break;
                }
            }
        } else {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
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