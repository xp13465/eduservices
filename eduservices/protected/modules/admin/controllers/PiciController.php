<?php

class PiciController extends Controller
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
				'actions'=>array('delall','statusall','index'),
				'users'=>User::model()->getManage(4),
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
		$criteria=new CDbCriteria;
		$newmodel=new Pici;
		if(isset($_POST['p_value'])&&$_POST['p_value']){
				$newmodel->p_value=$_POST['p_value'];
                $_POST['p_value']=addslashes($_POST['p_value']);
                $num=Pici::model()->count("p_value ='{$_POST['p_value']}' and p_isdel=1");
                if(!$num){
                    if($newmodel->save()){
                        Yii::app()->user->setFlash("message","批次添加成功！");
                        
                    }else{
                        Yii::app()->user->setFlash("message","批次添加失败！");

                    }
                }else{
                    
                    Yii::app()->user->setFlash("message","批次已存在 ！");
                }
                $url=isset($_COOKIE['picireturnurl'])?$_COOKIE['picireturnurl']:array("index");
                $this->redirect($url);
				
		}
        $criteria->addCondition("p_isdel=1");
		$criteria->order="p_id desc";
		$pageSize=isset($_COOKIE['pc_pagesize'])?$_COOKIE['pc_pagesize']:"20";
		
		$dataProvider =  new CActiveDataProvider("Pici", array(
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pici the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pici::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pici $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Pici-form')
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
			
			$count =Pici::model()->updateAll(array('p_isdel'=>'2'),"p_id in ( ".join(",",$_POST['selectdel'])." ) "); 
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
			
			$count =Pici::model()->updateAll(array('p_status'=>$status),"p_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	 }
}
