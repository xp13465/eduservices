<?php

class InputlimitsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delall', // we only allow deletion via POST request
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','create','update','delall'),
				'users'=>array('admin','sysadmin','hdjgzx'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($uid)
	{
		$model=new Inputlimits;
        $usermodel=User::model()->findByPk($uid);
		if($usermodel===null)
			throw new CHttpException(404,'您访问的页面不存在。');
            
		if($_POST)
		{
			$model->attributes=$_POST; 
            $userid=Yii::app()->user->id;
            $time=time();
            $model->il_uid = $uid;
            $model->il_addid = $userid;
            $model->il_editid = $userid;
            $model->il_addtime = $time;
            $model->il_edittime = $time;
			if($model->save())
				$this->redirect(array('Account/view','id'=>$model->il_uid));
		}

		$this->render('create',array(
			'model'=>$model,
            'usermodel'=>$usermodel,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $usermodel=User::model()->findByPk($model->il_uid);
        if($usermodel===null)
			throw new CHttpException(404,'您访问的页面不存在。'); 
            
		if($_POST)
		{
			$model->attributes=$_POST; 
            $userid=Yii::app()->user->id;
            $time=time();
            $model->il_editid = $userid;
            $model->il_edittime = $time;
			if($model->save())
				$this->redirect(array('Account/view','id'=>$model->il_uid));
		}

		$this->render('update',array(
			'model'=>$model,
            'usermodel'=>$usermodel,
		));
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Inputlimits');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
    
    public function actionDelall()
	 {
	   if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
	   {
			$criteria= new CDbCriteria; 
			$count =Inputlimits::model()->deleteAll("il_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	 }
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inputlimits the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inputlimits::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}

}
