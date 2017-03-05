<?php

class UserController extends Controller
{
	public $layout='frame';
	public function actionIndex(){
        $this->render("index");
    }
	public function actionSynlogin(){
        $return = false;
		$model = new LoginForm;
		if(isset($_GET['upw'])) {
			$upwd = $_GET['upw'];
			if($upwd&&$upwdArr = explode("|||",$upwd)){
				if(count($upwdArr)=="2"){
					 $model->username=$upwdArr[0];
					 $model->password=md5($upwdArr[1]);
					if($model->validate()&&$model->login()){
						$return=array("code"=>"0","message"=>"同步登录成功","returnurl"=>"http://hb.onlinebeihang.com/admin");
					}else{
						$return=array("code"=>"0","message"=>join(",",$model->errors['message']),"returnurl"=>"http://hb.onlinebeihang.com/admin");//join(",",$model->errors['errorcode'])
					}
				}else{
                    $return=array("code"=>"0","message"=>"错误的参数","returnurl"=>"http://hb.onlinebeihang.com/admin");
                }
			}
		}
        if($return){
            $this->callBack($return);
        }
        
    }
	public function actionSynlogout(){
        $return = false;
		if(isset($_GET['upw'])){
            $upwd = $_GET['upw'];
            if($upwd&&!Yii::app()->user->isGuest){
                $umodel=User::model()->find("user_name ='{$upwd}'");
                if($umodel){
                    if($umodel->user_status == "1"){
                        $authorize=unserialize($umodel->user_authorize);
                        switch ($authorize['changepwd']) {
                            case 1:
                                Yii::app()->user->setState("adminisGuest","");
                                Yii::app()->user->setState("studentisGuest","");
                                Yii::app()->user->logout();
                                $return = array("code"=>"0","message"=>"同步登出成功");
                                break;
                            default:
                                $return = array("code"=>"12", "message"=>"用户未授权");
                                break;
                        }
                        
                    } else {
                        $return = array("code"=>"10","message"=>"用户未启用");
                    }
                }else{
                    $return=array("code"=>"1","message"=>"用户不存在");
                }
            }else{
                $return=array("code"=>"0","message"=>"同步登出成功");
            }
		}
        if($return){
            $this->callBack($return);
        }
        
    }
	
