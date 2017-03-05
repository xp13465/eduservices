<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginFormPhone extends CFormModel
{
	public $username;
	public $password;
    public $rememberMe;
	// public $verifyCode;
    public $phoneCode;
	private $_identity;
	

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('username, phoneCode', 'required'),
            array('phoneCode', 'authPhoneCode'),
			array('password', 'authenticate'),
			// array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
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

    public function authPhoneCode(){
       
        if(!isset($this->phoneCode)){
            $this->addError('password','请输入验证码');
        }
        if(isset($this->password)){
            $user = Students::model()->count("s_credentialsnumber='{$this->username}' and s_phone='{$this->password}' and s_status ='2' and s_isdel ='1'");
            if(!$user){
                $this->addError('password','手机号码与身份证不匹配');
            }
        }
        
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
                $this->addError('password','动态密码错误');
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