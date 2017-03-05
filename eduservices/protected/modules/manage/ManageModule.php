<?php

class ManageModule extends CWebModule
{
    public $defaultController='site';
	public function init()
	{
        $this->setImport(
        array(
            'manage.models.*',
            'manage.components.UserIdentity',
            'manage.components.Navigation',
            'manage.components.Controller',
            )
         );
	}
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
            $controlleraction = "manage".strtolower($controller->id.$action->id);
			if($controlleraction!='managesitecaptcha'){
               
				if($controlleraction!="managesitelogin"){//ֻ��login������� �����̨��û�е�¼
					if(Yii::app()->user->isGuest||!isset(Yii::app()->user->adminisGuest)||Yii::app()->user->adminisGuest!='yes'|Yii::app()->user->role!="4"){
						echo "<script>window.location.href='".DOMAIN."/manage/site/login';</script>";
                        exit();
					}
				}else{  //��login �����Ѿ���¼�˹����̨
                 // echo $controlleraction;exit;
					if(!Yii::app()->user->isGuest&&isset(Yii::app()->user->adminisGuest)&&Yii::app()->user->adminisGuest=='yes'&&Yii::app()->user->role=="4"){
                            echo "<script>window.location.href='".DOMAIN."/manage';</script>";
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
