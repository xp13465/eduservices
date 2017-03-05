<?php

class SchoolController extends Controller
{
    public $layout='main';
	public function actionIndex($id='')
	{
        $model=$this->loadModel($id);
		$this->render('index',array(
            'model'=>$model,
        ));
	}
    public function loadModel($id)
	{
		$model=$id?Schoolabout::model()->findByPk($id):Schoolabout::model()->find();
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
}