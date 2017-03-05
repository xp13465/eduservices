<?php

class AccountController extends Controller
{
	public $layout='admin';
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','add','edit','delall'),
				'users'=>array("admin","sysadmin"),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    /*
     * 通过帐号ID查看用户详细信息
     */
	public function actionView($id,$type='')
	{
        $model=$this->loadModel($id);
        if($type=="clean"){
            $IpArr= explode(",",$model->user_iparr);
            if(count($IpArr)>5){
                $num=count($IpArr)-5;
                for($i=0;$i<$num;$i++){
                    unset($IpArr[$i]);
                }
                $IpStr=join(",",$IpArr);
                $model->user_iparr=$IpStr;
                $model->save(); 
            }
            Yii::app()->user->setFlash("message","已清理");
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        if(in_array($model->user_role,array(4,5)))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
		$this->render('view',array(
			'model'=>$model,
		));
	}
	/*
     * 添加用户信息
     */
	public function actionAdd()
	{
		$model=new User;
		$check=false;	
		if($_POST)
		{
            $authArr=unserialize($model->user_authorize);
            $authArr['diyinsert']=0;
            $authArr['synbeihang']=0;
			$model->attributes=$_POST;
			$model->user_regtime=time();
			if($_POST['user_pwd']==$_POST['user_repwd']){
				$model->user_pwd=md5($model->user_pwd);
			}
            foreach($authArr as $key=>$v){
                if(isset($_POST["auth"][$key])&&in_array($_POST["auth"][$key],array(1,2))){
                    $authArr[$key]=$_POST["auth"][$key];
                }else{
                    $authArr[$key]=0;
                }
            }
            
			if(isset($_POST['zhongxin'])&&$_POST['zhongxin']){
				if(isset($_POST['baomingdian'])&&$_POST['baomingdian']){
					if(isset($_POST['jigou'])&&$_POST['jigou']){
						$model->user_organization=$_POST['jigou'];
						$model->user_role=1;
						$check=true;
					}else{
						$model->user_organization=$_POST['baomingdian'];
						$model->user_role=2;
						$check=true;
					}
				
				}else{
					$model->user_organization=$_POST['zhongxin'];
					$model->user_role=3;
					$check=true;
				}
			}else{
				$model->addError('zhongxin',"请选择学习中心");
			}
			if($check){
				if($model->save()){
					if($model->user_headimg&&!strpos($model->user_headimg,"/UH/")){
						$checkHD=Files::model()->SaveFile($model->user_headimg,$model->user_name,7,$model->user_id);
						if($checkHD){
							$model->user_headimg=$checkHD;
							$model->save();
						}
					}
					$this->redirect(array('view','id'=>$model->user_id));
				}else{
					unset($model->user_pwd);
				}
			}
		}
		// print_r($model->errors);
		$this->render('add',array(
			'model'=>$model,
		));
	}
	
	public function actionEdit($id)
	{
        
		$model=$this->loadModel($id);
		if($model->user_role=='4')throw new CHttpException(404,'您访问的页面不存在。');
		$check=false;	
		if($_POST)
		{
            $authArr=unserialize($model->user_authorize);
            $authArr['diyinsert']=0;
            $authArr['synbeihang']=0;
			$model->attributes=$_POST;
			$model->user_regtime=time();
			if($_POST['user_pwd']==$_POST['user_repwd']&&$_POST['user_pwd']&&$_POST['user_repwd']){
				$model->user_pwd=md5($model->user_pwd);
			}else{
				unset($model->user_pwd);
			}
            foreach($authArr as $key=>$v){
                if(isset($_POST["auth"][$key])&&in_array($_POST["auth"][$key],array(1,2))){
                    $authArr[$key]=$_POST["auth"][$key];
                }else{
                    $authArr[$key]=0;
                }
            }
            $model->user_authorize=serialize($authArr);
			if(isset($_POST['zhongxin'])&&$_POST['zhongxin']){
				if(isset($_POST['baomingdian'])&&$_POST['baomingdian']){
					if(isset($_POST['jigou'])&&$_POST['jigou']){
						$model->user_organization=$_POST['jigou'];
						$model->user_role=1;
						$check=true;
					}else{
						$model->user_organization=$_POST['baomingdian'];
						$model->user_role=2;
						$check=true;
					}
			
				}else{
					$model->user_organization=$_POST['zhongxin'];
					$model->user_role=3;
					$check=true;
				}
			}else{
				$model->addError('zhongxin',"请选择学习中心");
			}
			if($check){
				if($model->save()){
					if($model->user_headimg&&!strpos($model->user_headimg,"/UH/")){
						$checkHD=Files::model()->SaveFile($model->user_headimg,$model->user_name,7,$model->user_id);
						if($checkHD){
							$model->user_headimg=$checkHD;
							$model->save();
						}
					}
					$this->redirect(array('view','id'=>$model->user_id));
				}else{
					
				}
			}
		}
		unset($model->user_pwd);
		// print_r($model->errors);
		$this->render('edit',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria;
		foreach($_GET as $key=>$val){$val = addslashes($val);
			if($key=="u_name"&&$val&&$val!="负责人..")$criteria->addCondition("user_nkname  regexp '{$val}' ");
			if($key=="user_role"&&$val)$criteria->addCondition("user_role  = '{$val}' ");
			if($key=="user_status"&&($val||$val=='0'))$criteria->addCondition("user_status  = '{$val}' ");
		}
        if(isset($_GET['o_name'])&&$_GET['o_name']&&$_GET['o_name']!='机构..'){
            $Array=array();
            $OArr=Organization::model()->findAll("o_name regexp '{$_GET['o_name']}'");
            foreach($OArr as $key=>$val)$Array[]=$val->o_id;
            $criteria->addInCondition("user_organization ",$Array);
        }
        // else{
            if(isset($_GET['zhongxin'])&&$_GET['zhongxin']){
                if(isset($_GET['baomingdian'])&&$_GET['baomingdian']){
                    if(isset($_GET['jigou'])&&$_GET['jigou']){
                        $criteria->addCondition("user_organization  = '{$_GET['jigou']}' ");
                    }else{
                        $Array=array($_GET['baomingdian']);
                        $data=	Organization::model()->getOrByPid($_GET['baomingdian']);
                        foreach($data as $key=>$val)$Array[]=$key;
                        $criteria->addInCondition("user_organization ",$Array);
                    }
                }else{
                    $Array=array($_GET['zhongxin']);
                    $data=	Organization::model()->getOrByPid($_GET['zhongxin']);
                    foreach($data as $key=>$val){
                        $datas=	Organization::model()->getOrByPid($key);
                        foreach($datas as $k=>$v)$Array[]=$k;
                        $Array[]=$key;
                    }
                    $criteria->addInCondition("user_organization ",$Array);
                }
            }
        // }
		$criteria->addCondition("user_isdel  = '1' ");
		$orderArr=array(
			"bcu"=>"s_baokaocengci asc",
			"bzu"=>"s_baokaozhuanye asc",
			"stu"=>"s_status asc",
			"tmu"=>"s_addtime asc",
			
			"bcd"=>"s_baokaocengci desc",
			"bzd"=>"s_baokaozhuanye desc",
			"std"=>"s_status desc",
			"tmd"=>"s_addtime desc",
		);
		$order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"user_id asc";
		$pageSize=isset($_COOKIE['u_pagesize'])?$_COOKIE['u_pagesize']:"20";
		setcookie("userreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		// print_r($_COOKIE);
        $dataProvider =  new CActiveDataProvider("User", array(
                        'criteria'=>$criteria,
                        'pagination'=>array(
                                'pageSize'=>$pageSize
                        ),
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			// 'model'=>$model,
		));
	}
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
	public function actionDelall()
	 {
	 
	   if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
	   {
			$criteria= new CDbCriteria;
			$criteria->addInCondition('user_id', $_POST['selectdel']);
			$count =User::model()->updateAll(array('user_isdel'=>'2'),"user_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	 }
     
}