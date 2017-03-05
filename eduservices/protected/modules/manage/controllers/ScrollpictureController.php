<?php

class ScrollpictureController extends Controller
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
        $model=new Scrollpicture;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Scrollpicture']))
        {
            $model->attributes=$_POST['Scrollpicture'];
            if($model->validate()){
                if(isset($_FILES['Scrollpicture']["name"]["sp_picture"])&&!empty ($_FILES['Scrollpicture']["name"]["sp_picture"])){
                    $originfilename = $_FILES['Scrollpicture']['name']['sp_picture']; //文件名
                    $fileext = strtolower(substr($originfilename,strrpos($originfilename,'.'))); //后缀名
                    //验证文件格式是否正确
                    $fileName = "advertisement/".time().rand("00", "99").$fileext;
                    $targetFile =  PIC_PATH.$fileName;
                    $tempFile = $_FILES['Scrollpicture']['tmp_name']['sp_picture'];
                    move_uploaded_file($tempFile,$targetFile);
                    $model->sp_picture = PIC_URL.$fileName;
                    if($model->save())
                        $this->redirect(array('view','id'=>$model->sp_id));

                }else{
                    $model->addError("sp_picture","不能为空") ;
                }
            }
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

        if(isset($_POST['Scrollpicture']))
        {
            $oldpic = $model->sp_picture;
            $model->attributes=$_POST['Scrollpicture'];

            if($model->validate()){
                if(isset($_FILES['Scrollpicture']["name"]["sp_picture"])&&!empty ($_FILES['Scrollpicture']["name"]["sp_picture"])){
                    //删除旧图片
                    @unlink(PIC_PATH.$oldpic);
                    $originfilename = $_FILES['Scrollpicture']['name']['sp_picture']; //文件名
                    $fileext = strtolower(substr($originfilename,strrpos($originfilename,'.'))); //后缀名
                    //验证文件格式是否正确
                    $fileName = "advertisement/".time().rand("00", "99").$fileext;
                    $targetFile =  PIC_PATH.$fileName;
                    $tempFile = $_FILES['Scrollpicture']['tmp_name']['sp_picture'];
                    move_uploaded_file($tempFile,$targetFile);
                    $model->sp_picture = PIC_URL.$fileName;
                }else{
                    $model->sp_picture = $oldpic;
                }
                $model->update();
                $this->redirect(array('view','id'=>$model->sp_id));
            }
        }

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
            $model = $this->loadModel();
            if($model->sp_picture){
                @unlink(PIC_PATH.$model->sp_picture);
            }
            $model->delete();

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
        $dataProvider=new CActiveDataProvider('Scrollpicture', array(
                'criteria'=>array("order"=>"sp_order")
            ));
        $this->render('index',array(
                'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Scrollpicture('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Scrollpicture']))
            $model->attributes=$_GET['Scrollpicture'];

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
                $this->_model=Scrollpicture::model()->findbyPk($_GET['id']);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='scrollpicture-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
