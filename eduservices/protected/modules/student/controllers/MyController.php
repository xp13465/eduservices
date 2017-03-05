<?php

class MyController extends Controller
{
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
             'captcha'=>array(
                                'class'=>'CCaptchaAction',
                                'backColor'=>0xFFFFFF, 
                                'maxLength'=>'4',       // 最多生成几个字符
                                'minLength'=>'4',       // 最少生成几个字符
                                'height'=>'40',
                                'testLimit'=>'3',//三次之后更新验证码
                                'width'=>'60',
             ), 
        );
    }
    public $layout = "student";
	public function actionIndex()
	{
		$this->render('index');
	}
    public function actionMain()
	{
		$this->render('main');
	}
    public function actionLogin(){
        $this->pageTitle='北京航空航天大学现代远程教育-学员登录';
        $this->layout = "login";
        $verifyType=Config::model()->getConfig('verifyType');
        if($verifyType==2||$verifyType==3){
            $model=new LoginFormPhone;
            $Formname='LoginFormPhone';
            $view='loginPhone';
        }else{
            $model=new LoginFormCode;
            $Formname='LoginFormCode';
            $view='loginCode';
        }
        
		if(isset($_POST[$Formname])) {
			if(isset($_POST['rememberme'])&&$_POST['rememberme']=='forever'){ 
				setcookie("logname",$_POST[$Formname]['username'],time()+86400*14,'/');
			}else{
				setcookie("logname",$_POST[$Formname]['username'],time()-86400,'/');
			}
			$model->attributes=$_POST[$Formname];
            // print_r($model->attributes);exit;
			if($model->validate() && $model->login()){
				$this->redirect(DOMAIN."/student");
			}
		}
        
        $this->render($view,array(
            "model"=>$model,
        ));
    }
    public function actionLogout(){
        Yii::app()->user->setState("studentisGuest","");
        Yii::app()->user->setState("adminisGuest","");
		Yii::app()->user->logout();
        $this->redirect("login");
    }
    public function actionChagepwd(){
        $this->layout = "manage";
        if(isset($_POST)&&$_POST){
            $return = "内部错误！";
            $name = Manageuser::DEFAULT_ROOT_NAME;
            $model = Manageuser::model()->findByAttributes(array("m_name"=>$name));
            $password = md5($_POST["oldpwd"]);
            if($model&&$password==$model->m_password&&$_POST["newpwd1"]==$_POST["newpwd2"]){
                $model->m_password = md5($_POST["newpwd2"]);
                if($model->save()){
                    $return = "success";
                }
            }else{
                $return = "旧密码输入错误！";
            }
            echo $return;exit;
        }
        $this->render("chagepwd");
    }
}