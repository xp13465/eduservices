<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {
    public $username;
    public $password;
    public $rememberMe;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
                // username and password are required
                array('username, password', 'required'),
                // rememberMe needs to be a boolean
                array('rememberMe', 'boolean'),
                // password needs to be authenticated
                array('password', 'authenticate', 'skipOnError'=>true),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            "username"=>"用户名",
            "password"=>"密码",
            'rememberMe'=>'下次自动登录（保持30天登录状态）',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params) {
        $identity = new UserIdentity($this->username,$this->password);
        if($identity->authenticate()) {
            $duration = $this->rememberMe ? 3600*24*30: 0; // 30 days
            Yii::app()->user->login($identity,$duration);
        }else {
            $this->addError('password','用户名或密码错误！');
        }
    }
}
