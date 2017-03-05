<?php

class ExamarrangementController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('delall','index','statusall','edit'),
				'users'=>User::model()->getManage(4)
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	

	
    public function actionEdit($id)
    {    
        $model = $this->loadModel($id);
        if($_POST)
		{
            $model->attributes=$_POST;
            $model->ea_examid=isset($_POST['ea_examid'])&&$_POST['ea_examid']?$_POST['ea_examid']:0;
            $model->ea_stime=strtotime($_POST['ea_stime'].$_POST['shour'].$_POST['smintue']."00");
            $model->ea_etime=strtotime($_POST['ea_stime'].$_POST['ehour'].$_POST['emintue']."00");
            if($model->save()){
				Yii::app()->user->setFlash("message","排考编辑成功！");
				$url=isset($_COOKIE['examarrangementreturnurl'])?$_COOKIE['examarrangementreturnurl']:array("index");
				$this->redirect($url);
			}else{
                Yii::app()->user->setFlash("message","排考编辑失败！");
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
        $criteria->addCondition(' ea_isdel = 1 ');
        $newmodel=new  Examarrangement;
        if(isset($_POST['pcid'])&&$_POST['pcid']&&isset($_POST['e_btime'])&&$_POST['e_btime']){
         print_r($_POST);
                $newmodel->ea_pkid=$_POST['pcid'];
                $newmodel->ea_examid=isset($_POST['examid'])&&$_POST['examid']?$_POST['examid']:0;
                $newmodel->ea_stime=strtotime($_POST['e_btime'].$_POST['shour'].$_POST['sminute']."00");
                $newmodel->ea_etime=strtotime($_POST['e_btime'].$_POST['ehour'].$_POST['eminute']."00");
                if($newmodel->save()){
                    Yii::app()->user->setFlash("message","排考添加成功！");
                }else{
                    Yii::app()->user->setFlash("message","排考添加失败！");
                }
                $url=isset($_COOKIE['paikaoreturnurl'])?$_COOKIE['paikaoreturnurl']:array("index");
                $this->redirect($url);
				
		}
        $pageSize=isset($_COOKIE['ea_pagesize'])?$_COOKIE['ea_pagesize']:"20";
		$dataProvider = new CActiveDataProvider('Examarrangement',array(
                        'criteria'=>$criteria,
                        'pagination'=>array(
								'pageSize'=>$pageSize
						),
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
    
    /**
	 * 批量回收站删除
	 */
	public function actionDelall()
	{
	   if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
	   {
			$tid=isset($_POST['tid'])&&in_array($_POST['tid'],array(1,2))?$_POST['tid']:"2";
			$criteria= new CDbCriteria;
			$criteria->addInCondition('user_id', $_POST['selectdel']);
			$count =Examarrangement::model()->updateAll(array('ea_isdel'=>$tid),"ea_id in ( ".join(",",$_POST['selectdel'])." ) "); 
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
			
			$count =Examarrangement::model()->updateAll(array('ea_status'=>$status),"ea_id in ( ".join(",",$_POST['selectdel'])." ) "); 
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
	 * @return Examarrangement the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Examarrangement::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}

}
