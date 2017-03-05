<?php

class PapermController extends Controller
{
	public $layout='admin';
    
    
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
				'actions'=>array('index','view','add','edit','delall','changestatus'),
				'users'=>User::model()->getManage(4),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    /*
     *试卷列表
    */
	public function actionIndex()
	{
        $criteria=new CDbCriteria;
        $criteria->select="e_id,e_name,e_btime,e_etime,e_use";
        $criteria->addCondition("e_isdel=1");
        
        if(isset($_GET['e_cat'])&&$_GET['e_cat']==1){
            $criteria->addCondition("e_cat  = '{$_GET['e_cat']}' ");
        }elseif(isset($_GET['e_cat'])&&$_GET['e_cat']==2){
            $criteria->addCondition("e_cat  like '%2,%' ");
        }
        
        if(isset($_GET['e_name'])&&$_GET['e_name']!=''){
            $criteria->addCondition("e_name  like '%{$_GET['e_name']}%' ");
        }
        $pageSize=isset($_COOKIE['e_pagesize'])?$_COOKIE['e_pagesize']:"20";
        $dataProvider =  new CActiveDataProvider("Exampaper", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>$pageSize
						),
		));     
                
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			// 'model'=>$model,
		));
	}
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
	public function actionAdd()
	{
		$model=new Exampaper;
        $model=$this->formformat($model);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
       
        $model->e_btime=$model->e_btime?date('Ymd',$model->e_btime):'';
        $model->e_etime=$model->e_etime?date('Ymd',$model->e_etime):'';
            

		$this->render('add',array(
			'model'=>$model,
		));
	}
    
    /*
    *修改试卷
    *
    */
	public function actionEdit($id)
	{
        $model=$this->loadModel($id);
        $model=$this->formformat($model);
        $model->e_btime=$model->e_btime?date('Ymd',$model->e_btime):'';
        $model->e_etime=$model->e_etime?date('Ymd',$model->e_etime):'';
       
		$this->render('edit',array(
			'model'=>$model,
        ));
	}
    
    /*
    *赋值Model，并进行错误判断
    */
    public function formformat($model){
        if($_POST)
        {
            $dosave = true;
            $model->attributes=$_POST;
            $model->validate();
            $array=array();
            foreach($_POST['tkclvalue'] as $key=>$val){
                $array[$key]['tkclvalue']=$val;
                $array[$key]['tkcllevel']=$_POST['tkcllevel'][$key];
                $array[$key]['tkclknowName']=$_POST['tkclknowName'][$key];
                $array[$key]['tkcltk']=$_POST['tkcltk'][$key];
                $array[$key]['tkcltkj']=$_POST['tkcltkj'][$key];
            }
            if($array){
                $model->e_pstrategy=serialize($array);
            }else{
                $dosave=false;
                $model->addError('e_pstrategy','请添加试题策略');
            }
           
            //试卷类型
            if($model->e_cat == 2){
                $model->e_cat = $model->e_cat.",".$_POST['hcat'];
                if(!is_numeric($_POST['hcat'])){
                    $dosave = false;
                    $model->addError('e_cat','请填写随机试卷数目，且试卷数目为正整数');
                }
            }
            $model->e_btime=strtotime($model->e_btime);
            $model->e_etime=strtotime($model->e_etime);
            
            //考试计时选项
            if($model->e_timecat == 3){
                $model->e_timecat = $model->e_timecat.",".$_POST['timecat'];
                if(!is_numeric($_POST['timecat'])){
                    $dosave = false;
                    $model->addError('e_timecat','请填写答题时间，且答题时间为正整数');
                }
            }
            
            //防舞弊
            $e_treap = array();
            $e_treap[0] = isset($_POST['e_treap1'])&&$_POST['e_treap1'] == 1?'1':'0';
            $e_treap[1] = isset($_POST['e_treap2'])&&$_POST['e_treap2'] == 2?'1':'0';
            if(isset($_POST['e_treap3'])&&$_POST['e_treap3'] == 1){
                $e_treap[2] = '1';     
                $e_treap[3] = '0';
            }elseif(isset($_POST['e_treap3'])&&$_POST['e_treap3'] == 2){
                $e_treap[2] = '0';                
                $e_treap[3] = '1'.",".$_POST['e_treap4'];
                if(!is_numeric($_POST['e_treap4'])){
                    $dosave = false;
                    $model->addError('e_treap','请填写移出试卷次数，且移出试卷次数为正整数');
                }
            }else{
                $e_treap[2] = '0';                
                $e_treap[3] = '0';
            }
            $model->e_treap = serialize($e_treap);
            
            //考试安全
            $e_tsecurity = array();
            $e_tsecurity[0] = isset($_POST['e_tsecurity1'])&&$_POST['e_tsecurity1'] == 1?'1':'0';
            $e_tsecurity[1] = isset($_POST['e_tsecurity2'])&&$_POST['e_tsecurity2'] == 1?'1':'0';
            $model->e_tsecurity = serialize($e_tsecurity);

            //试卷安全
            if($model->e_esecurity == 3){
                $model->e_esecurity = $model->e_esecurity.','.$_POST['e_esecurity3'];
                if(!is_numeric($_POST['e_esecurity3'])){
                    $dosave = false;
                    $model->addError('e_esecurity','请填写自动保存试卷时间，且自动保存时间为正整数');
                }
            }
            
            //题型与分数设置
            if($model->e_scoreset == 1){
                $model->e_scoreset = $model->e_scoreset.",".$_POST['scoreset'];
                if(!is_numeric($_POST['scoreset'])){
                    $dosave = false;
                    $model->addError('e_scoreset','请填写试卷总分，且试卷总分为正整数');
                }
            }  
            
            if($dosave&&$model->save())
            {
				$this->redirect(array('view','id'=>$model->e_id));
            }          
        }
       
        return $model;
    }
    
    public function actionDelall()
	{
		
	    if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
        {
			$tid=isset($_POST['tid'])&&in_array($_POST['tid'],array(1,2))?$_POST['tid']:"2";
			$count =Exampaper::model()->updateAll(array('e_isdel'=>$tid),"e_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	    }
	    else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}
     
    public function actionChangestatus()
	{
		
	    if (Yii::app()->request->isPostRequest&&isset($_POST['id'])&&$_POST['id'])
        {
			$model=$this->loadModel($_POST['id']);
            if($model->e_use == 1){
                $tid = 2;
            }else{
                $tid = 1;
            }
			$count =Exampaper::model()->updateAll(array('e_use'=>$tid),"e_id = {$_POST['id']}"); 
			if($count>0){  
			   echo "ok";  
			}
	    }
	    else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}
     
    public function loadModel($id)
	{
		$model=Exampaper::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
    
	public function actionContent()
	{
		$this->render('content');
	}


	public function actionMark()
	{
		$this->render('mark');
	}
	public function actionAddexcel()
	{
		$this->render('addexcel');
	}

	
}