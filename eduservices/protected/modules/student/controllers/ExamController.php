<?php

class ExamController extends Controller
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
			'postOnly + edit', // we only allow deletion via POST request
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
				'actions'=>array('index','view','add','edit'),
				'users'=>array('@'),
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
	public function actionAdd($id,$exid)
	{
        $num= rand(0,2000000);
        usleep($num);
        $this->layout='exam';
        //先查出试卷ID
        $sjmodel=Examarrangement::model()->findByPk($id);        
        if(($sjmodel->ea_stime-300)>time()){
            header("Content-type:text/html;charset=utf-8");
            echo "<script>alert('还没到考试时间，请稍后重试！');windown.close();</script>";
        }elseif(($sjmodel->ea_etime+600)<=time()){
            header("Content-type:text/html;charset=utf-8");
            echo "<script>alert('已过考试时间，请关闭！');windown.close();</script>";
        }
        
        
        
        $sjid=$sjmodel->ea_examid?$sjmodel->ea_examid:$exid;
        //$id即为排考id，由考试入口链接参数传入
        $user_id = Yii::app()->user->id;
        $model=$this->loadExamModel($sjid);
        if($model->e_btime<=time()&&$model->e_etime>=time()){
            if(isset($_COOKIE["examid_{$id}_{$sjid}_{$user_id}"])){
                $scoremodel=Score::model()->findByPk($_COOKIE["examid_{$id}_{$sjid}_{$user_id}"]);
                if($scoremodel===null||$scoremodel->sc_status!=0){
                    setcookie("examid_{$id}_{$sjid}_{$user_id}",'',time()-3600,"/");
                    header("Content-type:text/html;charset=utf-8");
                    echo "<script>alert('您的试卷已作废，请重新考试');window.opener.location.href=window.opener.location.href;window.close()</script>";
                    exit;
                }
            }else{
                $delcriteria = new CDbCriteria;
                $delcriteria->addCondition(" (sc_status = 0 or sc_thanswer is NULL )"); 
				$delcriteria->addCondition("sc_sid=".Yii::app()->user->id);
				$delcriteria->addCondition("sc_pkid='{$id}'");
				$delcriteria->addCondition("sc_sjid='{$sjid}'");
                Score::model()->deleteAll($delcriteria);
                
                $scoremodel=new Score;
                $scoremodel->sc_sjid=$sjid;
                $scoremodel->sc_pkid=$id;
                $scoremodel->sc_sid=Yii::app()->user->id;
                $scoremodel->sc_sdt=time();
            }
        }else{
        
            if(isset($_COOKIE["examid_{$id}_{$sjid}_{$user_id}"])){
                $scoremodel=Score::model()->findByPk($_COOKIE["examid_{$id}_{$sjid}_{$user_id}"]);
                if($scoremodel===null||$scoremodel->sc_status!=0){
                    setcookie("examid_{$id}_{$sjid}_{$user_id}",'',time()-3600,"/");
                    throw new CHttpException(404,'您访问的页面不存在。');
                }
            }else{
                if(empty($_POST)){
                    header("Content-type:text/html;charset=utf-8");
                    echo "<script>alert('考试时间已过！');window.opener.location.href=window.opener.location.href;window.close()</script>";
                    exit;
                }
            }
        }
        
        if($scoremodel->sc_ldt&&$scoremodel->sc_ldt<=time()){
            setcookie("examid_{$id}_{$sjid}_{$user_id}",'',time()-3600,"/");
            header("Content-type:text/html;charset=utf-8");
            echo "<script>alert('您已被强制交卷！');window.opener.location.href=window.opener.location.href;window.close()</script>";
            exit;
        }
        
        $ENDArr=explode(",",$model->e_timecat);
        // if(empty($_POST)){
            if($ENDArr[0]==3){
                if(($sjmodel->ea_etime-time())<($ENDArr[1]*60)-$scoremodel->sc_time){
                    $sytime=$sjmodel->ea_etime-time()>0?$sjmodel->ea_etime-time():0;
                    $scoremodel->sc_time=($ENDArr[1]*60)-$sytime;
                    // echo $scoremodel->sc_time;exit;
                }
            }
        // }
		if($_POST)
		{
            $userid = Yii::app()->user->id;
            $etname = "examtime_{$_GET['id']}_{$scoremodel->sc_sjid}_{$userid}";
            if(!isset($_COOKIE[$etname])||$_COOKIE[$etname]==''){
            }elseif($scoremodel->sc_time>=$_COOKIE[$etname]){
                $_COOKIE[$etname] = $scoremodel->sc_time;
            }elseif($scoremodel->sc_time<$_COOKIE[$etname]){
                $scoremodel->sc_time=$_COOKIE[$etname];
            }
            
            if(isset($_POST['selt'])){
                $TMARR=unserialize($scoremodel->sc_thanswer);
                $num=0;
                foreach($TMARR as $tkid => $tkArr){
                    foreach($tkArr as $typeid => $tmArr){
                        foreach($tmArr as $key=>$val){
                            foreach($val as $kss=>$vss){
                                $data=Topic::model()->findByPk($vss['tid'])->attributes;
                                $t_answer='';
                                if(isset($_POST['selt'][$kss])&&$_POST['selt'][$kss]){
                                    $t_answer=$TMARR[$tkid][$typeid][$key][$kss]['answer']=is_array($_POST['selt'][$kss])?join(",",$_POST['selt'][$kss]):$_POST['selt'][$kss];
                                }
                                if($data['t_answer']==$t_answer){
                                    $TMARR[$tkid][$typeid][$key][$kss]['status']=1;
                                    $TMARR[$tkid][$typeid][$key][$kss]['sfs']=$data['t_level'];
                                    $num+=$data['t_level'];
                                }
                            }
                        }
                    }
                }
                $scoremodel->sc_kgmark=$num;    
                $scoremodel->sc_thanswer=serialize($TMARR);
                
            }
            $alertStr=$scoremodel->sc_kgmark>=$model->e_passs?"考试已合格":"考试不合格，请重新参加考试！";
            $scoremodel->sc_status=1;
            $scoremodel->sc_ldt=time();
			if($scoremodel->save()){
                setcookie("examid_{$id}_{$sjid}_{$user_id}",'',time()-3600,"/");
                setcookie("sc_thanswer_{$id}_{$sjid}_{$user_id}",'',time()-3600);
                setcookie("examtime_{$id}_{$sjid}_{$user_id}",'',time()-3600);
                // $this->redirect(array('view','id'=>$scoremodel->sc_id));
                // print_r($_COOKIE);exit;
                header("Content-type:text/html;charset=utf-8");
                echo "<script>alert('试卷提交成功！{$alertStr}');window.opener.location.href=window.opener.location.href;window.close()</script>";
                exit;
            }else{
                // print_r($model->errors);
            }
				// $this->redirect(array('view','id'=>$model->sc_id));
		}

       
        
		$this->render('create',array(
			'model'=>$model,
            'sjmodel'=>$sjmodel,
            'scoremodel'=>$scoremodel,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id)
	{
        $num= rand(0,200)/100;
        sleep($num);       
        $this->layout='exam';
        $scoremodel=Score::model()->findByPk($id);
        if($scoremodel===null){
            echo "noexam";exit;
        }
		$model=$this->loadExamModel($scoremodel->sc_sjid);
        if($scoremodel->sc_ldt&&$scoremodel->sc_ldt<time()){
            echo "timeover";
            exit;
        }
        if($scoremodel->sc_time>=7200){
            echo "timeout";
            exit;
        }
		if($_POST)
		{   
            if(isset($_POST['ettime'])){            
                $scoremodel->sc_time=$scoremodel->sc_time<=$_POST['ettime']?$_POST['ettime']:$scoremodel->sc_time;
                
                if($scoremodel->save()){
                    echo $scoremodel->sc_time;
                }else{
                    echo 'error';
                }
            }
            /*
            if(isset($_POST['selt'])){
                $TMARR=unserialize($scoremodel->sc_thanswer);
                foreach($TMARR as $tkid => $tkArr){
                    foreach($tkArr as $typeid => $tmArr){
                        foreach($tmArr as $key=>$val){
                            foreach($val as $kss=>$vss){
                                $data=Topic::model()->findByPk($vss['tid'])->attributes;
                                if(isset($_POST['selt'][$kss])&&$_POST['selt'][$kss]){
                                     $TMARR[$tkid][$typeid][$key][$kss]['answer']=is_array($_POST['selt'][$kss])?join(",",$_POST['selt'][$kss]):$_POST['selt'][$kss];
                                }
                                if($data['t_answer']==$vss['answer']){
                                    $TMARR[$tkid][$typeid][$key][$kss]['status']=1;
                                    $TMARR[$tkid][$typeid][$key][$kss]['sfs']=$data['t_level'];
                                }
                            }
                        }
                    }
                }
                $scoremodel->sc_thanswer=serialize($TMARR);
            }
            if(isset($_POST['cktype'])&&$_POST['cktype']=='1'){
                $scoremodel->sc_time=$scoremodel->sc_time+240;
            }            
            if(isset($_POST['selt'])||$_POST['cktype']=='1'){
                if($scoremodel->save()){
                    echo $_POST['cktype']=='1'?"":"ok";
                }else{
                    echo $_POST['cktype']=='1'?"":"error";
                }
                
			}else{
                echo "nodata";
            }*/
		}
        exit;
		// $this->render('update',array(
			// 'model'=>$model,
            // 'scoremodel'=>$scoremodel,
		// ));
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        //echo Yii::app()->user->id."||";
        //echo Yii::app()->user->role;
        //echo Yii::app()->user->isGuest;
        
        //echo Yii::app()->user->adminisGuest;
        //echo Yii::app()->user->studentisGuest;
        
        
        $criteria = new CDbCriteria;
        $criteria->select = "sc_id,sc_sid,sc_sjid,sc_pkid,sc_kgmark,sc_zgmark,sc_sdt,sc_ldt";
        // $criteria->addCondition("sc_sid=".Yii::app()->user->id);        
        // $criteria->addCondition("sc_status!=0");        
        // $criteria->group = "sc_sid,sc_id,sc_pkid";
        // $criteria->order = "sc_id asc";
        // $criteria->having = "sc_kgmark =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_status!=0 and sc_isdel=1 and sc_sid='".Yii::app()->user->id."')";
        
        $criteria->addCondition("sc_status!=0");        
        $criteria->addCondition("sc_sid=".Yii::app()->user->id);
        $criteria->addCondition("sc_isdel  = '1' ");//屏闭删除了的
        // $criteria->select='sc_id,sc_sid,sc_sjid,sc_pkid,sc_time,sc_kgmark,sc_zgmark,sc_source,sc_status,sc_isdel';
        $criteria->order = "sc_kgmark desc";
        $criteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1" and sc_sid="'.Yii::app()->user->id.'")';
        


        if(isset($_GET["ename"])&&$_GET["ename"]&&$_GET["ename"]!=''){
                $criteria->join="left join es_exampaper on(sc_sjid=e_id)";
                $criteria->addCondition("e_name regexp '{$_GET["ename"]}'");
                }
        $pageSize=isset($_COOKIE['cj_pagesize'])?$_COOKIE['cj_pagesize']:"10";
        
        $dataProvider =  new CActiveDataProvider("Score", array(
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Score the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Score::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
    public function loadExamModel($id)
	{
		$model=Exampaper::model()->findByPk($id);
		if($model===null||$model->e_isdel!=1)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Score $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='score-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
