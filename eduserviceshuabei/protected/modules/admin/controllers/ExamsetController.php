<?php

class ExamsetController extends Controller
{

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('delall','index','edit'),
				'users'=>User::model()->getManage(4)
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    
    /**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='admin';
    
	public function actionIndex()
	{
		$criteria=new CDbCriteria;
        $criteria->select = "q_id,q_name,q_pid";
		$type=isset($_GET['type'])&&$_GET['type']?$_GET['type']:"";
		if(!in_array($type,array("second",'')))throw new CHttpException(404,'您访问的页面不存在。');
		switch ($type)
		{
		case "second":
			$PidArr=Questions::model()->getAlltikujiId();
			if($PidArr)$criteria->addCondition("q_pid in(".join(",",$PidArr).") ");
			else$criteria->addCondition("q_pid ='null'");
			$show="题库";
			break;  
		default:
		  $criteria->addCondition("q_pid in(0) ");
		  $show="题库集";
		}
		 $criteria->addCondition("q_isdel =1 ");
		$newmodel=new Questions;
		if(isset($_POST['q_pid'])&&($_POST['q_pid']||$_POST['q_pid']=='0')&&isset($_POST['q_name'])&&$_POST['q_name']){
				$check=true;
				$newmodel->q_name=$_POST['q_name'];
				$newmodel->q_type=$_POST['q_type'];
				$newmodel->q_pid=$_POST['q_pid'];
				if($_POST['q_pid']!="0"){
					if(Questions::model()->count("q_id ='{$_POST['q_pid']}'")=='0'){
						Yii::app()->user->setFlash("message","添加失败:内部错误");
						$check=false;
						break;
					}
				}
				if($check){
					if($newmodel->save()){
						Yii::app()->user->setFlash("message","{$show} 添加成功！");
						$url=isset($_COOKIE['questionreturnurl'])?$_COOKIE['questionreturnurl']:array("index",'type'=>$type);
						$this->redirect($url);
					}else{
						Yii::app()->user->setFlash("message","{$show} 添加失败！");
					}
				}
		}
		if(isset($_GET['q_name'])&&$_GET['q_name']&&$_GET['q_name']!="{$show}名称..")$criteria->addCondition("q_name  regexp '{$_GET['q_name']}' ");	
		
        if(isset($_GET['q_examset'])&&$_GET['q_examset']){
			
            $BMArr=array();
            $Pmodel=Questions::model()->findAll("q_pid='{$_GET['q_examset']}' and q_isdel=1");
            foreach($Pmodel as $val)$BMArr[]=$val->q_id;
            if($BMArr){$criteria->addCondition("q_id in(".join(",",$BMArr).") ");}
            else{$criteria->addCondition("q_id = '' ");}
		}
		$orderArr=array(
			"ku"=>"q_name asc",
			"kd"=>"q_name desc",
		);
		$order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"";
		$pageSize=isset($_COOKIE['q_pagesize'])?$_COOKIE['q_pagesize']:"20";
		setcookie("questionreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		
		$dataProvider =  new CActiveDataProvider("Questions", array(
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
    
    public function actionEdit($id)
	{
		$model=$this->loadModel($id);
			$type=isset($_GET['type'])&&$_GET['type']?$_GET['type']:"";
			switch ($type)
			{
			case "second":
				$show="题库";
				break;
			default:
			  $show="题库集";
			}
		if($_POST)
		{
			$model->attributes=$_POST;
			if($model->save()){
				Yii::app()->user->setFlash("message","{$show} 编辑成功！");
				$url=isset($_COOKIE['questionreturnurl'])?$_COOKIE['questionreturnurl']:array("index",'type'=>$type);
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
    
    public function loadModel($id)
	{
		$model=Questions::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
    
    public function actionDelall()
	 {
	 
	   if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
	   {
			$criteria= new CDbCriteria;
			
			$count =Questions::model()->updateAll(array('q_isdel'=>'2'),"q_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	 }

	
}