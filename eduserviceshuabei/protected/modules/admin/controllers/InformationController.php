<?php

class InformationController extends Controller
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
            array('allow',
                    'actions'=>array('index','view'),
                    'users'=>array("@")
            ),
            array('allow',
                    'actions'=>array('delall','add','edit'),
                    'users'=>User::model()->getManage(4)
            ),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    //新闻公告管理列表
    public function actionIndex()
	{
		$criteria=new CDbCriteria;
        $criteria->select='i_id,i_class,i_label,i_title,i_bool,i_submitdate,i_isdel';
        //搜索
        foreach($_GET as $key=>$val){
            $val = addslashes($val);
            if($key=="i_id"&&$val&&$val!="ID..")$criteria->addCondition("i_id  regexp '{$val}' ");
            if($key=="i_label"&&$val&&$val!="标签..")$criteria->addCondition("i_label  regexp '{$val}' ");
            if($key=="i_title"&&$val&&$val!="标题..")$criteria->addCondition("i_title  regexp '{$val}' ");
            if($key=="i_bool"&&($val||$val==="0")){
                $criteria->addCondition("i_bool  = '{$val}' ");
                if(!array_key_exists($val,Information::$isbool)) throw new CHttpException(404,'您访问的页面不存在。');
            }
        }
        $criteria->addCondition("i_class = '5' ");
        if(Yii::app()->user->role=="4"){
            $isdelStr=isset($_GET['type'])&&$_GET['type']=='2'?'2':"1";
            $criteria->addCondition("i_isdel  = '{$isdelStr}' ");
        }else{
            $criteria->addCondition("i_isdel = '1' ");
        }
        $orderArr=array(
            "tmu"=>"i_bool asc",
            
            "tmd"=>"i_bool desc",
        );
        $order=isset($_GET['order'])?$_GET['order']:"";
        $criteria->order=isset($orderArr[$order])?$orderArr[$order]:"i_bool desc";
        $pageSize=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20";
        setcookie("ggnewslistreturnurl",$_SERVER['REQUEST_URI'],0,"/");
        $dataProvider = new CActiveDataProvider("Information",array(
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
     *通过ID新闻公告查看详情查看
     */
    public function actionView($id)
    {
        $model=$this->loadModel($id);
        if($model->i_class!=5)throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        if($model->i_isdel==2 && Yii::app()->user->role!=4) throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        $model->i_click=$model->i_click?$model->i_click+1:1;
        $model->update();
        $this->render("view",array(
            'model'=>$model,
        ));
    }
    /**
     *添加一条新闻公告
     */
    public function actionAdd()
    {
        $model=new Information;
        $model->i_class = "5";//只新增公告类
        if($_POST){
            $model->attributes = $_POST;
            $model->setAttribute("i_con",$_POST['i_con']);
            $model->setAttribute("i_pic",$_POST['i_pic']);
            $model->i_form = User::model()->getUserName(Yii::app()->user->id);
            //User::model()->getUserName($model->sa_proposerid)
            $model->i_submitdate=time();
            $model->i_updatetime=time();
        // print_r($model->attributes);exit;
            if($model->save()){
                Yii::app()->user->setFlash("message","公告添加成功");
                $this->redirect(array("information/view","id"=>$model->i_id));
            }else{
                Yii::app()->user->setFlash("message","公告发布失败");
            }
        }
        $this->render('add',array(
            'model'=>$model,
        ));
    }
    /**
     *通过$id来修改当前公告新闻
     */
    public function actionEdit($id)
    {
        $model = $this->loadModel($id);
        if(Yii::app()->user->role!=4) throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        if($_POST){
            $model->attributes=$_POST;
            $model->i_editform = User::model()->getUserName(Yii::app()->user->id);
            $model->i_updatetime = time();
            $model->i_isdel=1;
            $model->setAttribute("i_pic",$_POST['i_pic']);
            if($model->save()){
                Yii::app()->user->setFlash("message","修改成功");
                $this->redirect(array("information/view","id"=>$model->i_id));
            }else{
                Yii::app()->user->setFlash("message","修改失败");
            }
        }
        $this->render('edit',array(
            'model'=>$model,
        ));
    }
    public function loadModel($id)
    {
        $model = Information::model()->findByPk($id,"i_class = '5'");
        if($model===null)
            throw new CHttpException(404,'您访问的页面不存在。');
        return $model;
    }    
    /**
	 * 批量回收站删除
	 */
	public function actionDelall()
	{
	   if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
	   {
			/*1:删除  2:恢复*/
            $tid=isset($_POST['tid'])&&in_array($_POST['tid'],array(1,2))?$_POST['tid']:"2";
            
            
			$criteria= new CDbCriteria;
			$criteria->addInCondition('user_id', $_POST['selectdel']);
            $str=Yii::app()->user->role==4?"":"and i_isdel = 1 and i_class = 5 ";
            $count =Information::model()->updateAll(array('i_isdel'=>$tid),"i_id in ( ".join(",",$_POST['selectdel'])." ) {$str}"); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}
     

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}