	public function actionSynchangepwd(){
        // echo base64_encode("admin|||".md5(121212)."|||".md5(123456));
		$return=false;
		if(isset($_GET['upw'])){
            $upwd = $_GET['upw'];
			if($upwd && $upwdArr = explode("|||",$upwd)){
				if(count($upwdArr)=="3"){
					$umodel=User::model()->find("user_name ='{$upwdArr[0]}' and user_isdel=1");
					if($umodel){
                            if($umodel->user_status == "1"){
                                $authorize=unserialize($umodel->user_authorize);
                                switch ($authorize['changepwd']) {
                                    case 1:
                                        // echo $umodel->user_pwd;
                                         // echo $upwdArr[1];
                                        if ( $umodel->user_pwd == md5($upwdArr[1]) ) {
                                            $umodel->user_pwd = md5($upwdArr[2]);
                                            if ($umodel->save()) {
                                                $return = array("code"=>"0","message"=>"同步修改密码成功");
                                            }else{
                                                $return = array("code"=>"13","message"=>"同步修改密码失败（内部错误）");
                                            }
                                        } else {
                                            $return = array("code"=>"2","message"=>"用户原密码错误");
                                        }
                                        break;
                                    case 2:
                                        $umodel->user_pwd = $upwdArr[2];
                                        if ($umodel->save()) {
                                            $return = array("code"=>"0", "message"=>"同步修改密码成功");
                                        } else {        
                                            $return = array("code"=>"13","message"=>"同步修改密码失败（内部错误）");
                                        }
                                        break;
                                    default:
                                        $return = array("code"=>"12", "message"=>"用户未授权");
                                        break;
                                }
                            } else {
                                $return = array("code"=>"10","message"=>"用户未启用");
                            }
					}else{
						$return = array("code"=>"1","message"=>"用户不存在");
					}
					
				}
			}
		}
        if($return){
            $this->callBack($return);
        }
		exit;
    }
	//MD5 Base64加密API备份
	/*
	public function actionSynlogin(){
        $return = false;
		$model = new LoginForm;
		if(isset($_GET['upw'])) {
			$upwd = base64_decode($_GET['upw']);
			if($upwd&&$upwdArr = explode("|||",$upwd)){
				if(count($upwdArr)=="2" && Yii::app()->user->isGuest==1){
					$model->username=$upwdArr[0];
					$model->password=$upwdArr[1];
					if($model->validate()&&$model->login()){
						$return=array("code"=>"0","message"=>"同步登录成功");
					}else{
						$return=array("code"=>join(",",$model->errors['errorcode']),"message"=>join(",",$model->errors['message']));
					}
				}elseif(!Yii::app()->user->isGuest){
                    $return=array("code"=>"0","message"=>"同步登录成功");
                }
			}
		}
        if($return){
            $this->callBack($return);
        }
        
    }
	
	public function actionSynlogout(){
        $return = false;
		if(isset($_GET['upw'])){
            $upwd = base64_decode($_GET['upw']);
            if($upwd&&!Yii::app()->user->isGuest){
                $umodel=User::model()->find("user_name ='{$upwd}'");
                if($umodel){
                    if($umodel->user_status == "1"){
                        $authorize=unserialize($umodel->user_authorize);
                        switch ($authorize['changepwd']) {
                            case 1:
                                Yii::app()->user->setState("adminisGuest","");
                                Yii::app()->user->setState("studentisGuest","");
                                Yii::app()->user->logout();
                                $return = array("code"=>"0","message"=>"同步登出成功");
                                break;
                            default:
                                $return = array("code"=>"12", "message"=>"用户未授权");
                                break;
                        }
                        
                    } else {
                        $return = array("code"=>"10","message"=>"用户未启用");
                    }
                }else{
                    $return=array("code"=>"1","message"=>"用户不存在");
                }
            }else{
                $return=array("code"=>"0","message"=>"同步登出成功");
            }
		}
        if($return){
            $this->callBack($return);
        }
        
    }

	public function actionSynchangepwd(){
        // echo base64_encode("admin|||".md5(121212)."|||".md5(123456));
		$return=false;
		if(isset($_GET['upw'])){
            $upwd = base64_decode($_GET['upw']);
			if($upwd && $upwdArr = explode("|||",$upwd)){
                // echo 12;
				if(count($upwdArr)=="3"){
					$umodel=User::model()->find("user_name ='{$upwdArr[0]}' and user_isdel=1");
					if($umodel){
                            if($umodel->user_status == "1"){
                                $authorize=unserialize($umodel->user_authorize);
                                switch ($authorize['changepwd']) {
                                    case 1:
                                        // echo $umodel->user_pwd;
                                         // echo $upwdArr[1];
                                        if ( $umodel->user_pwd == $upwdArr[1] ) {
                                            $umodel->user_pwd = $upwdArr[2];
                                            if ($umodel->save()) {
                                                $return = array("code"=>"0","message"=>"同步修改密码成功");
                                            }else{
                                                $return = array("code"=>"13","message"=>"同步修改密码失败（内部错误）");
                                            }
                                        } else {
                                            $return = array("code"=>"2","message"=>"用户原密码错误");
                                        }
                                        break;
                                    case 2:
                                        $umodel->user_pwd = $upwdArr[2];
                                        if ($umodel->save()) {
                                            $return = array("code"=>"0", "message"=>"同步修改密码成功");
                                        } else {        
                                            $return = array("code"=>"13","message"=>"同步修改密码失败（内部错误）");
                                        }
                                        break;
                                    default:
                                        $return = array("code"=>"12", "message"=>"用户未授权");
                                        break;
                                }
                            } else {
                                $return = array("code"=>"10","message"=>"用户未启用");
                            }
					}else{
						$return = array("code"=>"1","message"=>"用户不存在");
					}
					
				}
			}
		}
        if($return){
            $this->callBack($return);
        }
		exit;
    }
	*/
    private function callBack($value){
        $return = json_encode($value);
        $dal=isset($_GET['callback'])&&$_GET['callback']?$_GET['callback']:"callback";
        echo $dal.'('.$return,')';
    }
}