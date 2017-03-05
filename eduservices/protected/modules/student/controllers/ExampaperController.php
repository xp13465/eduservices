<?php

class ExampaperController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $layout = "student";

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $criteria = new CDbCriteria;
        $criteria->select = "ea_id,ea_pkid,ea_examid,ea_stime,ea_etime,ea_status,ea_isdel";
        $Smodel=Students::model()->findByPk(Yii::app()->user->id);
        $zyModel=Professional::model()->findByPk($Smodel->s_baokaozhuanye);
        $criteria->addCondition("ea_pkid='{$Smodel->s_pc}'");
        $criteria->addCondition('ea_status=1');
        $criteria->addCondition('ea_isdel=1');
        $pageSize=isset($_COOKIE['sj_pagesize'])?$_COOKIE['sj_pagesize']:"10";
		$dataProvider=new CActiveDataProvider('Examarrangement',array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>$pageSize
						),
        ));         
		$this->render('index',array(
            'Smodel'=>$Smodel,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Exampaper the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Exampaper::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Exampaper $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='exampaper-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
