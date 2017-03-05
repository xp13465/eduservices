<?php

class ManagemenuController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Managemenu;
        $searchModel=new Managemenu('search');
		$searchModel->unsetAttributes();  // clear any default values
		if(isset($_GET['Managemenu']))
			$searchModel->attributes=$_GET['Managemenu'];
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Managemenu']))
		{
			$model->attributes=$_POST['Managemenu'];
            $model->m_role=isset($_POST['Managemenu']['m_role'])&&is_array($_POST['Managemenu']['m_role'])?join(",",$_POST['Managemenu']['m_role']):"";
            if($model->save()){
                // if(isset ($_POST['auto_to_authitem']) && $_POST['auto_to_authitem']){
                    // $name = strtolower(trim($model->m_link));
                    // $auth = Yii::app()->getAuthManager();
                    // if( ($auth->getAuthItem($name)===NULL) )
                        // $auth->createOperation($name,$model->m_name);
                // }
                // Manageuser::model()->clearUserMenuCache();
				$this->redirect(array('view','id'=>$model->m_id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
            'searchModel'=>$searchModel
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Managemenu']))
		{
			$model->attributes=$_POST['Managemenu'];
            $model->m_role=isset($_POST['Managemenu']['m_role'])&&is_array($_POST['Managemenu']['m_role'])?join(",",$_POST['Managemenu']['m_role']):"";
            // print_r($model->m_role);exit;
            if($model->save())
				$this->redirect(array('view','id'=>$model->m_id));
		}
        $model->m_role=$model->m_role?explode(",",$model->m_role):"";
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Managemenu');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Managemenu('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Managemenu']))
			$model->attributes=$_GET['Managemenu'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Managemenu::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'您访问的页面不存在。');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='managemenu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
