<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginFormCode extends CFormModel
{
	public $username;
	public $password;
    public $rememberMe;
	public $verifyCode;
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
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            array("rememberMe","safe"),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
            "username"=>"身份证号",
            "password"=>"手机号码",
			'rememberMe'=>'Remember me next time',
			'verifyCode' => 'Verification Code',
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
            if($this->_identity->errorCode===UserIdentity::ERROR_EMAIL_UNCHECK){
                $this->addError('password','审核未通过');
            }else if($this->_identity->errorCode===UserIdentity::ERROR_USERNAME_INVALID){
                $this->addError('password','此身份证不存在');
            }else if($this->_identity->errorCode===UserIdentity::ERROR_PASSWORD_INVALID){
                $this->addError('password','手机号码错误');
            }else{
                $this->addError('password','登录失败');
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
			return true;
		}else
			return false;
	}
}