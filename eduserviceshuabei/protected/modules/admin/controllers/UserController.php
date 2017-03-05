<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='admin';

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
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model=$this->loadModel(Yii::app()->user->id);
		
		if(isset($_POST['type'])&&($_POST['type']=="password"||$_POST['type']=="info")){
		
			if($_POST['type']=="info"){
				$model->attributes=$_POST;
				if($model->save()){
					if($model->user_headimg&&!strpos($model->user_headimg,"/UH/")){
						$checkHD=Files::model()->SaveFile($model->user_headimg,$model->user_name,7,$model->user_id);
						if($checkHD){
							$model->user_headimg=$checkHD;
							$model->save();
						}
					}
					Yii::app()->user->setFlash("message","个人信息修改成功");
					$this->redirect(DOMAIN."/admin/user/view.html#info");
				}else{
					Yii::app()->user->setFlash("message","个人信息修改失败");
				}
				
			
			}elseif($_POST['type']=="password"){
				if(md5($_POST['oldpwd'])==$model->user_pwd){
					if($_POST['newpwd']==$_POST['renewpwd']){
						$model->user_pwd=md5($_POST['newpwd']);
						if($model->save()){
							Yii::app()->user->setFlash("message","密码修改成功");
							$this->redirect(DOMAIN."/admin/user/view.html#password");
						}else{
							Yii::app()->user->setFlash("message","密码修改失败");
						}
					}else{
						$model->addError("repwd","重复密码与新密码不匹配");
					}
					
				}else{
					$model->addError("user_pwd","原密码不正确");
				}
				
			}
		}
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		if($this->_model===null)
		{
			if(isset($id))
				$this->_model=User::model()->findbyPk($id);
			if($this->_model===null)
				throw new CHttpException(404,'您访问的页面不存在。');
		}
		return $this->_model;
	}


	
}
