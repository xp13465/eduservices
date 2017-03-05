<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	private $_identity;
	

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
            "password"=>"密码",
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		$this->_identity=new UserIdentity($this->username,$this->password);
		if(!$this->_identity->authenticate()){
			$this->addError('errorcode',$this->_identity->errorCode);
            if($this->_identity->errorCode===UserIdentity::ERROR_EMAIL_UNCHECK){
                $this->addError('message','帐号未启用');
            }elseif($this->_identity->errorCode===UserIdentity::ERROR_AUTHORIZE_INVALID){
                $this->addError('message','用户未授权');
            }elseif($this->_identity->errorCode===UserIdentity::ERROR_PASSWORD_INVALID){
                $this->addError('message','错误的用户密码。');
            }else{
                $this->addError('message','用户不存在');
            }
        }
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
            $duration = 0;//isset($this->rememberMe)?86400*7:0;
			Yii::app()->user->login($this->_identity,$duration);
			Yii::app()->user->setState("adminisGuest",'yes');
			return true;
		}else
			return false;
	}
}