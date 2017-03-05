<?php

class OrganizationController extends Controller
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view','delall','edit','index'),
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
		$model=new Organization;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Organization']))
		{
			$model->attributes=$_POST['Organization'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->o_id));
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

		if(isset($_POST['Organization']))
		{
			$model->attributes=$_POST['Organization'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->o_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionEdit($id)
	{
		$model=$this->loadModel($id);
			$type=isset($_GET['type'])&&$_GET['type']?$_GET['type']:"";
			switch ($type)
			{
			case "jigou":
				$show="机构";
				break;  
			case "baomingdian":
				$show="报名点";
				break;
			default:
			  $show="学习中心";
			}
		if($_POST)
		{
			$model->attributes=$_POST;
			if($model->save()){
				Yii::app()->user->setFlash("message","{$show} 编辑成功！");
				$url=isset($_COOKIE['organreturnurl'])?$_COOKIE['organreturnurl']:array("index",'type'=>$type);
				$this->redirect($url);
			}else{
				Yii::app()->user->setFlash("message","{$show} 编辑失败！");
			}
		}

		$this->render('edit',array(
			'model'=>$model,
			'show'=>$show,
			'type'=>$type,
		));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria;
		$type=isset($_GET['type'])&&$_GET['type']?$_GET['type']:"";
		if(!in_array($type,array("jigou",'baomingdian','')))throw new CHttpException(404,'您访问的页面不存在。');
		switch ($type)
		{
		case "jigou":
			$PidArr=Organization::model()->getAlljigouId();
			if($PidArr)$criteria->addCondition("o_pid in(".join(",",$PidArr).") ");
			else$criteria->addCondition("o_pid ='null'");
			$show="机构";
			break;  
		case "baomingdian":
			$PidArr=Organization::model()->getAllbaomingdianId();
			if($PidArr)$criteria->addCondition("o_pid in(".join(",",$PidArr).") ");
			else$criteria->addCondition("o_pid ='null'");
			$show="报名点";
			break;
		default:
		  $criteria->addCondition("o_pid in(0) ");
		  $show="学习中心";
		}
		 $criteria->addCondition("o_isdel =1 ");
		$newmodel=new Organization;
		if(isset($_POST['o_pid'])&&($_POST['o_pid']||$_POST['o_pid']=='0')&&isset($_POST['o_name'])&&$_POST['o_name']&&isset($_POST['o_code'])){
			
				$check=true;
				$newmodel->o_name=$_POST['o_name'];
				$newmodel->o_code=$_POST['o_code'];
				$newmodel->o_pid=$_POST['o_pid'];
                $newmodel->o_zone=isset($_POST['o_zone'])&&$_POST['o_zone']?$_POST['o_zone']:"";
				if($_POST['o_pid']!="0"){
					if(Organization::model()->count("o_id ='{$_POST['o_pid']}'")=='0'){
						Yii::app()->user->setFlash("message","添加失败:内部错误");
						$check=false;
						break;
					}
				}
				if($check){
					if($newmodel->save()){
						Yii::app()->user->setFlash("message","{$show} 添加成功！");
						$url=isset($_COOKIE['organreturnurl'])?$_COOKIE['organreturnurl']:array("index",'type'=>$type);
						$this->redirect($url);
					}else{
						Yii::app()->user->setFlash("message","{$show} 添加失败！");
					}
				}
		}
		if(isset($_GET['o_name'])&&$_GET['o_name']&&$_GET['o_name']!="{$show}名称..")$criteria->addCondition("o_name  regexp '{$_GET['o_name']}' ");	
		if(isset($_GET['s_zhongxin'])&&$_GET['s_zhongxin']){
			if(isset($_GET['baomingdian'])&&$_GET['baomingdian']){
				$criteria->addCondition("o_pid = '{$_GET['baomingdian']}'");
			}else{
				$BMArr=array();
				$Pmodel=Organization::model()->findAll("o_pid='{$_GET['s_zhongxin']}' and o_isdel=1");
				foreach($Pmodel as $val)$BMArr[]=$val->o_id;
				// $BMArr=Organization::model()->getOrByPid($_GET['s_zhongxin']);
				// print_r($BMArr);
				if($BMArr)$criteria->addCondition("o_id in(".join(",",$BMArr).") ");
			}	
		}
		$orderArr=array(
			"ku"=>"o_name asc",
			"kd"=>"o_name desc",
		);
		$order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"";
		$pageSize=isset($_COOKIE['o_pagesize'])?$_COOKIE['o_pagesize']:"20";
		setcookie("organreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		
		$dataProvider =  new CActiveDataProvider("Organization", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>$pageSize
						),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'newmodel'=>$newmodel,
			'show'=>$show,
			'type'=>$type,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Organization('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Organization']))
			$model->attributes=$_GET['Organization'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Organization the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Organization::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Organization $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='organization-form')
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
			
			$count =Organization::model()->updateAll(array('o_isdel'=>'2'),"o_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	 }
}
