<?php

class ProfessionalController extends Controller
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
				'actions'=>array('index','view','admin','create','update','delall','edit','statusall'),
				'users'=>User::model()->getManage(4),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Professional;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Professional']))
		{
			$model->attributes=$_POST['Professional'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->p_id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Professional']))
		{
			$model->attributes=$_POST['Professional'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->p_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionEdit($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if($_POST)
		{
			$model->attributes=$_POST;
			if($model->save()){
				Yii::app()->user->setFlash("message","专业编辑成功！");
				$url=isset($_COOKIE['professionalreturnurl'])?$_COOKIE['professionalreturnurl']:array("index");
				$this->redirect($url);
			}else{
				Yii::app()->user->setFlash("message","专业编辑失败！");
			}
		}

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
		$criteria->addCondition("p_isdel =1 ");
		$newmodel=new Professional;
		foreach($_GET as $key=>$val){$val = addslashes($val);
			if($key=="p_pid"&&$val)$criteria->addCondition("p_pid  = '{$val}' ");
			if($key=="p_name"&&$val&&$val!="专业名称..")$criteria->addCondition("p_name  regexp '{$val}' ");
		}
		if(isset($_POST['p_pid'])&&$_POST['p_pid']&&isset($_POST['p_name'])&&$_POST['p_name']&&isset($_POST['p_code'])&&$_POST['p_code']){
			$newmodel->attributes=$_POST;
			if($newmodel->save()){
						Yii::app()->user->setFlash("message","专业 添加成功！");
						$url=isset($_COOKIE['professionalreturnurl'])?$_COOKIE['professionalreturnurl']:array("index");
						$this->redirect($url);
					}else{
						Yii::app()->user->setFlash("message","专业添加失败！");
					}
		}
		
		$orderArr=array(
			"ku"=>"p_pid asc",
			"kd"=>"p_pid desc",
		);
		$order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"";
		$pageSize=isset($_COOKIE['p_pagesize'])?$_COOKIE['p_pagesize']:"20";
		setcookie("professionalreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		
		$dataProvider =  new CActiveDataProvider("Professional", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>$pageSize
						),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'newmodel'=>$newmodel,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Professional('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Professional']))
			$model->attributes=$_GET['Professional'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Professional the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Professional::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Professional $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='professional-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionDelall()
	 {
	
	   if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
	   { 
			$criteria= new CDbCriteria;
			
			$count =Professional::model()->updateAll(array('p_isdel'=>'2'),"p_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	 }
     public function actionStatusall()
	 {
	   if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel']&&isset($_POST['status'])&&$_POST['status'])
	   { 
            $status = $_POST['status'] == "1" ? "2" : "1";
			$criteria= new CDbCriteria;
			$count =Professional::model()->updateAll(array('p_status'=>$status),"p_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	 }
}
