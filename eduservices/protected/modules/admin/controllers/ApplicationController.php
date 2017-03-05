<?php

class ApplicationController extends Controller
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
				'actions'=>array('delall','index','add','edit','view'),//当权限不是超管的时候[即学习中心权限],index->申请列表 viewdetail->审核查看
				'users'=>array("*")
			),
			// array('allow', // allow authenticated user to perform 'create' and 'update' actions
				// 'actions'=>array('delall','index','view','audit','edit','check'),
				// 'users'=>User::model()->getManage(4)
			// ),
            
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('audit','check'),
				'users'=>User::model()->getManage(4)
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
        );
	}
    public $layout='admin';
   
    /*
     *通过学员sid,申请类型来添加申请信息
     */
    // public function actionApplication($sid,$type)
    public function actionAdd($sid,$type)
    {
        if(!array_key_exists($type,Application::$type))throw new CHttpException(404,'您访问的页面不存在。');
        $stuModel = $this->loadStuModel($sid); 
        $model = new Application;
        $model->sa_type = $type;
        $count=Application::model()->count("sa_sid ='{$stuModel->s_id}' and sa_type='{$type}' and sa_status=1 and sa_isdel =1");
        if($count){
            Yii::app()->user->setFlash("message","已有一条申请中记录");
            $this->redirect(array('students/view',"id"=>$stuModel->s_id));
            exit;
        }
        if($_POST&&!$count)
        {
            $model->attributes = $_POST;
            $model->sa_remarks = trim($model->sa_remarks);
            $model->sa_sid = $stuModel->s_id;
            $model->sa_sqtime= $model->sa_shedittime=time();
            $model->sa_proposerid = Yii::app()->user->id;
            $model->setAttribute("sa_fileurl",$_POST['sa_fileurl']); //setAttribute("class",value) 安全 过滤
            if($model->save()){
                Yii::app()->user->setFlash("message","申请成功");
                $this->redirect(array('application/view',"id"=>$model->sa_id));
            }else{
                Yii::app()->user->setFlash("message","申请失败");
            }
            
        }
        $this->render('add',array(
           'stuModel' => $stuModel,
           'model' => $model, 
           'type'=>$type,
        ));
    }
    /*
     *通过ID,进行修改
     */
    public function actionEdit($id)
    {
        $model = $this->loadModel($id);
        $stuModel = $this->loadStuModel($model->sa_sid);
        $uid=Yii::app()->user->id;
		$usermodel=User::model()->findByPk($uid);
		if(Yii::app()->user->role!="4"){
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			if(!in_array($stuModel->s_addid,$UArr))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
		}
        if($model->sa_status=="2"&&Yii::app()->user->role!="4") throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        // echo 
        $count=Application::model()->count("sa_sid ='{$stuModel->s_id}' and sa_status=1  and sa_isdel =1 and sa_id!={$model->sa_id} and sa_type ={$model->sa_type} ");
        if($count){
            Yii::app()->user->setFlash("message","已有一条申请中记录");
            $this->redirect(array('application/view',"id"=>$model->sa_id));
            exit;
        }
        if($_POST && !$count){
            $model->attributes = $_POST;
            $model->sa_statusremarks = trim($model->sa_statusremarks);
            $model->sa_shedittime=time();
            $model->sa_euserid = Yii::app()->user->id;
            $model->sa_isdel=1;
            $model->sa_status=$model->sa_status=="3"?1:$model->sa_status;
            $model->setAttribute("sa_fileurl",$_POST['sa_fileurl']); 
            if($model->save()){
                if($model->sa_status=='2'){
                    if($model->sa_fileurl){
                        $checkF = Files::model()->saveFile($model->sa_fileurl,$stuModel->s_credentialsnumber,6,$model->sa_id);
                        if($checkF){
                            $model->sa_fileurl=$checkF;
                        }
                    }
                    $model->save();
                }
                if($model->sa_type==2 && $model->sa_status==2){//当修改审核原审核状态为通过且申请类型为退学[即sa_status 2 sa_type==2]时，学员表中的字段 s_sleavetype为1
                    $stuModel->s_id=$model->sa_sid;
                    $stuModel->s_sleavetype=1;
                    if($stuModel->save()){
                        Yii::app()->user->setFlash("message","退学审核成功");
                    }else{
                        Yii::app()->user->setFlash("message",'退学审核失败，数据有误！');
                    }
                }
                Yii::app()->user->setFlash("message","修改成功");
                // $url = isset($_COOKIE['sqeditreturnurl'])?$_COOKIE['sqeditreturnurl']:array("view","id"=>$model->sa_id);
                $this->redirect(array('application/view',"id"=>$model->sa_id));
                $this->redirect($url);
            }else{
                Yii::app()->user->setFlash("message","修改失败");
            }  
        }
        $this->render("edit",array(
            'model'=>$model,
            'stuModel'=>$stuModel,
        ));
    }
    /*
     *通过申请ID学员申请审核页面 
     *审核页面
     */
    // public function actionView($id)
    public function actionAudit($id)
    {
        $model = $this->loadModel($id);
        $stuModel = $this->loadStuModel($model->sa_sid);
        if($model->sa_status!='1') throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        if(Yii::app()->user->role!='4'){
            $uid=Yii::app()->user->id;
			$usermodel=User::model()->findByPk($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization,array(),false);
			$UArr=User::model()->getAllByOid($OArr);
			if(!in_array($stuModel->s_addid,$UArr))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        }
        if($_POST)
        {
            $model->attributes=$_POST;
            $model->sa_shtime=time();
            $model->sa_shauditorid = Yii::app()->user->id;
            if($model->save()){
                if($model->sa_status==2){ //状态 已审
                    $stuModel->s_id=$model->sa_sid;
                    if($model->sa_type==2){ //申请类型： 退学申请
                        $stuModel->s_sleavetype=2;
                    }elseif($model->sa_type==5){ //申请类型： 删除申请
                        $stuModel->s_isdel=1;
                    }
                    if($stuModel->save()){
                        Yii::app()->user->setFlash("message","学员审核成功");
                    }else{
                        Yii::app()->user->setFlash("message",'学员审核失败，数据有误！');
                    }
                    //审核通过， 附件进入files表
                    if($model->sa_fileurl){
                        $checkF = Files::model()->saveFile($model->sa_fileurl,$stuModel->s_credentialsnumber,6,$model->sa_id);
                        // print_r($checkF);exit;
                        if($checkF){
                            $model->sa_fileurl=$checkF;
                        }
                    }
                    $model->save();
                }
                
                if($model->sa_type==4&&$model->sa_status==2){//审核通过，且为信息删除申请时，学员表中的信息删除，放入回收站
                    $stuModel->s_id=$model->sa_sid;
                    $stuModel->s_isdel=2;
                    if($stuModel->save()){
                        Yii::app()->user->setFlash("message","删除审核成功");
                    }else{
                        Yii::app()->user->setFlash("message",'删除审核失败，数据有误！');
                    }
                }
                Yii::app()->user->setFlash("message","审核成功");
                $url=isset($_COOKIE['xysqshreturnurl'])?$_COOKIE['xysqshreturnurl']:array("check");
                $this->redirect($url);
            }else{
                Yii::app()->user->setFlash("message",'审核失败，数据有误！');
            }
        }
        $this->render("audit",array(
            'model'=>$model,
            'stuModel'=>$stuModel,
        ));
    }
    
    //学员申请查看详情
    // public function actionViewdetail($id){
    public function actionView($id){
        $model = $this->loadModel($id);
        $stuModel = $this->loadStuModel($model->sa_sid);
        if(Yii::app()->user->role!='4'){
            if($stuModel->s_addid!=Yii::app()->user->id)throw new CHttpException(404,'无此学员操作权限。');
        }
        
        $uid=Yii::app()->user->id;
		$usermodel=User::model()->findByPk($uid);
		if(Yii::app()->user->role!="4"){
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			if(!in_array($stuModel->s_addid,$UArr))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
		}
        // if($model->sa_status=="2"&&Yii::app()->user->role!="4") throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        if($model->sa_isdel==2 && Yii::app()->user->role!=4) throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        // setcookie("xysqckreturnurl",$_SERVER['REQUEST_URI'],0,"/");
        $this->render("view",array(
            'model'=>$model,
            'stuModel'=>$stuModel,
        ));
    }
    //申请学员列表 待审核  已审核 驳回
    // public function actionApplicationlist()
    public function actionIndex()
    {
        $criteria=new CDbCriteria;
        $criteria->with="studentinfo";
        $criteria->select='sa_id,sa_sid,sa_status,sa_sqtime,sa_status,sa_type,sa_isdel,sa_proposerid';
        if(Yii::app()->user->role!="4"){
            $uid = Yii::app()->user->id;
            $usermodel=User::model()->getUserInfoById($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			$criteria->addInCondition('s_addid', $UArr);
        }
        // echo $
        foreach($_GET as $key=>$val){ 
            $val = addslashes($val);
            if($key=="sa_id"&&$val&&$val!="ID..")$criteria->addCondition("sa_id  regexp '{$val}' ");
            if($key=="sa_status"&&$val)$criteria->addCondition("sa_status  = '{$val}' ");
            if($key=="sa_type"&&$val)$criteria->addCondition("sa_type  = '{$val}' ");
            if($key=="s_name"&&$val&&$val!="姓名..")$criteria->addCondition("s_name  regexp '{$val}' ");
            if($key=="s_credentialsnumber"&&$val&&$val!="证件..")$criteria->addCondition("s_credentialsnumber  regexp '{$val}' ");
            if($key=="s_baokaocengci"&&$val)$criteria->addCondition("s_baokaocengci  = '{$val}' ");
			if($key=="s_baokaozhuanye"&&$val)$criteria->addCondition("s_baokaozhuanye  = '{$val}' ");
            if($key=="s_isbd"&&$val)$criteria->addCondition("s_idbd  = '{$val}' ");
            if($key=="s_addid"&&$val)$criteria->addCondition("s_addid  = '{$val}' ");
            if($key=="marktype"&&$val){
                $acriteria=new CDbCriteria;
                $acriteria->select="sc_sid,sc_kgmark";
                $acriteria->addCondition("sc_kgmark  is not  NULL "); 
                $acriteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1")';
                $Scoremodels=Score::model()->findAll($acriteria);
                $Sarr=array();
                foreach($Scoremodels as $score)$Sarr[]=$score->sc_sid;
                if($val==1){
                    $criteria->addInCondition('s_id', $Sarr);
                }elseif($val==2){
                    $criteria->addNotInCondition('s_id', $Sarr);
                }
            }
            if($key=="s_rpc"&&$val){
				if($val==999){
					$criteria->addCondition("s_rpc  = '' or s_rpc is NULL ");
				}else{
					$criteria->addCondition("s_rpc  = '{$val}' ");
				}
			}
            if($key=="s_pc"&&$val){
				if($val==999){
					$criteria->addCondition("s_pc  = '' or s_pc is NULL ");
				}else{
					$criteria->addCondition("s_pc  = '{$val}' ");
				}
			}
        }
        if(Yii::app()->user->role=="4"){
			$isdelStr=isset($_GET['type'])&&$_GET['type']=='2'?'2':"1";
            $criteria->addCondition("sa_isdel  = '{$isdelStr}' ");
		}else{
			$criteria->addCondition("sa_isdel  = '1' ");
		}
        $orderArr=array(
			"tmu"=>"sa_sqtime asc",
			
			"tmd"=>"sa_sqtime desc",
		);
        $order=isset($_GET['order'])?$_GET['order']:"";
        $criteria->order=isset($orderArr[$order])?$orderArr[$order]:"sa_sqtime asc";
        $pageSize=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20";
        setcookie("xysqlistreturnurl",$_SERVER['REQUEST_URI'],0,"/");
        $dataProvider = new CActiveDataProvider("Application",array(
                        'criteria'=>$criteria,
                        'pagination'=>array(
								'pageSize'=>$pageSize
						),
        ));
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }    
    //待审核列表
    // public function actionIndex()
    public function actionCheck()
	{
		$criteria=new CDbCriteria;
        $criteria->addCondition("sa_status = '1'");
        $criteria->with="studentinfo";
        $criteria->select='sa_id,sa_sid,sa_status,sa_sqtime,sa_type,sa_isdel';
        foreach($_GET as $key=>$val){
            $val = addslashes($val);
            if($key=="sa_id"&&$val&&$val!="ID..")$criteria->addCondition("sa_id  regexp '{$val}' ");
            if($key=="sa_status"&&$val)$criteria->addCondition("sa_status  = '{$val}' ");
            if($key=="sa_type"&&$val)$criteria->addCondition("sa_type  = '{$val}' ");
            if($key=="s_name"&&$val&&$val!="姓名..")$criteria->addCondition("s_name  regexp '{$val}' ");
            if($key=="s_credentialsnumber"&&$val&&$val!="证件..")$criteria->addCondition("s_credentialsnumber  regexp '{$val}' ");
            if($key=="s_birthaddress"&&$val&&$val!="出生地..")$criteria->addCondition(" s_birthaddress regexp '{$val}'");
            if($key=="s_baokaocengci"&&$val)$criteria->addCondition("s_baokaocengci  = '{$val}' ");
			if($key=="s_baokaozhuanye"&&$val)$criteria->addCondition("s_baokaozhuanye  = '{$val}' ");
            if($key=="s_isbd"&&$val)$criteria->addCondition("s_idbd  = '{$val}' ");
            if($key=="s_addid"&&$val)$criteria->addCondition("s_addid  = '{$val}' ");
			if($key=="s_pc"&&$val){
				if($val==999){
					$criteria->addCondition("s_pc  = '' or s_pc is NULL ");
				}else{
					$criteria->addCondition("s_pc  = '{$val}' ");
				}
			}
            if($key=="marktype"&&$val){
                $acriteria=new CDbCriteria;
                $acriteria->select="sc_sid,sc_kgmark";
                $acriteria->addCondition("sc_kgmark  is not  NULL "); 
                $acriteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1")';
                $Scoremodels=Score::model()->findAll($acriteria);
                $Sarr=array();
                foreach($Scoremodels as $score)$Sarr[]=$score->sc_sid;
                if($val==1){
                    $criteria->addInCondition('s_id', $Sarr);
                }elseif($val==2){
                    $criteria->addNotInCondition('s_id', $Sarr);
                }
            }
            if($key=="s_rpc"&&$val){
				if($val==999){
					$criteria->addCondition("s_rpc  = '' or s_rpc is NULL ");
				}else{
					$criteria->addCondition("s_rpc  = '{$val}' ");
				}
			}
        }
        if(Yii::app()->user->role=="4"){
			$isdelStr=isset($_GET['type'])&&$_GET['type']=='2'?'2':"1";
            $criteria->addCondition("sa_isdel  = '{$isdelStr}' ");
		}else{
			$criteria->addCondition("sa_isdel  = '1' ");
		}
        
        $orderArr=array(
			// "bcu"=>"s_baokaocengci asc",
			// "bzu"=>"s_baokaozhuanye asc",
			// "stu"=>"s_status asc",
			"tmu"=>"sa_sqtime asc",
			
			// "bcd"=>"s_baokaocengci desc",
			// "bzd"=>"s_baokaozhuanye desc",
			// "std"=>"s_status desc",
			"tmd"=>"sa_sqtime desc",
		);
        $order=isset($_GET['order'])?$_GET['order']:"";
        $criteria->order=isset($orderArr[$order])?$orderArr[$order]:"sa_sqtime asc";
        $pageSize=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20";
        setcookie("xysqreturnurl",$_SERVER['REQUEST_URI'],0,"/");
        $dataProvider = new CActiveDataProvider("Application",array(
                        'criteria'=>$criteria,
                        'pagination'=>array(
								'pageSize'=>$pageSize
						),
        ));
        $this->render('check',array(
            'dataProvider'=>$dataProvider,
        ));
	}
    
    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Application the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Application::model()->findByPk($id);
		// echo $model->s_addid;
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
    public function loadStuModel($sid)
    {
        $stuModel=Students::model()->findByPk($sid);
        if($stuModel===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $stuModel;
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
            $str=Yii::app()->user->role==4?"":"and sa_isdel = 1 and sa_status !=2 ";
            $count =Application::model()->updateAll(array('sa_isdel'=>$tid),"sa_id in ( ".join(",",$_POST['selectdel'])." ) {$str}"); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}		
}