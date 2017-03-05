<?php

class UserController extends Controller
{
	public $layout='frame';
	public function actionIndex(){
        $this->render("index");
    }
	public function actionSynlogin(){
    
    $orArr['hb']=array(
        "1000655301"=>"邯郸市临漳县职业技术教育中心校外学习中心",
        "1000655401"=>"河北美术学院校外学习中心 ",
        "1000655501"=>"赤峰学院远程教育学院",
        "1000656301"=>"运城北大燕工培训学校校外学习中心 ",
        "1000659101"=>"大同县职业学校校外学习中心",
        "1000659501"=>"晋中市榆次区新思维培训学校校外学习中心",
        "1000660001"=>"呼和浩特职业学院校外学习中心"
        );
    $orArr['hd']=array(
        "1000640301"=>"新余市职工学校",
        "1000640401"=>"江西省信息科技学校",
        "1000640501"=>"江西萍乡学习中心",
        "1000645001"=>"井冈山附属艺术学校",
        "1000645101"=>"宜丰职工学校",
        "1000641801"=>"泰州市科技专修学校",
        "1000642101"=>"湖南现代物流职业技术学院1",
        "1000642102"=>"湖南现代物流职业技术学院2",
        "1000642103"=>"湖南现代物流职业技术学院3",
        "1000642001"=>"上海职工职业技术进修学校1",
        "1000642002"=>"上海职工职业技术进修学校2",
        "1000642003"=>"上海职工职业技术进修学校3",
        "1000642004"=>"上海职工职业技术进修学校4",
        "qianlaoshi01"=>"丽水电大学习中心",
        "1000652201"=>"徐州机电工程高等职业学校",
        "1000652101"=>"常州市成人进修学院",
        "1000646401"=>"安庆职业技术学院学习中心",
        );
        if(isset($_GET['upw'])) {
            $upwd = $_GET['upw'];
            if($upwd&&$upwdArr = explode("|||",$upwd)){
                if(count($upwdArr)=="2"){
                    $urlArr=explode(".",$_SERVER['HTTP_HOST']);
                    if(array_key_exists($upwdArr[0],$orArr['hb'])){
                        header("Location: http://hb.onlinebeihang.com/api/user/synlogin/callback/synlogin/upw/{$upwdArr[0]}|||{$upwdArr[1]}/");
                        exit;
                    }elseif($urlArr[0]!='bh'){
                        header("Location: http://bh.onlinebeihang.com/api/user/synlogin/callback/synlogin/upw/{$upwdArr[0]}|||{$upwdArr[1]}/");
                        exit;
                    }
                }
            }
        }
        
        $return = false;
		$model = new LoginForm;
		if(isset($_GET['upw'])) {
			$upwd = $_GET['upw'];
			if($upwd&&$upwdArr = explode("|||",$upwd)){
				if(count($upwdArr)=="2"){
					 $model->username=$upwdArr[0];
					 $model->password=md5($upwdArr[1]);
					if($model->validate()&&$model->login()){
						$return=array("code"=>"0","message"=>"同步登录成功","returnurl"=>"http://bh.onlinebeihang.com/admin");
					}else{
						$return=array("code"=>"1","message"=>join(",",$model->errors['message']),"returnurl"=>"http://bh.onlinebeihang.com/admin");//join(",",$model->errors['errorcode'])
					}
				}else{
                    $return=array("code"=>"2","message"=>"错误的参数","returnurl"=>"http://bh.onlinebeihang.com/admin");
                }
			}
		}
        // print_r($return);
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