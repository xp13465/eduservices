<?php
class SeotkdController extends Controller
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {

        $model=new Seotkd;

        // Uncomment the following line if AJAX validation is needed
         //$this->performAjaxValidation($model);

        if(isset($_POST['Seotkd']))
        {
            $model->attributes=$_POST['Seotkd'];
            if($model->save())
                $this->redirect(array('index'));
        }

        $this->render('create',array(
            'model'=>$model,
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

        if(isset($_POST['Seotkd']))
        {
            $model->attributes=$_POST['Seotkd'];
            if($model->save())
                $this->redirect(array('index'));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'stkd_id desc';
		$dataProvider=new CActiveDataProvider('Seotkd',array(
            'criteria'=>$criteria,
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider
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
                $this->_model=Seotkd::model()->findbyPk($_GET['id']);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='seotkd-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(isset($_GET['id']))
		{
			$model = $this->loadModel();
            if($model->delete())
                $this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}
}
?>
