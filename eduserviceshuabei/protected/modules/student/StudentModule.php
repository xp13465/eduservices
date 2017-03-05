<?php

class StudentModule extends CWebModule
{
    public $defaultController='my';
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array('student.models.*','student.components.*'));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
            $controlleraction = "student".strtolower($controller->id.$action->id);
			if($controlleraction!='studentmycaptcha'){
				if($controlleraction!="studentmylogin"){//只有login是例外的 管理后台还没有登录
					if(Yii::app()->user->isGuest||!isset(Yii::app()->user->studentisGuest)||Yii::app()->user->studentisGuest!='yes'){
						echo "<script>window.location.href='".DOMAIN."/student/my/login';</script>";
                        exit();
					}
				}else{//是login 并且已经登录了管理后台
					if(!Yii::app()->user->isGuest&&isset(Yii::app()->user->studentisGuest)&&Yii::app()->user->studentisGuest=='yes'){
						echo "<script>window.location.href='".DOMAIN."/student';</script>";
                        exit();
					}
				}
				
			}	
			return true;
		}
		else
			return false;
	}
}
