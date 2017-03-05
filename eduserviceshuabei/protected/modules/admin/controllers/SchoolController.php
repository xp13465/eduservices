<?php

class SchoolController extends Controller
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
				'actions'=>array('admin','delete','delall','create','update','edit','index','view','inportupdateschool'),
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
		$model=new School;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['School']))
		{
			$model->attributes=$_POST['School'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->s_id));
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

		if(isset($_POST['School']))
		{
			$model->attributes=$_POST['School'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->s_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
		public function actionEdit($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if($_POST)
		{
			$model->attributes=$_POST;
			if($model->save()){
				Yii::app()->user->setFlash("message","院校编辑成功！");
				$url=isset($_COOKIE['schoolreturnurl'])?$_COOKIE['schoolreturnurl']:array("index");
				$this->redirect($url);
			}else{
				Yii::app()->user->setFlash("message","院校编辑失败！");
			}
		}

		$this->render('edit',array(
			'model'=>$model,
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
		$criteria->addCondition("s_isdel =1 ");
		$newmodel=new School;
		foreach($_GET as $key=>$val){$val = addslashes($val);
			if($key=="s_province"&&$val)$criteria->addCondition("s_province  = '{$val}' ");
			if($key=="s_name"&&$val&&$val!="院校名称..")$criteria->addCondition("s_name  regexp '{$val}' ");
		}
		if(isset($_POST['s_province'])&&$_POST['s_province']&&isset($_POST['s_name'])&&$_POST['s_name']&&isset($_POST['s_code'])&&$_POST['s_code']){
			$newmodel->attributes=$_POST;
			if($newmodel->save()){
						Yii::app()->user->setFlash("message","院校添加成功！");
						$url=isset($_COOKIE['schoolreturnurl'])?$_COOKIE['schoolreturnurl']:array("index");
						$this->redirect($url);
					}else{
						Yii::app()->user->setFlash("message","院校添加失败！");
					}
		}
		
		$orderArr=array(
			"ku"=>"p_pid asc",
			"kd"=>"p_pid desc",
		);
		$order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"";
		$pageSize=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20";
		setcookie("schoolreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		
		$dataProvider =  new CActiveDataProvider("School", array(
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new School('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['School']))
			$model->attributes=$_GET['School'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return School the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=School::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param School $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='school-form')
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
			
			$count =School::model()->updateAll(array('s_isdel'=>'2'),"s_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
        }
        else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}
    public function actionInportupdateschool()
	{
        set_time_limit(0);
        $sheetData=array();
        if (@is_uploaded_file($_FILES['upfile']['tmp_name'])){
            // print_r($_FILES);
            $ok=0;
            $uppath="./upload/"; //文件上传路径
            // print_r($_FILES);exit;
            switch ($_FILES['upfile']['type']) {//其他文件格式可以在下面增加判断
                case 'application/octet-stream' : 
                $rsz=@end(explode(".",$_FILES['upfile']['name']));
                $name=date("YmdHis_",time()).mt_rand().".".$rsz;;
                $ok=1;
                break;
                case 'application/vnd.ms-excel' : 
                $rsz=@end(explode(".",$_FILES['upfile']['name']));
                $name=date("YmdHis_",time()).mt_rand().".".$rsz;;
                $ok=1;
                break;
                case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' : 
                $rsz=@end(explode(".",$_FILES['upfile']['name']));
                $name=date("YmdHis_",time()).mt_rand().".".$rsz;;
                $ok=1;
                break;
            }
            if (@$ok!=1){
                echo "<script>alert('表格格式不正确,请重试');location.href=location.href;</script>";
                exit;
            }
            if ($_FILES['upfile']['size']>1024*1024*8){
                echo "<script>alert('表格过大,大小请小于8M');location.href=location.href;</script>";
                exit;
            }
            if($ok=="1" && $_FILES['upfile']['error']=='0'){
                if(@move_uploaded_file($_FILES['upfile']['tmp_name'],$uppath.$name)){
                    set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
                    spl_autoload_unregister(array('YiiBase','autoload'));
                    // include_once(DOCUMENTROOT."/protected/vendors/PHPExcel.php");
                    include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
                    spl_autoload_register(array('YiiBase','autoload'));  
                    
                    $inputFileName =$uppath.$name;// './kstz.xls';
                    // echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
                    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                }
             }
             
            
        }
        $seep=200;
        $this->render('inportupdateschool',array(
            'sheetData'=>$sheetData,
            'seep'=>$seep,
		));
    }
}
