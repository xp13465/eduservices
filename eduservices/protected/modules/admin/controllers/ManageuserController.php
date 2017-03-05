<?php
class ManageuserController extends Controller
{	
	
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
             'captcha'=>array(
                                'class'=>'CCaptchaAction',
                                'backColor'=>0xFFFFFF, 
                                'padding'=>'0',
                                'maxLength'=>'4',       // 最多生成几个字符
                                'minLength'=>'4',       // 最少生成几个字符
                                'height'=>'24',
                                'testLimit'=>'3',//三次之后更新验证码
                                'width'=>'50',
                                'offset'=>'0',
             ), 
        );
    }
    public $layout = "login";
	
    public function actionLogin(){
			$model=new LoginForm;
            if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
                if(Yii::app()->user->isGuest){
                    $model->username=$_POST['username'];
                    $model->password=$_POST['password'];
                    // print_r($_POST);
                    $model->verifyCode=$this->createAction('captcha')->getVerifyCode() ;
                    if($model->validate() && $model->login()) {
                        echo "success";
                        exit;
                    }
                    echo "error";
                    exit;
                }else{
                    echo "isguest";
                    exit;
                }
                
            }
			if(isset($_POST['LoginForm'])) {
				if(isset($_POST['rememberme'])&&$_POST['rememberme']=='forever'){ 
					setcookie("logname",$_POST['LoginForm']['username'],time()+86400*14,'/');
				}else{
					setcookie("logname",$_POST['LoginForm']['username'],time()-86400,'/');
				}
				$model->attributes=$_POST['LoginForm'];
				if($model->validate() && $model->login()){
					$this->redirect(DOMAIN."/admin");
				}
			}
        $this->render("login",array(
            "model"=>$model,
        ));
    }
    public function actionLogout(){
        $Umodel=User::model()->findByPk(Yii::app()->user->id);
        $Auth=unserialize($Umodel->user_authorize);
        Yii::app()->user->setState("adminisGuest","");
        Yii::app()->user->setState("studentisGuest","");
		Yii::app()->user->logout();
        if(isset($Auth['synbeihang'])&&$Auth['synbeihang']==1){
            $this->redirect("http://202.43.154.166/bhwy/login_new.jsp");
        }else{
            $this->redirect(DOMAIN."/admin");
        }
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