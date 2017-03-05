<?php

class AdminModule extends CWebModule
{
    public $defaultController='admin';
	public function init()
	{
        $this->setImport(array('admin.models.*','admin.components.*'));
	}
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// echo Yii::app()->user->role;
			// echo Yii::app()->user->id;
            // echo Yii::app()->user->adminisGuest;exit;
            $checkIe=false;
            if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 8.0")||strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 7.0")){
             $checkIe=true;
             // print_r($_COOKIE);
            }
            
            $controlleraction = "admin".strtolower($controller->id.$action->id);
            if($checkIe){
                if($controlleraction!='adminmanageusercaptcha'){
                    if($controlleraction!="adminmanageuserlogin"){//只有login是例外的 管理后台还没有登录
                        if(!isset(Yii::app()->user->adminisGuest)||Yii::app()->user->adminisGuest!='yes'){
                            echo "<script>window.location.href='".DOMAIN."/admin/manageuser/login';</script>";
                            exit();
                        }
                    }else{//是login 并且已经登录了管理后台
                        if(isset(Yii::app()->user->adminisGuest)&&Yii::app()->user->adminisGuest=='yes'){
                            echo "<script>window.location.href='".DOMAIN."/admin';</script>";
                            exit();
                        }
                    }
                    
                }	

            }else{
                if($controlleraction!='adminmanageusercaptcha'){
                    if($controlleraction!="adminmanageuserlogin"){//只有login是例外的 管理后台还没有登录
                        if(Yii::app()->user->isGuest||!isset(Yii::app()->user->adminisGuest)||Yii::app()->user->adminisGuest!='yes'){
                            echo "<script>window.location.href='".DOMAIN."/admin/manageuser/login';</script>";
                            exit();
                        }
                    }else{//是login 并且已经登录了管理后台
                        if(!Yii::app()->user->isGuest&&isset(Yii::app()->user->adminisGuest)&&Yii::app()->user->adminisGuest=='yes'){
                            echo "<script>window.location.href='".DOMAIN."/admin';</script>";
                            exit();
                        }
                    }
                    
                }	
            }
			return true;
		}
		else
			return false;
	}
}