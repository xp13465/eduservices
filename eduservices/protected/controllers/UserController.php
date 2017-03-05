<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('isused'),
				'users'=>array('*'),
			),
			// array('allow', // allow admin user to perform 'admin' and 'delete' actions
				// 'actions'=>array('index','view','create','update','admin','delete'),
				// 'users'=>array('*'),
			// ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}    

	
	public function actionIsused() {
        if(Yii::app()->request->isAjaxRequest) {
            $valid = 'true';
            switch (true) {
                case !empty($_REQUEST['oldpwd']):
					$id=Yii::app()->user->id;
                    $model=User::model()->find("user_pwd=? and user_id ='{$id}'",array(md5($_REQUEST['oldpwd']))) ;
                    if(!$model)
                        $valid = 'false';
                    break;
                case !empty($_REQUEST['Toldpwd']):
					$id=Yii::app()->user->id;
                    $model=Teacher::model()->find("te_pwd=? and te_id ='{$id}'",array(md5($_REQUEST['Toldpwd']))) ;
                    
                    if(!$model)
                        $valid = 'false';
                    break;
                case !empty($_REQUEST['s_credentialsnumber']):
					$str=isset($_GET['id'])&&$_GET['id']?" and s_id !='{$_GET['id']}'":'';//and (s_status =2 or s_status =1)
                    $model=Students::model()->find("LOWER(s_credentialsnumber)=? and s_stype=1 and s_isdel=1  {$str}",array(strtolower(trim($_REQUEST['s_credentialsnumber']))) );
                    $id=Yii::app()->user->id;
                    $user=User::model()->findByPk($id);
                    $checkArr=$user->user_sfqz?explode(",",$user->user_sfqz):array();
                    $sfcode=substr(strtolower(trim($_REQUEST['s_credentialsnumber'])),0,2);
                    if(Yii::app()->user->role!="4"&&$checkArr&&!in_array($sfcode,$checkArr)){
                        $valid = 'false';
                        break;
                    }
                    if($model)
                       $valid = 'false';
                    break;
                case !empty($_REQUEST['s_phone']):
					$str=isset($_GET['id'])&&$_GET['id']?" and s_id !='{$_GET['id']}'":'';//
					$model=Students::model()->find("LOWER(s_phone)=? and s_isdel=1 and s_stype=1  and (s_status =2 or s_status =1) {$str}",array(strtolower(trim($_REQUEST['s_phone']))) );
                    if($model)
                         $valid = 'false';
                    break;
                case !empty($_REQUEST['s_birthdate']):
                    if($_REQUEST['s_birthdate']){
                    
                    $RpcTime="20".Common::getRuPiCi()."01";
                    $yearTime=strtotime("+1 month -18 year ",strtotime($RpcTime));
                    // echo date("Y-m-d H:i:s",$yearTime);
                    $SbTime=strtotime($_REQUEST['s_birthdate']);
                       if(($SbTime>=$yearTime)){
                            $valid = 'false';
                       }
                    }
                    break;
            }
            echo $valid;
        }
    }    

}