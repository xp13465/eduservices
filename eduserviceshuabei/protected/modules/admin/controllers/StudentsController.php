<?php

class StudentsController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','index','view','add','edit','delete','delall','print','outstudents','allprint','np','outstudentsmanage','inportSM','stmp'),
				'users'=>array_merge(User::model()->getManage(1),User::model()->getManage(2),User::model()->getManage(3),User::model()->getManage(4),User::model()->getManage(5)),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('check','checku','inportSM','writecj'),
				'users'=>User::model()->getManage(4),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('OutExcelhz','OutExceldfb','inportSM'),
				'users'=>User::model()->getManage(5),
			),
            
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * 显示一条学员记录
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model=$this->loadModel($id);
		if(Yii::app()->user->role!="4"&&Yii::app()->user->role!="5"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->findByPk($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			if(!in_array($model->s_addid,$UArr))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
		}
		setcookie("xyckreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		$this->render('view',array(
			'model'=>$model,
		));
	}
    
    /**
	 * 审核一条学员记录
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionChecku($id)
	{ 
		$model=$this->loadModel($id);
		if($model->s_status!='1') throw new CHttpException(400,'无效的请求。请不要再这样的要求。');	
		if(Yii::app()->user->role!="4"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->findByPk($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization,array(),false);
			$UArr=User::model()->getAllByOid($OArr);
			if(!in_array($model->s_addid,$UArr))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
		}
		if($_POST)
		{
			$check=true;
			$model->attributes=$_POST;
			if($model->s_status=='2'){
				if($model->s_pc){
					
				}else{
					$model->addError("s_pc","请选择分类批次");	
					$check=false;
				}
			}else if($model->s_status!='3'){
                $model->addError("s_status","请选择");	
				$check=false;
            }
            if(Yii::app()->user->role=='4'){
                $model->s_rpc=isset($_POST['s_rpc'])?$_POST['s_rpc']:"";
                $model->s_pc=isset($_POST['s_pc'])?$_POST['s_pc']:"";
            }else{
                unset($model->s_rpc);
                unset($model->s_pc);
            }
            
			$model->s_statusid=Yii::app()->user->id;
			$model->s_statustime=time();	
			if($check){
				if($model->save()){
					if($model->s_status=='2'){
						if($model->s_headerimg){
							$checkHD=Files::model()->SaveFile($model->s_headerimg,$model->s_credentialsnumber,1,$model->s_id);
							if($checkHD){
								$model->s_headerimg=$checkHD;
							}
						}
						if($model->s_credentialsimg1){
							$checkS1=Files::model()->SaveFile($model->s_credentialsimg1,$model->s_credentialsnumber,2,$model->s_id);
							if($checkS1){
								$model->s_credentialsimg1=$checkS1;
							}
						}
						if($model->s_credentialsimg2){
							$checkS2=Files::model()->SaveFile($model->s_credentialsimg2,$model->s_credentialsnumber,3,$model->s_id);
							if($checkS2){
								$model->s_credentialsimg2=$checkS2;
							}
						}
						if($model->s_oldimg){
							$checkBY=Files::model()->SaveFile($model->s_oldimg,$model->s_credentialsnumber,4,$model->s_id);
							if($checkBY){
								$model->s_oldimg=$checkBY;
							}
						}
						if($model->s_zsbzm){
							$checkZM=Files::model()->SaveFile($model->s_zsbzm,$model->s_credentialsnumber,5,$model->s_id);
							if($checkZM){
								$model->s_zsbzm=$checkZM;
							}
						}
						if($model->s_file){
							$checkF=Files::model()->SaveFile($model->s_file,$model->s_credentialsnumber,6,$model->s_id);
							if($checkF){
								$model->s_file=$checkF;
							}
						}
					}
					$model->save();
                    Yii::app()->user->setFlash("message","审核成功");
                    $url=isset($_COOKIE['xyckreturnurl'])?$_COOKIE['xyckreturnurl']:array("check");
                    $this->redirect($url);
				}else{
                    Yii::app()->user->setFlash("message",'审核失败，数据有误！');
                }
			}else{
                Yii::app()->user->setFlash("message",'审核失败，请选择分类批次！');
                
            }
		}
		
		$this->render('checku',array(
			'model'=>$model,
		));
	}

	/**
	 * 添加一条学员记录
	 */
	public function actionAdd()
	{
        $RPC='';
        if(in_array(date('m'),Yii::app()->params->pcchun)){
            if(in_array(date('m'),array(9,10,11,12))){
                $RPC=date("y",strtotime("+1 year"))."03";
            }else{
                $RPC=date("y")."03";
            }
        }else if(in_array(date('m'),Yii::app()->params->pcqiu)){
            $RPC=date("y")."09";
        }
        if(!$RPC)throw new CHttpException(404,'当前不可录入学员！！！');
            $PCLIMIT=Inputlimits::model()->find("il_uid ='".Yii::app()->user->id."' and il_pc='{$RPC}'");
        if($PCLIMIT){
            $mylimits=Students::model()->count("s_addid ='".Yii::app()->user->id."' and s_isdel='1' and s_rpc='{$RPC}'");
            if($PCLIMIT->il_limit==0){
                // throw new CHttpException(404,"您无报名权限！");
                Yii::app()->user->setFlash("message","您无报名权限！");
                $this->redirect(Yii::app()->request->urlReferrer);
            }elseif($mylimits>=$PCLIMIT->il_limit){
                // throw new CHttpException(404,"您的报名人数已满！");
                Yii::app()->user->setFlash("message","您的报名人数已满！{$mylimits}");
                $this->redirect(Yii::app()->request->urlReferrer);
                // throw new CHttpException(404,"您已经达到[{$RPC}批次]的可录入上限({$PCLIMIT->il_limit}人)!!!不可录入");
            }
        }
        if(!in_array(Yii::app()->user->role,array(1,2)))throw new CHttpException(404,'无效的请求。请不要再这样的要求。');
		$model=new Students;
        
		if($_POST)
		{	
			$model->attributes=$_POST;
			$model->s_name=trim($model->s_name);
			$model->s_name=str_replace(" ","",$model->s_name);
            $model->s_rpc=$RPC;
			$model->s_addid=$model->s_editid=Yii::app()->user->id;
			$model->s_addtime=$model->s_edittime=time();
			$model->s_birthdate=strtotime($model->s_birthdate);
			$model->s_oldtime=strtotime($model->s_oldtime."-01");
			$model->s_cjgztime=strtotime($model->s_cjgztime."-01");
            
            $uid=Yii::app()->user->id;
            $usermodel=User::model()->findByPk($uid);
            $sfcodeQZ=substr(strtolower(trim($model->s_credentialsnumber)),0,2);
            $checkArr=array();
            $Omodel=Organization::model()->findByPk($usermodel->user_organization);
            if($usermodel->user_bddm){
                $checkArr=explode(",",$usermodel->user_bddm);
            }else{
                if($Omodel->o_zone){
                    $checkArr=explode(",",$Omodel->o_zone);
                }else if($Omodel->o_pid){
                    $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                    if($POmodel->o_zone){
                         $checkArr=explode(",",$POmodel->o_zone);
                    }
                }
            }
            if($usermodel->user_role==2){
                $OArr=Organization::model()->getAllid($usermodel->user_organization);
            }else if($usermodel->user_role==1){
                $OArr=Organization::model()->getAllid($Omodel->o_pid);
            }
            $criteria=new CDbCriteria;
            $UArr=User::model()->getAllByOid($OArr);
            $criteria->addInCondition('s_addid', $UArr);
            $criteria->addCondition("s_rpc ='{$model->s_rpc}'");
            $criteria->select="max(s_insertid) as s_insertid";
            $max=Students::model()->find($criteria);
            $maxid=$max?$max->s_insertid:0;
            $model->s_insertid=$maxid+1;
            if($checkArr){
                $ck=true;
                foreach($checkArr as $qz){
                    if($sfcodeQZ==$qz){
                        $model->s_idbd=3;
                        $ck=false;
                        break;
                    }
                }
                $model->s_idbd=$ck?"2":$model->s_idbd;
            }else{
                $model->s_idbd=1;
            }
			if($model->s_highesteducation=="1"){
				unset($model->s_oldschool);
				unset($model->s_oldschoolcode);
				unset($model->s_oldzhuanye);
				unset($model->s_oldtime);
				unset($model->s_oldimgnumber);
			}
            
			if($model->s_baokaocengci!="2"&&!$model->s_zsbzm){
				$model->s_zsbzm=$model->s_zsbzm&&$model->s_zsbzm!="NULL"?$model->s_zsbzm:'NULL';
			}
			if($model->save()){
				$this->redirect(array('view','id'=>$model->s_id));
				
			}else{
				$model->s_birthdate=date('Ymd',$model->s_birthdate);
				$model->s_oldtime=date('Y-m',$model->s_oldtime);
				$model->s_cjgztime=date('Y-m',$model->s_cjgztime);
			}
		}else{
			$model->s_oldschool='NULL';
			$model->s_oldschoolcode='NULL';
			$model->s_oldzhuanye='NULL';
			$model->s_oldtime='NULL';
			$model->s_oldimgnumber='NULL';
		}
		$this->render('add',array(
			'model'=>$model,
		));
	}
    
    /**
	 * 编辑一条学员记录
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionEdit($id)
	{ 
		$model=$this->loadModel($id);
        $uid=Yii::app()->user->id;
		$usermodel=User::model()->findByPk($uid);
		if(Yii::app()->user->role!="4"){
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			if(!in_array($model->s_addid,$UArr))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
		}
		if($model->s_status=="2"&&Yii::app()->user->role!="4")
			throw new CHttpException(400,'无效的请求。请不要再这样的要求。');

		if($_POST)
		{       
			$model->attributes=$_POST;
			$model->s_status=$model->s_status=="3"?1:$model->s_status;
			$model->s_name=trim($model->s_name);
			$model->s_name=str_replace(" ","",$model->s_name);
            
			if(Yii::app()->user->role=='4'){
                $model->s_rpc=isset($_POST['s_rpc'])?$_POST['s_rpc']:"";
                $model->s_pc=isset($_POST['s_pc'])?$_POST['s_pc']:"";
            }else{
                unset($model->s_rpc);
                unset($model->s_pc);
            }
            
			$model->s_isdel=1;
            $model->s_editid=Yii::app()->user->id;
			$model->s_edittime=time();
            
			$model->s_birthdate=strtotime($model->s_birthdate);
			$model->s_oldtime=strtotime($model->s_oldtime."-01");
			$model->s_cjgztime=strtotime($model->s_cjgztime."-01");
            if(Yii::app()->user->id==$model->s_addid){
                $sfcodeQZ=substr(strtolower(trim($model->s_credentialsnumber)),0,2);
                $checkArr=array();
                if($usermodel->user_bddm){
                    $checkArr=explode(",",$usermodel->user_bddm);
                }else{
                    $Omodel=Organization::model()->findByPk($usermodel->user_organization);
                    if($Omodel->o_zone){
                        $checkArr=explode(",",$Omodel->o_zone);
                    }else if($Omodel->o_pid){
                        $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                        if($POmodel->o_zone){
                             $checkArr=explode(",",$POmodel->o_zone);
                        }
                    }
                }
                if($checkArr){
                    $ck=true;
                    foreach($checkArr as $qz){
                        if($sfcodeQZ==$qz){
                            $model->s_idbd=3;
                            $ck=false;
                            break;
                        }
                    }
                    $model->s_idbd=$ck?"2":$model->s_idbd;
                }else{
                    $model->s_idbd=1;
                }
            }
            
			if($model->s_highesteducation=="1"){
				unset($model->s_oldschool);
				unset($model->s_oldschoolcode);
				unset($model->s_oldzhuanye);
				unset($model->s_oldtime);
				unset($model->s_oldimgnumber);
			}
			if($model->s_baokaocengci!="2"&&!$model->s_zsbzm){
				$model->s_zsbzm=$model->s_zsbzm&&$model->s_zsbzm!="NULL"?$model->s_zsbzm:'NULL';
			}
			if($model->save()){
                if($model->s_status=='2'){
					if($model->s_headerimg){
						$checkHD=Files::model()->SaveFile($model->s_headerimg,$model->s_credentialsnumber,1,$model->s_id);
						if($checkHD){
							$model->s_headerimg=$checkHD;
						}
					}
					if($model->s_credentialsimg1){
						$checkS1=Files::model()->SaveFile($model->s_credentialsimg1,$model->s_credentialsnumber,2,$model->s_id);
						if($checkS1){   
							$model->s_credentialsimg1=$checkS1;
						}
					}
					if($model->s_credentialsimg2){
						$checkS2=Files::model()->SaveFile($model->s_credentialsimg2,$model->s_credentialsnumber,3,$model->s_id);
						if($checkS2){
							$model->s_credentialsimg2=$checkS2;
						}
					}
					if($model->s_oldimg){
						$checkBY=Files::model()->SaveFile($model->s_oldimg,$model->s_credentialsnumber,4,$model->s_id);
						if($checkBY){
							$model->s_oldimg=$checkBY;
						}
					}
					if($model->s_zsbzm){
						$checkZM=Files::model()->SaveFile($model->s_zsbzm,$model->s_credentialsnumber,5,$model->s_id);
						if($checkZM){
							$model->s_zsbzm=$checkZM;
						}
					}
					if($model->s_file){
						$checkF=Files::model()->SaveFile($model->s_file,$model->s_credentialsnumber,6,$model->s_id);
						if($checkF){
							$model->s_file=$checkF;
						}
					}
				}
				$model->save();
				$this->redirect(array('view','id'=>$model->s_id));
            }
		}
        
		$model->s_birthdate=date('Ymd',$model->s_birthdate);
		$model->s_oldtime=date('Y-m',$model->s_oldtime);
		$model->s_cjgztime=date('Y-m',$model->s_cjgztime);
        
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * 显示所有学员列表
	 */
	public function actionIndex()
	{ 
        $criteria=new CDbCriteria;
        $criteria->select='s_enrollment,s_id,s_rpc,s_pc,s_name,s_credentialstype,s_credentialsnumber,s_birthaddress,s_phone,s_baokaocengci,s_baokaozhuanye,s_status,s_addid,s_addtime,s_isdel,s_birthdate,s_sleavetype';
		if(Yii::app()->user->role!="4"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->getUserInfoById($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			$criteria->addInCondition('s_addid', $UArr);
		}
            $zxtmp=isset($_GET['zhongxin'])&&$_GET['zhongxin']?$_GET['zhongxin']:"";
            $bmtmp=isset($_GET['baomingdian'])&&$_GET['baomingdian']?$_GET['baomingdian']:"";
            $jgtmp=isset($_GET['jigou'])&&$_GET['jigou']?$_GET['jigou']:"";
            $Oid='';
            if($jgtmp){
                $Oid=$jgtmp;
            }else if($bmtmp){
                $Oid=$bmtmp;
            }else if($zxtmp){
                $Oid=$zxtmp;
            }
            if($Oid){
                $OArr=Organization::model()->getAllid($Oid);
                $UArr=User::model()->getAllByOid($OArr);
                $criteria->addInCondition('s_addid', $UArr);
            }
		foreach($_GET as $key=>$val){
            $val = addslashes($val);
			if($key=="s_name"&&$val&&$val!="姓名..")$criteria->addCondition("s_name  regexp '{$val}' ");
            if($key=="s_insertid"&&$val&&$val!="录入编号.."){
               $insetrid=trim(substr($val,-6));
                $criteria->addCondition("s_insertid  = '{$insetrid}' ");
               $Oid=str_replace($insetrid,"",$val);
               if($Oid){
                    $OArr=Organization::model()->getAllid($Oid);
                    $UArr=User::model()->getAllByOid($OArr);
                    $criteria->addInCondition('s_addid', $UArr);
                }
            }
            if($key=="s_id"&&$val&&$val!="ID..")$criteria->addCondition("s_id  regexp '{$val}' ");
			if($key=="s_credentialsnumber"&&$val&&$val!="证件..")$criteria->addCondition("s_credentialsnumber  regexp '{$val}' ");
			if($key=="s_birthaddress"&&$val&&$val!="出生地..")$criteria->addCondition(" s_birthaddress regexp '{$val}'");
			if($key=="s_baokaocengci"&&$val)$criteria->addCondition("s_baokaocengci  = '{$val}' ");
			if($key=="s_baokaozhuanye"&&$val)$criteria->addCondition("s_baokaozhuanye  = '{$val}' ");
			if($key=="s_status"&&$val)$criteria->addCondition("s_status  = '{$val}' ");
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
                if(isset($_GET['s_pc'])&&$_GET['s_pc']){
                    $pkArr=$Sarr=array();
                    $pkModel=Examarrangement::model()->findAll("ea_pkid  ='{$_GET['s_pc']}' ");
                    foreach($pkModel as $pkey=>$pval)$pkArr[]=$pval->ea_id;
                    $acriteria->addInCondition('sc_pkid', $pkArr);
                }
                $acriteria->addCondition("sc_kgmark  is not  NULL "); 
                $acriteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1")';
                $Scoremodels=Score::model()->findAll($acriteria);
                $Sarr=array();
                foreach($Scoremodels as $score)$Sarr[]=$score->sc_sid;
                if($val==1){
                    $str=$Sarr?'s_id in ('.join(",",$Sarr).') or':'';
                    $criteria->addCondition("{$str} s_enrollment =2");
                }elseif($val==2){
                    $criteria->addNotInCondition('s_id', $Sarr);
                    $criteria->addCondition("s_enrollment =1");
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
        if(isset($_GET['smtype'])&&$_GET['smtype']==2){
            $criteria->join=" left join es_students_manage on s_id=sm_sid  ";
            $criteria->addCondition("sm_id is NULL");
        }else{
            $criteria->with="manageinfo";
        }
		if(Yii::app()->user->role==4){
			$isdelStr=isset($_GET['type'])&&$_GET['type']=='2'?'2':"1";
			$criteria->addCondition("s_isdel  = '{$isdelStr}' ");
		}else{
			$criteria->addCondition("s_isdel  = '1' ");
		}
		$orderArr=array(
			"bcu"=>"s_baokaocengci asc",
			"bzu"=>"s_baokaozhuanye asc",
			"stu"=>"s_status asc",
			"tmu"=>"s_addtime asc",
			
			"bcd"=>"s_baokaocengci desc",
			"bzd"=>"s_baokaozhuanye desc",
			"std"=>"s_status desc",
			"tmd"=>"s_addtime desc",
		);
        $criteria->addCondition("s_stype  = '1' ");
                $UserArr=User::model()->findAll("user_role='4'");//去除管理员录入的学员记录,实际管理员无需录入
                $uarr=array();
                foreach($UserArr as $v){$uarr[]=$v["user_id"];}
        $criteria->addNotInCondition("s_addid",$uarr);
		$order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"s_addtime desc";
		$pageSize=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20";
		setcookie("xylistreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		$dataProvider =  new CActiveDataProvider("Students", array(
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
	 * 显示所有学员审核
	 */
	public function actionCheck()
	{
		
		$criteria=new CDbCriteria;
        $criteria->select='s_id,s_rpc,s_pc,s_name,s_credentialstype,s_credentialsnumber,s_birthaddress,s_phone,s_baokaocengci,s_baokaozhuanye,s_status,s_addid,s_addtime,s_isdel,s_birthdate';
		
		if(Yii::app()->user->role!="4"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->findByPk($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization,array(),false);
			$UArr=User::model()->getAllByOid($OArr);
			$criteria->addInCondition('s_addid', $UArr);
		}else{
            $zxtmp=isset($_GET['zhongxin'])&&$_GET['zhongxin']?$_GET['zhongxin']:"";
            $bmtmp=isset($_GET['baomingdian'])&&$_GET['baomingdian']?$_GET['baomingdian']:"";
            $jgtmp=isset($_GET['jigou'])&&$_GET['jigou']?$_GET['jigou']:"";
            $Oid='';
            if($jgtmp){
                $Oid=$jgtmp;
            }else if($bmtmp){
                $Oid=$bmtmp;
            }else if($zxtmp){
                $Oid=$zxtmp;
            }
            if($Oid){
                $OArr=Organization::model()->getAllid($Oid);
                $UArr=User::model()->getAllByOid($OArr);
                $criteria->addInCondition('s_addid', $UArr);
            }
        }
		$criteria->addCondition("s_isdel  = '1' ");
		$criteria->addCondition("s_status  = '1' ");
		foreach($_GET as $key=>$val){
			 $val = addslashes($val);
            if($key=="s_insertid"&&$val&&$val!="录入编号.."){
               $insetrid=trim(substr($val,-6));
                $criteria->addCondition("s_insertid  = '{$insetrid}' ");
               $Oid=str_replace($insetrid,"",$val);
               if($Oid){
                    $OArr=Organization::model()->getAllid($Oid);
                    $UArr=User::model()->getAllByOid($OArr);
                    $criteria->addInCondition('s_addid', $UArr);
                }
            }
            if($key=="s_id"&&$val&&$val!="ID..")$criteria->addCondition("s_id  regexp '{$val}' ");
			if($key=="s_name"&&$val&&$val!="姓名..")$criteria->addCondition("s_name  regexp '{$val}' ");
			if($key=="s_credentialsnumber"&&$val&&$val!="证件..")$criteria->addCondition("s_credentialsnumber  regexp '{$val}' ");
			if($key=="s_birthaddress"&&$val&&$val!="出生地..")$criteria->addCondition(" s_birthaddress regexp '{$val}'");
			if($key=="s_baokaocengci"&&$val)$criteria->addCondition("s_baokaocengci  = '{$val}' ");
			if($key=="s_baokaozhuanye"&&$val)$criteria->addCondition("s_baokaozhuanye  = '{$val}' ");
            if($key=="s_isbd"&&$val)$criteria->addCondition("s_idbd  = '{$val}' ");
		}
		$orderArr=array(
			"bcu"=>"s_baokaocengci asc",
			"bzu"=>"s_baokaozhuanye asc",
			"tmu"=>"s_addtime asc",
			
			"bcd"=>"s_baokaocengci desc",
			"bzd"=>"s_baokaozhuanye desc",
			"tmd"=>"s_addtime desc",
		);
        $criteria->addCondition("s_stype  = '1' ");
		$order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"s_addtime asc";
		$pageSize=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20";
		setcookie("xyckreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		$dataProvider =  new CActiveDataProvider("Students", array(
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
	 * @return Students the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Students::model()->findByPk($id);
		if($model===null||(Yii::app()->user->role!='4'&&$model->s_isdel!="1"))
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
			$tid=isset($_POST['tid'])&&in_array($_POST['tid'],array(1,2))?$_POST['tid']:"2";
			$criteria= new CDbCriteria;
			$criteria->addInCondition('user_id', $_POST['selectdel']);
            $str=Yii::app()->user->role==4?"":"and s_isdel = 1 and s_status !=2 ";
			$count =Students::model()->updateAll(array('s_isdel'=>$tid),"s_id in ( ".join(",",$_POST['selectdel'])." ) {$str}"); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}					
	
    /**
	 * 打印学员报名表
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionPrint($id)
	{	
		$model=$this->loadModel($id);
		if(Yii::app()->user->role!="4"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->findByPk($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			if(!in_array($model->s_addid,$UArr))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
		}
		$this->layout=false;
		$this->render('print',array(
				'model'=>$model,
		));
	}
    
    /**
	 * 打印学员信息
	 * @param integer $id the ID of the model to be displayed
	 */
    public function actionAllprint($id)
	{	
		$model=$this->loadModel($id);
		if(Yii::app()->user->role!="4"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->findByPk($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			if(!in_array($model->s_addid,$UArr))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
		}
		$this->layout=false;
		$this->render('allprint',array(
				'model'=>$model,
		));
	}
    
    /**
	 * 学员管理
	 */
    public function actionManage()
	{
        $criteria=new CDbCriteria;
		if(Yii::app()->user->role!="4"&&Yii::app()->user->role!="5"){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->findByPk($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			$criteria->addInCondition('s_addid', $UArr);
		}
            $zxtmp=isset($_GET['zhongxin'])&&$_GET['zhongxin']?$_GET['zhongxin']:"";
            $bmtmp=isset($_GET['baomingdian'])&&$_GET['baomingdian']?$_GET['baomingdian']:"";
            $jgtmp=isset($_GET['jigou'])&&$_GET['jigou']?$_GET['jigou']:"";
            $Oid='';
            if($jgtmp){
                $Oid=$jgtmp;
            }else if($bmtmp){
                $Oid=$bmtmp;
            }else if($zxtmp){
                $Oid=$zxtmp;
            }
            if($Oid){
                $OArr=Organization::model()->getAllid($Oid);
                $UArr=User::model()->getAllByOid($OArr);
                $criteria->addInCondition('s_addid', $UArr);
            }
		foreach($_GET as $key=>$val){
			$val = addslashes($val);
            if($key=="s_insertid"&&$val&&$val!="录入编号.."){
               $insetrid=trim(substr($val,-6));
                $criteria->addCondition("s_insertid  = '{$insetrid}' ");
               $Oid=str_replace($insetrid,"",$val);
               if($Oid){
                    $OArr=Organization::model()->getAllid($Oid);
                    $UArr=User::model()->getAllByOid($OArr);
                    $criteria->addInCondition('s_addid', $UArr);
                }
            }
            if($key=="s_id"&&$val&&$val!="ID..")$criteria->addCondition("s_id  regexp '{$val}' ");
            if($key=="s_bmorder"&&$val&&$val!="报名编号..")$criteria->addCondition("sm_bmorder  regexp '{$val}' ");
			if($key=="s_name"&&$val&&$val!="姓名..")$criteria->addCondition("s_name  regexp '{$val}' ");
			if($key=="s_credentialsnumber"&&$val&&$val!="证件..")$criteria->addCondition("s_credentialsnumber  regexp '{$val}' ");
			if($key=="s_birthaddress"&&$val&&$val!="出生地..")$criteria->addCondition(" s_birthaddress regexp '{$val}'");
			if($key=="s_baokaocengci"&&$val)$criteria->addCondition("s_baokaocengci  = '{$val}' ");
			if($key=="s_baokaozhuanye"&&$val)$criteria->addCondition("s_baokaozhuanye  = '{$val}' ");
			if($key=="sm_status"&&$val)$criteria->addCondition("sm_status  = '{$val}' ");
            if($key=="s_isbd"&&$val)$criteria->addCondition("s_idbd  = '{$val}' ");
            if($key=="s_addid"&&$val)$criteria->addCondition("s_addid  = '{$val}' ");
			if($key=="s_pc"&&$val){
				if($val==999){
					$criteria->addCondition("s_pc  = '' or s_pc is NULL ");
				}else{
					$criteria->addCondition("s_pc  = '{$val}' ");
				}
			}
            if($key=="s_rpc"&&$val){
				if($val==999){
					$criteria->addCondition("s_rpc  = '' or s_pc is NULL ");
				}else{
					$criteria->addCondition("s_rpc  = '{$val}' ");
				}
			}
            if($key=="marktype"&&$val){
                $acriteria=new CDbCriteria;
                $acriteria->select="sc_sid,sc_kgmark";
                if(isset($_GET['s_pc'])&&$_GET['s_pc']){
                    $pkArr=$Sarr=array();
                    $pkModel=Examarrangement::model()->findAll("ea_pkid  ='{$_GET['s_pc']}' ");
                    foreach($pkModel as $pkey=>$pval)$pkArr[]=$pval->ea_id;
                    $acriteria->addInCondition('sc_pkid', $pkArr);
                }
                $acriteria->addCondition("sc_kgmark  is not  NULL "); 
                $acriteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1")';
                $Scoremodels=Score::model()->findAll($acriteria);
                $Sarr=array();
                foreach($Scoremodels as $score)$Sarr[]=$score->sc_sid;
                if($val==1){
                    $str=$Sarr?'s_id in ('.join(",",$Sarr).') or':'';
                    $criteria->addCondition("{$str} s_enrollment =2");
                }elseif($val==2){
                    $criteria->addNotInCondition('s_id', $Sarr);
                    $criteria->addCondition("s_enrollment =1");
                }else{
                
                }
                
            }
		}
		if(Yii::app()->user->role==4){
			$isdelStr=isset($_GET['type'])&&$_GET['type']=='2'?'2':"1";
			$criteria->addCondition("s_isdel  = '{$isdelStr}' ");
		}else{
			$criteria->addCondition("s_isdel  = '1' ");
		}
        $criteria->with='studentinfo';
		$orderArr=array(
			"bcu"=>"s_baokaocengci asc",
			"bzu"=>"s_baokaozhuanye asc",
			"stu"=>"s_status asc",
			"tmu"=>"s_addtime asc",
			
			"bcd"=>"s_baokaocengci desc",
			"bzd"=>"s_baokaozhuanye desc",
			"std"=>"s_status desc",
			"tmd"=>"s_addtime desc",
		);
		$order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"s_addtime asc";
        if(isset($_GET['s_bmorder'])&&$_GET['s_bmorder']&&$_GET['s_bmorder']!="报名编号..")$criteria->order="sm_bmorder asc";
		$pageSize=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20";
		setcookie("xylistreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		$dataProvider =  new CActiveDataProvider("StudentsManage", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>$pageSize
						),
		));
		$this->render('manage',array(
			'dataProvider'=>$dataProvider,
		));
    }
    
    /**
	 * 学员成绩表等分写入
	 */
    public function actionWritecj()
	{
        ob_end_clean(); 
        error_reporting(E_ALL);
        set_time_limit(0);
        date_default_timezone_set('PRC');
        $sheetData=array();
        if (@is_uploaded_file($_FILES['upfile']['tmp_name'])){
            $ok=0;
            $uppath=PIC_PATH; //文件上传路径
            switch ($_FILES['upfile']['type']) {//其他文件格式可以在下面增加判断
                case 'application/octet-stream' : 
                $rsz=@end(explode(".",$_FILES['upfile']['name']));
                $name=date("YmdHis_",time()).mt_rand().".".$rsz;;
                $ok=1;
                break;
                case 'application/kset' :  
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
                header("Content-type:text/html;charset=utf-8");
                echo "<script>alert('表格格式不正确,请重试{$_FILES['upfile']['type']}');location.href=location.href;</script>";
                exit;
            }
            if ($_FILES['upfile']['size']>1024*1024*8){
                header("Content-type:text/html;charset=utf-8");
                echo "<script>alert('表格过大,大小请小于8M');location.href=location.href;</script>";
                exit;
            }
            if($ok=="1" && $_FILES['upfile']['error']=='0'){
                if(@move_uploaded_file($_FILES['upfile']['tmp_name'],$uppath.$name)){
                    set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
                    spl_autoload_unregister(array('YiiBase','autoload'));
                    include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
                    spl_autoload_register(array('YiiBase','autoload'));  
                    

                    $inputFileName =$uppath.$name;
                    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                    $loadedSheetNames = $objPHPExcel->getSheetNames();
                    foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                        $objPHPExcel->setActiveSheetIndexByName($loadedSheetName);
                        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,false,false,true);
                         foreach($sheetData as $key=>$val){
                         $objPHPExcel->setActiveSheetIndex($sheetIndex)
                                                    ->setCellValueExplicit('A'.$key,  $val["A"], PHPExcel_Cell_DataType::TYPE_STRING)
                                                    ->setCellValueExplicit('B'.$key,  $val["B"], PHPExcel_Cell_DataType::TYPE_STRING)
                                                    ->setCellValueExplicit('C'.$key,  $val["C"], PHPExcel_Cell_DataType::TYPE_STRING)
                                                    ->setCellValueExplicit('D'.$key,  $val["D"], PHPExcel_Cell_DataType::TYPE_STRING)
                                                    ->setCellValueExplicit('E'.$key,  $val["E"], PHPExcel_Cell_DataType::TYPE_STRING)
                                                    ->setCellValueExplicit('F'.$key,  $val["F"], PHPExcel_Cell_DataType::TYPE_STRING);
                        
                             if($key<5)continue;
                            
                            $sid=$s_enrollment=false;
                            $criteria=new CDbCriteria;
                            $criteria->with='studentinfo';
                            $criteria->addCondition("(sm_bmorder  = '{$val['B']}' or s_credentialsnumber  = '{$val['B']}') and s_name='{$val['C']}'");
                            $model=StudentsManage::model()->find($criteria);
                            if($model){
                                $sid=$model->sm_sid;
                                $s_enrollment=$model->studentinfo->s_enrollment;
                            }
                            if(!$model){
                                $criteria=new CDbCriteria;
                                $criteria->addCondition(" s_credentialsnumber  = '{$val['B']}' and s_name='{$val['C']}'");
                                $model=Students::model()->find($criteria);
                                if($model){
                                    $sid=$model->s_id;
                                    $s_enrollment=$model->s_enrollment;
                                }
                            }
                            if($sid){
                                $scModel=Score::model()->find("sc_sid = '{$sid}' and sc_status!=0 and sc_isdel=1 order by sc_kgmark desc ");
                                $fs=$scModel?$scModel->sc_kgmark:"缺考";
                                $fs=$s_enrollment==1?$scModel?$scModel->sc_kgmark:"缺考":"免试";
                                $objPHPExcel->setActiveSheetIndex($sheetIndex)
                                    ->setCellValueExplicit('E'.$key,  $fs, PHPExcel_Cell_DataType::TYPE_STRING);
                            } 
                        }
                    }
                    $filename = "系统写入".$_FILES['upfile']['name'];
                    $this->EndExecl($filename,$objPHPExcel);
                      
                       
                    }
                 }
                 
            
        }
        $seep=50;
        $this->render('writecj',array(
            'sheetData'=>$sheetData,
            'seep'=>$seep,
		));
    }
    
    /**
	 * 北航导出学员表导入
	 */
    public function actionInportSM($type=1)
	{   
        if($type=="clear"){
            $connection=Yii::app()->db; 
            $sql="TRUNCATE TABLE es_execlscore";
            $rows=$connection->createCommand ($sql)->query();
            echo "Clear OK";
            exit;
        }
        ob_end_clean(); 
        error_reporting(E_ALL);
        set_time_limit(0);
        date_default_timezone_set('PRC');
        $sheetDataArr=array();
        $error="asdasd";
        if(isset($_FILES['upfile'])&&is_array($_FILES['upfile']['tmp_name'])){
            foreach($_FILES['upfile']['name'] as $key=>$val){
                if (is_uploaded_file($_FILES['upfile']['tmp_name'][$key])){
                    $ok[$key]=0;
                    $uppath=PIC_PATH; //文件上传路径
                    switch ($_FILES['upfile']['type'][$key]) {//其他文件格式可以在下面增加判断
                        case 'application/octet-stream' :  
                        $ok[$key]=1;
                        break;
                        case 'application/kset' :  
                        $ok[$key]=1;
                        break;
                        case 'application/vnd.ms-excel' :  
                        $ok[$key]=1;
                        break;
                        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' :  
                        $ok[$key]=1;
                        break;
                    }
                    if (@$ok[$key]!=1){
                        header("Content-type:text/html;charset=utf-8");
                        echo "<script>alert('表格格式不正确,请重试');location.href=location.href;</script>";
                        exit;
                    }
                    if ($_FILES['upfile']['size'][$key]>1024*1024*8){
                        header("Content-type:text/html;charset=utf-8");
                        echo "<script>alert('表格过大,大小请小于8M');location.href=location.href;</script>";
                        exit;
                    }
                    if($ok[$key]=="1" && $_FILES['upfile']['error'][$key]=='0'){
                        $rsz[$key]=@end(explode(".",$_FILES['upfile']['name'][$key]));
                        $name[$key]=date("YmdHis_",time()).mt_rand().".".$rsz[$key];
                        
                        if(@move_uploaded_file($_FILES['upfile']['tmp_name'][$key],$uppath.$name[$key])){
                            set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
                            spl_autoload_unregister(array('YiiBase','autoload'));
                            include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
                            spl_autoload_register(array('YiiBase','autoload'));  
                            
                            $inputFileName =$uppath.$name[$key];
                            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                            $loadedSheetNames = $objPHPExcel->getSheetNames();
                            
                            foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                                $objPHPExcel->setActiveSheetIndexByName($loadedSheetName);
                                $sheetDataArr["文件【".$_FILES['upfile']['name'][$key]."】--工作簿【".$loadedSheetName."】"] = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            }
                        }
                    }else{
                        $error.="文件[".$_FILES['upfile']['name'][$key]."]上传失败。<br/>";
                    }
                
                }else{
                    $error.="文件[".$_FILES['upfile']['name'][$key]."]失败。<br/>";
                }
            }
        }if(isset($_FILES['upfile'])&&!is_array($_FILES['upfile']['tmp_name'])){
            if (@is_uploaded_file($_FILES['upfile']['tmp_name'])){
                $ok=0;
                $uppath=PIC_PATH; //文件上传路径
                switch ($_FILES['upfile']['type']) {//其他文件格式可以在下面增加判断
                    case 'application/octet-stream' :  
                    $ok=1;
                    break;
                    case 'application/kset' :  
                    $ok=1;
                    break;
                    case 'application/vnd.ms-excel' :  
                    $ok=1;
                    break;
                    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' :  
                    $ok=1;
                    break;
                }
                if (@$ok!=1){
                    header("Content-type:text/html;charset=utf-8");
                    echo "<script>alert('表格格式不正确,请重试');location.href=location.href;</script>";
                    exit;
                }
                if ($_FILES['upfile']['size']>1024*1024*8){
                    header("Content-type:text/html;charset=utf-8");
                    echo "<script>alert('表格过大,大小请小于8M');location.href=location.href;</script>";
                    exit;
                }
                if($ok=="1" && $_FILES['upfile']['error']=='0'){
                    $rsz=@end(explode(".",$_FILES['upfile']['name']));
                    $name=date("YmdHis_",time()).mt_rand().".".$rsz;
                    
                    if(@move_uploaded_file($_FILES['upfile']['tmp_name'],$uppath.$name)){
                        set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
                        spl_autoload_unregister(array('YiiBase','autoload'));
                        include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
                        spl_autoload_register(array('YiiBase','autoload'));  
                        
                        $inputFileName =$uppath.$name;
                        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                        $loadedSheetNames = $objPHPExcel->getSheetNames();
                        
                        foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                            $objPHPExcel->setActiveSheetIndexByName($loadedSheetName);
                            $sheetDataArr["文件【".$_FILES['upfile']['name']."】--工作簿【".$loadedSheetName."】"] = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                        }
                    }
                }else{
                    $error.="文件[".$_FILES['upfile']['name']."]上传失败。<br/>";
                } 
            }else{
                    $error.="文件[".$_FILES['upfile']['name']."]失败。<br/>";
            }
        }
        $seep=100;
        $viewArr=array(
            1=>"inportSM",
            2=>"inportQR",
            3=>"inportOLD",
            4=>"inportTEST",
            5=>"inportExecl",
            6=>"inportCLASS",
        );
        
        $_view=isset($viewArr[$type])?$viewArr[$type]:$viewArr[1];
        $this->render($_view,array(
            'sheetDataArr'=>$sheetDataArr,
            'seep'=>$seep,
            'error'=>$error,
		));
    }
    /**
	 * 学员导出页
	 */
    public function actionStmp()
	{	        
        $this->render('stmp');
	}
    
    /**
	 * 学院导出页
	 */
    public function actionNp()
	{	        
        $this->render('np');
	}
    
    /**
     * 学员录入表导出筛选条件
     */
    public function ActionOutstudents($type='1')
    {    
        if(!in_array($type,array(1)))throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        $execlType=array(
            1=>"OutExcelstudents",
        );
        $OutExeclAction=$execlType[$type];
       
        if (Yii::app()->request->isPostRequest){
			$criteria=new CDbCriteria;
		
			if(isset($_POST['pid'])&&$_POST['pid']){
				$OArr=Organization::model()->getAllid($_POST['pid']);
				$UArr=User::model()->getAllByOid($OArr);
				$criteria->addInCondition('s_addid', $UArr);
			}else{
				if(Yii::app()->user->role!="4"){
					$uid=Yii::app()->user->id;
					$usermodel=User::model()->findByPk($uid);
					$OArr=Organization::model()->getAllid($usermodel->user_organization);
					$UArr=User::model()->getAllByOid($OArr);
					$criteria->addInCondition('s_addid', $UArr);
				}
			}
			if(isset($_POST['status'])&&$_POST['status'])$criteria->addCondition("s_status  = '{$_POST['status']}' ");
			if(isset($_POST['pc'])&&$_POST['pc']){
				if($_POST['pc']==999){
					$criteria->addCondition("s_pc  = '' or s_pc is NULL ");
				}else{
					$criteria->addCondition("s_pc  = '{$_POST['pc']}' ");
				}
			}
            if(isset($_POST['rpc'])&&$_POST['rpc']){
				if($_POST['rpc']==999){
					$criteria->addCondition("s_rpc  = '' or s_pc is NULL ");
				}else{
					$criteria->addCondition("s_rpc  = '{$_POST['rpc']}' ");
				}
			}
            if(isset($_POST['marktype'])&&$_POST['marktype']){
                $acriteria=new CDbCriteria;
                $acriteria->select="sc_sid,sc_kgmark";
                $acriteria->addCondition("sc_kgmark  is not  NULL "); 
                $acriteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1")';
                $Scoremodels=Score::model()->findAll($acriteria);
                $Sarr=array();
                foreach($Scoremodels as $score)$Sarr[]=$score->sc_sid;
                if($_POST['marktype']==1){
                    $str=$Sarr?'s_id in ('.join(",",$Sarr).') or':'';
                    $criteria->addCondition("{$str} s_enrollment =2");
                }elseif($_POST['marktype']==2){
                    $criteria->addNotInCondition('s_id', $Sarr);
                    $criteria->addCondition("s_enrollment =1");
                }else{
                
                }
                
            }
			if(isset($_POST['studentsids'])&&$_POST['studentsids'])$criteria->addInCondition('s_id', explode(",",$_POST['studentsids']));
			
			$criteria->addCondition("s_isdel  = '1' ");
            $criteria->addCondition("s_stype  = '1' ");
            $orderArr=array(
                "bcu"=>"s_baokaocengci asc",
                "bzu"=>"s_baokaozhuanye asc",
                "stu"=>"s_status asc",
                "tmu"=>"s_addtime asc",
                
                "bcd"=>"s_baokaocengci desc",
                "bzd"=>"s_baokaozhuanye desc",
                "std"=>"s_status desc",
                "tmd"=>"s_addtime desc",
            );
            $order=isset($_POST['order'])?$_POST['order']:"";
            $criteria->order=isset($orderArr[$order])?$orderArr[$order]:"s_addtime asc";
            $criteria->join=" left join es_students_manage on s_id=sm_sid  ";
            $criteria->addCondition("sm_id is NULL  or sm_status =3");
			$models=Students::model()->findAll($criteria);	

            if(isset($_POST['exolodetype'])&&$_POST['exolodetype']==2){
                $arr=array();
                $fp=fopen(DOCUMENTROOT."/explodelog.txt",'w');
                fwrite($fp,iconv("utf-8","gbk","您好，本次导出记录为\r\n"));
                foreach($models as $data){
                    if(file_exists(DOCUMENTROOT.$data->s_headerimg)){
                        $arr[]=DOCUMENTROOT.$data->s_headerimg;
                    }else{
                        fwrite($fp,iconv("utf-8","gbk","{$data->s_name} <{$data->s_credentialsnumber}> 头像照片丢失\r\n "));
                    }
                }
                if($arr){
                    fclose($fp);
                    $arr[]=DOCUMENTROOT."/explodelog.txt";
                    $PHPZip=new PHPZip();
                    $PHPZip->downloadZipByFiles($arr);
                
                }else{
                    header("Content-type:text/html;charset=utf-8");
                    echo '无导出内容';
                    exit;
                }
                exit;
            }
            
			spl_autoload_unregister(array('YiiBase','autoload'));
			include_once(DOCUMENTROOT."/protected/vendors/PHPExcel.php");
			include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
			spl_autoload_register(array('YiiBase','autoload'));     
            $this->$OutExeclAction($models);
		}
    }
    /**
     * 学员管理表导出筛选条件
     */
    public function ActionOutstudentsmanage($type)
    {   

        if(in_array($type,array(1,2,3))){
            if(Yii::app()->user->role!=4&&$type!=3){
                throw new CHttpException(400,'您没有被授权这个操作！   ');
            }
        }elseif(!in_array($type,array(4))){
            throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        }
        // else{
            // throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        // }
        $execlType=array(
            1=>'OutExeclSHDJ',
            2=>"OutExcelCj",
            3=>"OutExcelxyxx",
            4=>"OutExcelxyfzmb",
        );
       $OutExeclAction=$execlType[$type];
        if (Yii::app()->request->isPostRequest){
			$criteria=new CDbCriteria;
            $pid='';
            if(isset($_POST['jigou'])&&$_POST['jigou']){
                $pid=$_POST['jigou'];
            }elseif(isset($_POST['baomingdian'])&&$_POST['baomingdian']){
                $pid=$_POST['baomingdian'];
            }elseif(isset($_POST['pid'])&&$_POST['pid']){
                $pid=$_POST['pid'];
            }
			if($pid){
				$OArr=Organization::model()->getAllid($pid);
				$UArr=User::model()->getAllByOid($OArr);
				$criteria->addInCondition('s_addid', $UArr);
			}else{
				if(Yii::app()->user->role!="4"){
					$uid=Yii::app()->user->id;
					$usermodel=User::model()->findByPk($uid);
					$OArr=Organization::model()->getAllid($usermodel->user_organization);
					$UArr=User::model()->getAllByOid($OArr);
					$criteria->addInCondition('s_addid', $UArr);
				}
			}
			if(isset($_POST['status'])&&$_POST['status'])$criteria->addCondition("s_status  = '{$_POST['status']}' ");
			if(isset($_POST['pc'])&&$_POST['pc']){
				if($_POST['pc']==999){
					$criteria->addCondition("s_pc  = '' or s_pc is NULL ");
				}else{
					$criteria->addCondition("s_pc  = '{$_POST['pc']}' ");
				}
			}
            if(isset($_POST['rpc'])&&$_POST['rpc']){
				if($_POST['rpc']==999){
					$criteria->addCondition("s_rpc  = '' or s_pc is NULL ");
				}else{
					$criteria->addCondition("s_rpc  = '{$_POST['rpc']}' ");
				}
			}
            if(isset($_POST['marktype'])&&$_POST['marktype']){
                $acriteria=new CDbCriteria;
                $acriteria->select="sc_sid,sc_kgmark";
                $acriteria->addCondition("sc_kgmark  is not  NULL "); 
                $acriteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1")';
                $Scoremodels=Score::model()->findAll($acriteria);
                $Sarr=array();
                foreach($Scoremodels as $score)$Sarr[]=$score->sc_sid;
                if($_POST['marktype']==1){
                    $str=$Sarr?'s_id in ('.join(",",$Sarr).') or':'';
                    $criteria->addCondition("{$str} s_enrollment =2");
                }elseif($_POST['marktype']==2){
                    $criteria->addNotInCondition('s_id', $Sarr);
                    $criteria->addCondition("s_enrollment =1");
                }else{
                
                }
                
            }
			if(isset($_POST['studentsids'])&&$_POST['studentsids'])$criteria->addInCondition('s_id', explode(",",$_POST['studentsids']));
			$criteria->with='studentinfo';
			$criteria->addCondition("s_isdel  = '1' ");
            $criteria->addCondition("s_stype  = '1' ");
			$orderArr=array(
                "bcu"=>"s_baokaocengci asc",
                "bzu"=>"s_baokaozhuanye asc",
                "stu"=>"s_status asc",
                "tmu"=>"s_addtime asc",
                
                "bcd"=>"s_baokaocengci desc",
                "bzd"=>"s_baokaozhuanye desc",
                "std"=>"s_status desc",
                "tmd"=>"s_addtime desc",
            );
            $order=isset($_POST['order'])?$_POST['order']:"";
            
            if($type==1){
                $criteria->order="s_baokaocengci asc, s_idbd desc, s_credentialsnumber asc, s_baokaozhuanye asc";
            }else{
                $criteria->order=isset($orderArr[$order])?$orderArr[$order]:"s_addtime asc";
            }
            
			$models=StudentsManage::model()->findAll($criteria);  
            
            if(isset($_POST['exolodetype'])&&$_POST['exolodetype']==2){
            
                $arr=array();
                $fp=fopen(DOCUMENTROOT."/explodelog.txt",'w');
                fwrite($fp,mb_convert_encoding("您好，本次导出记录为\r\n","gbk","utf-8"));
                
                foreach($models as $data){
                    if(file_exists(DOCUMENTROOT.$data->studentinfo->s_headerimg)){
                        $arr[]=DOCUMENTROOT.$data->studentinfo->s_headerimg;
                    }else{
                        fwrite($fp,mb_convert_encoding("{$data->studentinfo->s_name} <{$data->studentinfo->s_credentialsnumber}> 头像照片丢失\r\n ","gbk","utf-8"));
                    }
                }
                if($arr){
                    fclose($fp);
                    $arr[]=DOCUMENTROOT."/explodelog.txt";
                    $PHPZip=new PHPZip();
                    $PHPZip->downloadZipByFiles($arr);
                
                }else{
                    header("Content-type:text/html;charset=utf-8");
                    echo '无导出内容';
                    exit;
                }
                exit;
            }
           

            
            spl_autoload_unregister(array('YiiBase','autoload'));
			include_once(DOCUMENTROOT."/protected/vendors/PHPExcel.php");
			include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
			spl_autoload_register(array('YiiBase','autoload'));         
			
            $this->$OutExeclAction($models);
		}
    }
    
    /**
     * 学员信息表（北航导入用）导出筛选条件
     */
    private function OutExcelstudents($models)
    {
        $templateFile = PIC_PATH.'template/lurutemplate.xls';
		$objPHPExcel = PHPExcel_IOFactory::load($templateFile);
		$objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);            //获取excel中sheet(0)的数据
													 //重新启用YII的自动载入
		
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			->setLastModifiedBy("Maarten Balliauw")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
			->setKeywords("office 2007 openxml php")
			->setCategory("Test result file");

		$Parr=array();
		$pmodels=Professional::model()->getKCCode();
        $pnamemodels=Professional::model()->getKCName();
        
		$nationalityArr=Lookup::model()->getClass('nationality');
		$studentsfromArr=Lookup::model()->getClass('studentsfrom');
		$studentsfromstatusArr=Lookup::model()->getClass('studentsfromstatus');
		$politicalstatusArr=Lookup::model()->getClass('politicalstatus');
		$num=4;
		foreach($models as $val){
			$baokaozhuanye=isset($pmodels[$val->s_baokaozhuanye])?$pmodels[$val->s_baokaozhuanye]:"丢失";
            $baokaozhuanyename=isset($pnamemodels[$val->s_baokaozhuanye])?$pnamemodels[$val->s_baokaozhuanye]:"丢失";
            
			$Address=$val->s_birthaddress;
			
			$Ocode=Yii::app()->cache->get("ocode_{$val->s_addid}");
			if($Ocode==false) {
				$umodel=User::model()->getUserInfoById($val->s_addid);
				$OModel=Organization::model()->getOById($umodel->user_organization);
				if($OModel->o_code){
					$Ocode=$OModel->o_code;
				}else{
					$Ocode=Organization::model()->getCodeById($OModel->o_pid);
				}
				Yii::app()->cache->set("ocode_{$val->s_addid}",$Ocode,Yii::app()->params->cacheTime);
			}
			if(strpos($Address,"省")){
				$ADArr=explode("省",$Address);
				$Address=$ADArr[0]."省";
			}else if(strpos($Address,"市")){
				$ADArr=explode("市",$Address);
				$Address=$ADArr[0]."市";
			}
             
            $Umodel=User::model()->findByPk($val->s_addid);
            $Omodel=Organization::model()->findByPk($Umodel->user_organization);
            $OName=$Omodel->o_id;//$Omodel->o_name."-".$Omodel->o_id;
            if($Umodel->user_role==1){
                $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                $OName=$POmodel->o_id;//$POmodel->o_name."-".$POmodel->o_id;
            }
            $insertNumber="{$OName}".str_pad($val->s_insertid,6,0,STR_PAD_LEFT);
			$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A'.$num,  $insertNumber,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B'.$num,  $Ocode,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C'.$num,  $val->s_baokaocengci, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D'.$num,  $baokaozhuanye, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E'.$num,  $baokaozhuanyename, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('F'.$num,  $val->s_name, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('G'.$num,  Students::$sex[$val->s_sex], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('H'.$num,  Students::$credentialstype[$val->s_credentialstype], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('I'.$num,  $val->s_credentialsnumber, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('J'.$num,  $val->s_birthdate?date("Ymd",$val->s_birthdate):'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('K'.$num,  $nationalityArr[$val->s_nationality], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('L'.$num,  $politicalstatusArr[$val->s_politicalstatus], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('M'.$num,  Students::$highesteducation[$val->s_highesteducation], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('N'.$num,  $val->s_phone, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('O'.$num,  $val->s_email, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('P'.$num,  Students::$profession[$val->s_zhiyezhuangkuang])
				->setCellValueExplicit('Q'.$num,  Students::$marital[$val->s_hunyinzhuangkuang])
				->setCellValueExplicit('R'.$num,  $val->s_familyaddress?$val->s_familyaddress:$val->s_contactaddress, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('S'.$num,  $val->s_gongzuodanwei, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('T'.$num,  $val->s_youbian, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('U'.$num,  $val->s_contactaddress, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('V'.$num,  $val->s_tel, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('W'.$num,  $studentsfromArr[$val->s_sfromaddress], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('X'.$num,  $Address, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('Y'.$num,  $studentsfromstatusArr[$val->s_sfromtype], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('Z'.$num,  $val->s_cjgztime?date("Y-m",$val->s_cjgztime):'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AA'.$num, $val->s_highesteducation!=1?$val->s_oldschool:'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AB'.$num, $val->s_highesteducation!=1?$val->s_oldschoolcode:'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AC'.$num, $val->s_highesteducation!=1?$val->s_oldzhuanye:'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AD'.$num, $val->s_highesteducation!=1&&$val->s_oldtime?date("Y-m",$val->s_oldtime):'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AE'.$num, $val->s_highesteducation!=1?$val->s_oldimgnumber:'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AF'.$num, Students::$enrollment[$val->s_enrollment], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AG'.$num, Students::$study[$val->s_study], PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('AH'.$num, Students::$status[$val->s_status], PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('AI'.$num, $val->s_statusabout, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('AJ'.$num, $val->s_zjtype&&isset(Students::$zjtype[$val->s_zjtype])?Students::$zjtype[$val->s_zjtype]:"", PHPExcel_Cell_DataType::TYPE_STRING);
				$num++;
		}
			$objPHPExcel->getActiveSheet()->setTitle('学员数据');
			$filename = "学员信息导出.xls";
            $this->EndExecl($filename,$objPHPExcel);
    }
    
    /**
     * 学员管理信息表 导出筛选条件
     */
    private function OutExcelxyxx($models)
    {
        $templateFile = PIC_PATH.'template/lurutemplate.xls';
		$objPHPExcel = PHPExcel_IOFactory::load($templateFile);
		$objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);            //获取excel中sheet(0)的数据
													 //重新启用YII的自动载入
		
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			->setLastModifiedBy("Maarten Balliauw")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
			->setKeywords("office 2007 openxml php")
			->setCategory("Test result file");

		$Parr=array();
		$pmodels=Professional::model()->getKCCode();
        $pnamemodels=Professional::model()->getKCName();
        
		$nationalityArr=Lookup::model()->getClass('nationality');
		$studentsfromArr=Lookup::model()->getClass('studentsfrom');
		$studentsfromstatusArr=Lookup::model()->getClass('studentsfromstatus');
		$politicalstatusArr=Lookup::model()->getClass('politicalstatus');
		$num=4;
		foreach($models as $val){
			$baokaozhuanye=isset($pmodels[$val->studentinfo->s_baokaozhuanye])?$pmodels[$val->studentinfo->s_baokaozhuanye]:"丢失";
            $baokaozhuanyename=isset($pnamemodels[$val->studentinfo->s_baokaozhuanye])?$pnamemodels[$val->studentinfo->s_baokaozhuanye]:"丢失";
            
			$Address=$val->studentinfo->s_birthaddress;
			
			$Ocode=Yii::app()->cache->get("ocode_{$val->studentinfo->s_addid}");
			if($Ocode==false) {
				$umodel=User::model()->getUserInfoById($val->studentinfo->s_addid);
				$OModel=Organization::model()->getOById($umodel->user_organization);
				if($OModel->o_code){
					$Ocode=$OModel->o_code;
				}else{
					$Ocode=Organization::model()->getCodeById($OModel->o_pid);
				}
				Yii::app()->cache->set("ocode_{$val->studentinfo->s_addid}",$Ocode,Yii::app()->params->cacheTime);
			}
			if(strpos($Address,"省")){
				$ADArr=explode("省",$Address);
				$Address=$ADArr[0]."省";
			}else if(strpos($Address,"市")){
				$ADArr=explode("市",$Address);
				$Address=$ADArr[0]."市";
			}
             
            $Umodel=User::model()->findByPk($val->studentinfo->s_addid);
            $Omodel=Organization::model()->findByPk($Umodel->user_organization);
            $OName=$Omodel->o_id;
            if($Umodel->user_role==1){
                $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                $OName=$POmodel->o_id;
            }
            $insertNumber="{$OName}".str_pad($val->studentinfo->s_insertid,6,0,STR_PAD_LEFT);
			$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A'.$num,  $insertNumber,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B'.$num,  $Ocode,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C'.$num,  $val->studentinfo->s_baokaocengci, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D'.$num,  $baokaozhuanye, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E'.$num,  $baokaozhuanyename, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('F'.$num,  $val->studentinfo->s_name, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('G'.$num,  Students::$sex[$val->studentinfo->s_sex], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('H'.$num,  Students::$credentialstype[$val->studentinfo->s_credentialstype], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('I'.$num,  $val->studentinfo->s_credentialsnumber, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('J'.$num,  $val->studentinfo->s_birthdate?date("Ymd",$val->studentinfo->s_birthdate):'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('K'.$num,  $nationalityArr[$val->studentinfo->s_nationality], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('L'.$num,  $politicalstatusArr[$val->studentinfo->s_politicalstatus], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('M'.$num,  Students::$highesteducation[$val->studentinfo->s_highesteducation], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('N'.$num,  $val->studentinfo->s_phone, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('O'.$num,  $val->studentinfo->s_email, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('P'.$num,  Students::$profession[$val->studentinfo->s_zhiyezhuangkuang])
				->setCellValueExplicit('Q'.$num,  Students::$marital[$val->studentinfo->s_hunyinzhuangkuang])
				->setCellValueExplicit('R'.$num,  $val->studentinfo->s_familyaddress?$val->studentinfo->s_familyaddress:$val->studentinfo->s_contactaddress, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('S'.$num,  $val->studentinfo->s_gongzuodanwei, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('T'.$num,  $val->studentinfo->s_youbian, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('U'.$num,  $val->studentinfo->s_contactaddress, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('V'.$num,  $val->studentinfo->s_tel, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('W'.$num,  $studentsfromArr[$val->studentinfo->s_sfromaddress], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('X'.$num,  $Address, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('Y'.$num,  $studentsfromstatusArr[$val->studentinfo->s_sfromtype], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('Z'.$num,  $val->studentinfo->s_cjgztime?date("Y-m",$val->studentinfo->s_cjgztime):'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AA'.$num, $val->studentinfo->s_highesteducation!=1?$val->studentinfo->s_oldschool:'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AB'.$num, $val->studentinfo->s_highesteducation!=1?$val->studentinfo->s_oldschoolcode:'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AC'.$num, $val->studentinfo->s_highesteducation!=1?$val->studentinfo->s_oldzhuanye:'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AD'.$num, $val->studentinfo->s_highesteducation!=1&&$val->studentinfo->s_oldtime?date("Y-m",$val->studentinfo->s_oldtime):'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AE'.$num, $val->studentinfo->s_highesteducation!=1?$val->studentinfo->s_oldimgnumber:'', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AF'.$num, Students::$enrollment[$val->studentinfo->s_enrollment], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('AG'.$num, Students::$study[$val->studentinfo->s_study], PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('AH'.$num, Students::$status[$val->studentinfo->s_status], PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('AI'.$num, $val->studentinfo->s_statusabout, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('AJ'.$num, $val->sm_bmorder, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('AK'.$num, StudentsManage::$status[$val->sm_status], PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('AL'.$num, $val->sm_statusabout, PHPExcel_Cell_DataType::TYPE_STRING);
				$num++;
		}
			$objPHPExcel->getActiveSheet()->setTitle('学员数据');
			$filename = "学员信息导出.xls";
            $this->EndExecl($filename,$objPHPExcel);
    }
    
    
    
    /**
     * 学员审核登记表格式
     */
    private function OutExeclSHDJ($models)
    {
        $templateFile = PIC_PATH.'template/shdjtemplate.xls';
        $objPHPExcel = PHPExcel_IOFactory::load($templateFile);
        $objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
            
        $num=7;
        $i=1;
        $pmodels=Professional::model()->getKCName();
        $professionallevelArr=Lookup::model()->getClass('professionallevel');
        $bdtype = array(
            '1'=>"未分配",
            '2'=>"",
            '3'=>"本地",
        );
        foreach($models as $val){
            $baokaocenci=isset($professionallevelArr[$val->studentinfo->s_baokaocengci])?$professionallevelArr[$val->studentinfo->s_baokaocengci]:"丢失";
            $baokaozhuanye=isset($pmodels[$val->studentinfo->s_baokaozhuanye])?$pmodels[$val->studentinfo->s_baokaozhuanye]:"丢失";
            
            $Umodel=User::model()->findByPk($val->studentinfo->s_addid);
            $Omodel=Organization::model()->findByPk($Umodel->user_organization);
            $OName=$Omodel->o_id;
            if($Umodel->user_role==1){
                $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                $OName=$POmodel->o_id;
            }
            $insertNumber="{$OName}".str_pad($val->studentinfo->s_insertid,6,0,STR_PAD_LEFT);
            
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit('A'.$num,  $num-6,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B'.$num,  $val->sm_bmorder, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C'.$num,  $val->studentinfo->s_name, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D'.$num,  $val->studentinfo->s_credentialsnumber, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('E'.$num,  $baokaocenci ,PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('F'.$num,  $baokaozhuanye, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('G'.$num,  $val->studentinfo->s_highesteducation!=1?$val->studentinfo->s_oldschool:'', PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('H'.$num,  $val->studentinfo->s_highesteducation!=1&&$val->studentinfo->s_oldtime?date("Y-m",$val->studentinfo->s_oldtime):'', PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('I'.$num,  $val->studentinfo->s_highesteducation!=1?$val->studentinfo->s_oldimgnumber:'', PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('J'.$num,  $val->studentinfo->s_highesteducation!=1&&$val->studentinfo->s_zsbzm?"有":"", PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('K'.$num,  $bdtype[$val->studentinfo->s_idbd], PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('M'.$num,  $insertNumber, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('N'.$num,  isset(Students::$zjtype[$val->studentinfo->s_zjtype])?Students::$zjtype[$val->studentinfo->s_zjtype]:"", PHPExcel_Cell_DataType::TYPE_STRING);
				$num++;
		}
		$objPHPExcel->getActiveSheet()->setTitle('学员审核');
		$filename = "学员审核登记表.xls";
		$this->EndExecl($filename,$objPHPExcel);
    
    }
    
    /**
     * 学员成绩表格式
     */
    private function OutExcelCj($models)
    {
	    $templateFile = PIC_PATH.'template/cjtemplate.xlsx';
        $objPHPExcel = PHPExcel_IOFactory::load($templateFile);
        $objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);  
        
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
            
        $num=3;
        
              
        
        $rxkPcArr=Pici::model()->getAllPC(true,false);
        foreach($models as $val){
        
            $Oname=Yii::app()->cache->get("oname_{$val->studentinfo->s_addid}");
			if($Oname==false) {
				$umodel=User::model()->getUserInfoById($val->studentinfo->s_addid);
				$OModel=Organization::model()->getOById($umodel->user_organization);
				if($OModel->o_code){
					$Oname=$OModel->o_name;
				}else{
					$Oname=Organization::model()->getOById($OModel->o_pid,'o_name');
				}
				Yii::app()->cache->set("oname_{$val->studentinfo->s_addid}",$Oname,Yii::app()->params->cacheTime);
			}
            $professionallevelArr=Lookup::model()->getClass('professionallevel');
            $baokaocenci=isset($professionallevelArr[$val->studentinfo->s_baokaocengci])?$professionallevelArr[$val->studentinfo->s_baokaocengci]:"丢失";
            $scModel=Score::model()->find("sc_sid = '{$val->sm_sid}' and sc_status!=0 and sc_isdel=1 order by sc_kgmark  desc ");
            $fs=$val->studentinfo->s_enrollment==1?$scModel?$scModel->sc_kgmark:"缺考":"免试";
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit('A'.$num,  $num-2,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B'.$num,  $val->sm_bmorder, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C'.$num,  $val->studentinfo->s_name, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D'.$num,  isset($rxkPcArr[$val->studentinfo->s_pc])?$rxkPcArr[$val->studentinfo->s_pc]:$val->studentinfo->s_pc."", PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('H'.$num,  $fs, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E'.$num,  $baokaocenci, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('F'.$num,  $val->studentinfo->s_credentialsnumber, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('G'.$num,  $Oname, PHPExcel_Cell_DataType::TYPE_STRING);
				$num++;
		}
		$objPHPExcel->getActiveSheet()->setTitle('学员成绩');
		$filename = "学员成绩表.xls";
		$this->EndExecl($filename,$objPHPExcel);    
    }
    
    /**
     * 学员管理信息表 导出筛选条件
     */
    private function OutExcelxyfzmb($models)
    {
        $templateFile = PIC_PATH.'template/xyfztemplate.xlsx';
		$objPHPExcel = PHPExcel_IOFactory::load($templateFile);
		$objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);            //获取excel中sheet(0)的数据
													 //重新启用YII的自动载入
		
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			->setLastModifiedBy("Maarten Balliauw")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
			->setKeywords("office 2007 openxml php")
			->setCategory("Test result file");

		$Parr=array();
		$pmodels=Professional::model()->getKCCode();
        $pnamemodels=Professional::model()->getKCName();
        
		$nationalityArr=Lookup::model()->getClass('nationality');
		$studentsfromArr=Lookup::model()->getClass('studentsfrom');
		$studentsfromstatusArr=Lookup::model()->getClass('studentsfromstatus');
		$politicalstatusArr=Lookup::model()->getClass('politicalstatus');
		$num=2;
        $professionallevelArr=Lookup::model()->getClass('professionallevel');
        // echo count($models);echo "v";exit;
		foreach($models as $val){
			$baokaocenci=isset($professionallevelArr[$val->studentinfo->s_baokaocengci])?$professionallevelArr[$val->studentinfo->s_baokaocengci]:"丢失";
            $baokaozhuanyename=isset($pnamemodels[$val->studentinfo->s_baokaozhuanye])?$pnamemodels[$val->studentinfo->s_baokaozhuanye]:"丢失";
            
			
			$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A'.$num,  $num-1,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B'.$num,  substr($val->sm_bmorder,1),  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C'.$num,  $val->studentinfo->s_name, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D'.$num,  $val->studentinfo->s_credentialsnumber, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E'.$num,  $baokaozhuanyename, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('F'.$num,  $baokaocenci, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('H'.$num,  $val->sm_class, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('G'.$num,  $val->studentinfo->s_rpc, PHPExcel_Cell_DataType::TYPE_STRING);
				$num++;
		}
			$objPHPExcel->getActiveSheet()->setTitle('学员数据');
			$filename = "学员信息导出.xls";
            $this->EndExecl($filename,$objPHPExcel);
    }
    
    /**
     * Execl导出下载
     */
    private function EndExecl($filename,$objPHPExcel){
        header('Content-Type: application/vnd.ms-excel');
		$ua = $_SERVER["HTTP_USER_AGENT"];
		$encoded_filename = urlencode($filename);
		$encoded_filename = str_replace("+", "%20", $encoded_filename);
		header('Content-Type: application/octet-stream');
		if (preg_match("/MSIE/", $ua)) {  
		header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
		} else if (preg_match("/Firefox/", $ua)) {
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
		} else {  
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		}
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
    
    }
    /**
     * 成绩汇总导出
     */
    public function actionOutExcelhz()
    { 
        spl_autoload_unregister(array('YiiBase','autoload'));
		include_once(DOCUMENTROOT."/protected/vendors/PHPExcel.php");
		include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
		spl_autoload_register(array('YiiBase','autoload')); 
        $criteria=new CDbCriteria;
        foreach($_POST as $key=>$val){
            $val = addslashes($val);
            if($key=="searchid"&&$val&&$val!="ID..")$criteria->addCondition("es_id  = '{$val}' ");
            if($key=="name"&&$val&&$val!="姓名..")$criteria->addCondition("es_name  regexp '{$val}' ");
            if($key=="number"&&$val&&$val!="学号..")$criteria->addCondition("es_stuid  regexp '{$val}' ");
            if($key=="card"&&$val&&$val!="身份证..")$criteria->addCondition("es_cardnumber  regexp '{$val}' ");
            if($key=="pici"&&$val&&$val!="批次..")$criteria->addCondition("es_pici  regexp '{$val}' ");
            if($key=="zhongxin"&&$val&&$val!="中心..")$criteria->addCondition("es_kaodian  regexp '{$val}' ");
        }
        $criteria->select="*,COUNT(  `es_stuid` )  as es_id";
        $criteria->order="es_id desc, es_stuid asc"; 
        $criteria->group="`es_stuid` ,  `es_kemu` ,`es_pici`,`es_zy`,`es_kaodian`,`es_cardnumber`,`es_name`";
        $models=Execlscore::model()->findAll($criteria);
	    $templateFile = PIC_PATH.'template/hbtemplate.xls';
        $objPHPExcel = PHPExcel_IOFactory::load($templateFile);
        $objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);  
        
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
           
        $num=2;
        foreach($models as $val){
            $centci="";
            if(strpos($val->es_zy,"高起专")){
                $centci="高起专";
            }
            if(strpos($val->es_zy,"专升本")){
                $centci="专升本";
            }
            $str="";
            if($val->es_id>1){
                $str.="数据ID：";
                $criteria=new CDbCriteria;
                $criteria->addCondition("es_stuid = '{$val->es_stuid}'");
                $criteria->addCondition("es_kemu = '{$val->es_kemu}'");
                $criteria->addCondition("es_pici = '{$val->es_pici}'");
                $criteria->addCondition("es_zy = '{$val->es_zy}'");
                $criteria->addCondition("es_kaodian = '{$val->es_kaodian}'");
                $criteria->addCondition("es_cardnumber = '{$val->es_cardnumber}'");
                $criteria->addCondition("es_name = '{$val->es_name}'");
                $models=Execlscore::model()->findAll($criteria);
                foreach($models as $k=>$v)$str.=$v->es_id."|";
            }
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit('A'.$num,  $val->es_stuid,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B'.$num,  $val->es_name, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C'.$num,  $val->es_pici, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D'.$num,  $val->es_zy, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E'.$num,  $centci, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('F'.$num,  $val->es_kemu, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('G'.$num,  $val->es_score,PHPExcel_Cell_DataType::TYPE_NUMERIC)
				->setCellValueExplicit('H'.$num,  $val->es_kaodian, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('J'.$num,  $val->es_id, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('K'.$num,  $str, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('L'.$num,  "来源：".$val->es_execlname, PHPExcel_Cell_DataType::TYPE_STRING);
				$num++;
		}
		$objPHPExcel->getActiveSheet()->setTitle('学员成绩');
		$filename = "合并成绩表.xls";
		$this->EndExecl($filename,$objPHPExcel);    
    }
    /**
     * 成绩汇总导出
     */
    public function actionOutExceldfb()
    { 
        spl_autoload_unregister(array('YiiBase','autoload'));
		include_once(DOCUMENTROOT."/protected/vendors/PHPExcel.php");
		include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
		spl_autoload_register(array('YiiBase','autoload')); 
        $criteria=new CDbCriteria;
        foreach($_POST as $key=>$val){
            $val = addslashes($val);
            if($key=="searchid"&&$val&&$val!="ID..")$criteria->addCondition("es_id  = '{$val}' ");
            if($key=="name"&&$val&&$val!="姓名..")$criteria->addCondition("es_name  regexp '{$val}' ");
            if($key=="number"&&$val&&$val!="学号..")$criteria->addCondition("es_stuid  regexp '{$val}' ");
            if($key=="card"&&$val&&$val!="身份证..")$criteria->addCondition("es_cardnumber  regexp '{$val}' ");
            if($key=="pici"&&$val&&$val!="批次..")$criteria->addCondition("es_pici  regexp '{$val}' ");
            if($key=="zhongxin"&&$val&&$val!="中心..")$criteria->addCondition("es_kaodian  regexp '{$val}' ");
        }
        $criteria->select="*,COUNT(  `es_stuid` )  as es_id";
        $criteria->order="es_id desc, es_stuid asc"; 
        $criteria->group="`es_stuid` ,  `es_kemu` ,`es_pici`,`es_zy`,`es_kaodian`,`es_cardnumber`,`es_name`";
        $models=Execlscore::model()->findAll($criteria);
	    $templateFile = PIC_PATH.'template/hbtemplate.xls';
        $objPHPExcel = new PHPExcel();
        $objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);  
        
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
           
        $num=2;
        $StuArr=$order=array();
        foreach($models as $val){
            $order[$val->es_kaodian]=isset($order[$val->es_kaodian])?$order[$val->es_kaodian]:array();
            $order[$val->es_kaodian]=isset($order[$val->es_kaodian])?$order[$val->es_kaodian]:1;
            $orderarr=$order[$val->es_kaodian];
            $orderarr[$val->es_kemu]=isset($orderarr[$val->es_kemu])?$orderarr[$val->es_kemu]:1; 
            if(isset($StuArr[$val->es_kaodian])&&isset($StuArr[$val->es_kaodian][$val->es_kemu])&&isset($StuArr[$val->es_kaodian][$val->es_kemu][$orderarr[$val->es_kemu]])&&count($StuArr[$val->es_kaodian][$val->es_kemu][$orderarr[$val->es_kemu]])>=30){
                $orderarr[$val->es_kemu]=$orderarr[$val->es_kemu]+=1;
            }
            $StuArr[$val->es_kaodian][$val->es_kemu][$orderarr[$val->es_kemu]][]=$val->attributes;
            
        }
        foreach($StuArr as $bmd=>$bmdArr){
            foreach($bmdArr as $kmname=>$kmArr){
                foreach($kmArr as $kcmodel){
                
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->mergeCells("A".($num+2).":G".($num+2))
                    ->mergeCells("A".($num+4).":C".($num+4))
                    ->mergeCells("A".($num+3).":C".($num+3))
                    ->mergeCells("D".($num+4).":G".($num+4))
                    ->mergeCells("D".($num+3).":G".($num+3))
                    ->mergeCells("A".($num+39).":G".($num+39))
                    ->mergeCells("A".($num+37).":G".($num+37))
                    ->mergeCells("A".($num+38).":G".($num+38));
                    
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(6);
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(8);
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(30);
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(12);
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(10);
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(22);
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);
                    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(10); 

                    // $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(8);
                    // $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(8); 
                    // $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('A')->setWidth(15);
                    // $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('B')->setWidth(10);
                    // $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('C')->setWidth(12);
                    // $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('D')->setWidth(40);
                    // $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('E')->setWidth(10);
                    // $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('F')->setWidth(25);
                    // $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('G')->setWidth(10);
                    // $objPHPExcel->setActiveSheetIndex(1)->getColumnDimension('H')->setWidth(30); 
                    // exit;
                    $objPHPExcel->setActiveSheetIndex(0)->getRowDimension($num+2)->setRowHeight(70); 
                    $objPHPExcel->setActiveSheetIndex(0)->getRowDimension($num+39)->setRowHeight(30); 
                    // $objPHPExcel->setActiveSheetIndex(0)->getRowDimension($num+40)->setRowHeight(20); 
                    
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle("A".($num+1).":H".($num+40))->getFont()->setSize(9); 
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle("A".($num+2))->getFont()->setSize(20); 
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle("A".($num+39))->getFont()->setSize(10); 
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle("G".($num+1))->getFont()->setSize(8); 
                    
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($num+5).':H'.($num+36))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle("A".($num+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($num+2).':G'.($num+2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($num+39).':G'.($num+39))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $BlackstyleThinBlackBorderOutline = array(
                     'borders' => array(
                      'allborders' => array(
                       'style' => PHPExcel_Style_Border::BORDER_THIN,
                       'color' => array('argb' => 'FF000000'),
                      ),
                     ),
                    );
                    $WhitestyleThinBlackBorderOutline = array(
                     'borders' => array(
                      'allborders' => array(
                       'style' => PHPExcel_Style_Border::BORDER_THIN,
                       'color' => array('argb' => 'FFFFFFFF'),
                      ),
                     ),
                    );
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($num+5).':G'.($num+36))->applyFromArray($BlackstyleThinBlackBorderOutline); 
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($num-2).':G'.($num+4))->applyFromArray($WhitestyleThinBlackBorderOutline); 
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($num+36).':G'.($num+40))->applyFromArray($WhitestyleThinBlackBorderOutline);
                    
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($num+39).':G'.($num+39))->getAlignment()->setWrapText(true);
                    
                    // $time = date("Y-m-d",$Eamodel->ea_date)." ".Examinationarrangement::$examtimeArr[$Eamodel->ea_examtime][0]." ~ ";
                    // $time.= date("Y-m-d",$Eamodel->ea_date)." ".Examinationarrangement::$examtimeArr[$Eamodel->ea_examtime][1];
                    
                    // $Oname=User::model()->getCnameByUid($val->a_belongid);
                    // $kcname=Course::model()->getKCById($Eamodel->ea_courseid);
                    // $mark=$val->a_mark?"({$val->a_mark})":"";
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValueExplicit('A'.($num+1),  "",  PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('A'.($num+2),  $val->es_pici."学期课程考试考生考场记录",  PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('A'.($num+3),  '学习中心：'.$bmd,  PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('D'.($num+3),  '课程名称：'.$kmname, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('A'.($num+4),  '考试时间：', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('D'.($num+4),  '考试地点：', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('A'.($num+5),  "座号", PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('B'.($num+5),  '批次', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('C'.($num+5),  '专业', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('D'.($num+5),  '学号', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('E'.($num+5),  '姓名', PHPExcel_Cell_DataType::TYPE_STRING)
                        // ->setCellValueExplicit('F'.($num+5),  '证件号', PHPExcel_Cell_DataType::TYPE_STRING)
                        // ->setCellValueExplicit('G'.($num+5),  '考生签名', PHPExcel_Cell_DataType::TYPE_STRING)
                        // ->setCellValueExplicit('H'.($num+5),  '成绩', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('F'.($num+5),  '考生签名', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('G'.($num+5),  '成绩', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('A'.($num+37),  '实到人数：___________________      监考员：______________________________________________', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('A'.($num+38),  '阅卷教师：_________________   成绩登录：_________________   成绩审核：___________________', PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('A'.($num+39),  "注：监考人员要求到场学院在签名处签名，开考30分钟后，监考人员填写此表，未到场学生姓名后画“×”\n\t考试结束，此表放入试卷袋内密封", PHPExcel_Cell_DataType::TYPE_STRING);
                    foreach($kcmodel as $stukey=>$stu){
                            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValueExplicit('A'.($num+$stukey+6),  $stukey+1, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicit('B'.($num+$stukey+6),  $stu['es_pici'], PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicit('C'.($num+$stukey+6),  $stu['es_zy'], PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicit('D'.($num+$stukey+6),  $stu['es_stuid'], PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicit('E'.($num+$stukey+6),  $stu['es_name'], PHPExcel_Cell_DataType::TYPE_STRING)
                            // ->setCellValueExplicit('F'.($num+$stukey+6),  $stu->es_cardnumber, PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicit('F'.($num+$stukey+6),  "", PHPExcel_Cell_DataType::TYPE_STRING)
                            ->setCellValueExplicit('G'.($num+$stukey+6),  "", PHPExcel_Cell_DataType::TYPE_STRING);
                        // $num1++;
                        // ->setCellValueExplicit('C'.($num+$stukey+5),  '专业', PHPExcel_Cell_DataType::TYPE_STRING)
                        // ->setCellValueExplicit('D'.($num+$stukey+5),  '学号', PHPExcel_Cell_DataType::TYPE_STRING)
                        // ->setCellValueExplicit('E'.($num+$stukey+5),  '姓名', PHPExcel_Cell_DataType::TYPE_STRING)
                        // ->setCellValueExplicit('F'.($num+$stukey+5),  '证件号', PHPExcel_Cell_DataType::TYPE_STRING)
                        // ->setCellValueExplicit('G'.($num+$stukey+5),  '考生签名', PHPExcel_Cell_DataType::TYPE_STRING)
                        // ->setCellValueExplicit('H'.($num+$stukey+5),  '成绩', PHPExcel_Cell_DataType::TYPE_STRING);
                    
                    }
                   $num+=42;
                }
            }
			
		}
        // exit;
		$objPHPExcel->getActiveSheet()->setTitle('签到表');
		$filename = "签到表.xls";
		$this->EndExecl($filename,$objPHPExcel);    
    }
  
}