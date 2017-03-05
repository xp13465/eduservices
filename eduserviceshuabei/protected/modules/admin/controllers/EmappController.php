<?php
class EmappController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','add','create','edit','delall','outemapp'),
				'users'=>array('@'),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('auditck','shedit',),
				'users'=>User::model()->getManage(5),
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
	public function actionView()
	{ 
        $id=$_GET['id'];
		$this->render('view',array(
			'model'=>$id?$this->loadModel($id):array(), 
		));
	}
    /**
	 * 添加与修改共用的字段赋值函数.
	 */
    private function voluation($model){ 
            // $model->attributes=$_POST; ////以下在字段在修改中数据丢失，必须单条追加
            $model->setAttribute("mk_cardtype",$_POST['mk_cardtype']); 
            $model->setAttribute("mk_cardnumber",$_POST['mk_cardnumber']);
            $model->setAttribute("mk_xh",$_POST['mk_xh']);
            $model->setAttribute("mk_sname",$_POST['mk_sname']);
            $model->setAttribute("mk_sex",$_POST['mk_sex']);
            $model->setAttribute("mk_ethnic",$_POST['mk_ethnic']);
            $model->setAttribute("mk_sdgx",$_POST['mk_sdgx']);
            $model->setAttribute("mk_specialty",$_POST['mk_specialty']);
            $model->setAttribute("mk_moblie",$_POST['mk_moblie']);
            $model->setAttribute("mk_tel",$_POST['mk_tel']);
            $model->setAttribute("mk_subject",$_POST['mk_subject']);
            $model->setAttribute("mk_file",$_POST['mk_file']);
            $model->setAttribute("mk_cardimg",$_POST['mk_cardimg']);
            $mk_reason =array(1=>"0",2=>"0",3=>"0",4=>"0",5=>"0",6=>"0",7=>"0");
            foreach($_POST['mk_reason'] as $val){
                 if(isset($mk_reason[$val]))$mk_reason[$val]=1;
            }
            $model->setAttribute("mk_reason",serialize($mk_reason));
             // 排除添了数据,又去除勾选的垃圾字段值
            if($mk_reason[2]==1||$mk_reason[4]==1){        
                 $model->setAttribute("mk_ksadder",$_POST['mk_ksadder']);
                 $model->setAttribute("mk_ksnf",$_POST['mk_ksnf']);
                 $model->setAttribute("mk_zstype",$_POST['mk_zstype']);
                 $model->setAttribute("mk_zkznum",$_POST['mk_zkznum']);
                 $model->setAttribute("mk_zjnum",$_POST['mk_zjnum']);
            }else{
                 $model->setAttribute("mk_ksadder",' ');
                 $model->setAttribute("mk_ksnf",'');
                 $model->setAttribute("mk_zstype",'');
                 $model->setAttribute("mk_zkznum",'');
                 $model->setAttribute("mk_zjnum",'');
            }
            //根据判断是否新建来赋值非共用字段
            if($model->isNewRecord){
                $model->setAttribute("mk_addid",Yii::app()->user->id);
                $model->setAttribute("mk_addtime",time());
                
            }else{
                if(Yii::app()->user->role==5||in_array(Yii::app()->user->id,array(1,2))){//权限4,5非监管中心才能审核
                $model->setAttribute("mk_status",$_POST['mk_status']?$_POST['mk_status']:1);
                $model->setAttribute("mk_statusabout",$_POST['mk_statusabout']?$_POST['mk_statusabout']:'');
                }
                $model->setAttribute("mk_isdel",1);//恢复删除的
                $model->setAttribute("mk_editid",Yii::app()->user->id);
                $model->setAttribute("mk_editime",time());
            }
            return $model;
    }
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd()
	{ 
        if(!in_array(Yii::app()->user->role,array(1,2,3)))throw new CHttpException(404,'无效的请求。请不要再这样的要求。');
		$model=new Emapp;
        if(isset($_GET["mksid"])){
            $mksid=$_GET["mksid"];
            $smodel=Students::model()->findByPk($mksid);
            $smModel=StudentsManage::model()->find("sm_sid ='{$mksid}'");
            
            if($smodel){
                $model->mk_sid=$smodel->s_id;
                $model->mk_sname= $smodel->s_name;
                $model->mk_cardtype=$smodel->s_credentialstype;
                $model->mk_cardnumber=$smodel->s_credentialsnumber;
                $model->mk_cardimg=$smodel->s_credentialsimg1;
                $model->mk_xh=mb_substr($smModel->sm_bmorder,1);     
                $model->mk_sex=$smodel->s_sex;
                $model->mk_ethnic=$smodel->s_nationality;
                $model->mk_specialty=$smodel->s_baokaozhuanye;
                $model->mk_moblie=$smodel->s_phone;
                $model->mk_tel=$smodel->s_tel;
            }
        }
        
		if(!empty($_POST))
		{
		   $countp=count(Emapp::model()->find("mk_cardnumber='{$_POST["mk_cardnumber"]}' and mk_subject='{$_POST["mk_subject"]}'"));
			if($countp>0){
                Yii::app()->user->setFlash("message","已存在相同证件号及免考科目的学员");
				$this->redirect(array('index'));	exit;
            }			
			$counxh=count(Emapp::model()->find("mk_xh='{$_POST["mk_xh"]}' and mk_subject='{$_POST["mk_subject"]}'"));
			if($counxh>0){
                Yii::app()->user->setFlash("message","已存在相同学号及免考科目的学员");
				$this->redirect(array('index'));exit;
            }
            $model=$this->voluation($model);           
			if($model->save()){
                Yii::app()->user->setFlash("message","添加成功");
				$this->redirect(array('view','id'=>$model->mk_id));
            }
		}
		$this->render('add',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 */
	public function actionEdit($id)
	{   
		$model=$this->loadModel($id);
		if(!empty($_POST))
		{
            $model=$this->voluation($model);
			if($model->save())
                Yii::app()->user->setFlash("message","修改成功");
				$this->redirect(array('view','id'=>$model->mk_id));
		}
		$this->render('edit',array(
			'model'=>$model,
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
           $criteria->addInCondition('mk_id', $_POST['selectdel']);
           $str=Yii::app()->user->role==4?"":"and mk_isdel = 1 and mk_status !=2 ";
           $count =Emapp::model()->updateAll(array('mk_isdel'=>$tid,'mk_deltime'=>time()),"mk_id in ( ".join(",",$_POST['selectdel'])." ) {$str}"); 
           if($count>0)echo "ok";
       }
       else
       throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
   }
   
	/**
	 * 免考申请列表.
	 */
	public function actionIndex()
	{
        $criteria=new CDbCriteria;
        if(Yii::app()->user->role!="5"&&!in_array(Yii::app()->user->id,array(1,2))){
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->getUserInfoById($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			$criteria->addInCondition('mk_addid', $UArr);
		}
		foreach($_GET as $key=>$val){
            $val = addslashes($val);
			if($key=="mk_sfztype"&&$val&&$val!="证件类型")$criteria->addCondition("mk_sfztype  ={$val} ");
			if($key=="mk_sfz"&&$val&&$val!="证件号码..")$criteria->addCondition("mk_sfz regexp '{$val}' ");
			if($key=="mk_xh"&&$val&&$val!="学号..")$criteria->addCondition("mk_xh  regexp '{$val}' ");
            if($key=="mk_sname"&&$val&&$val!="姓名..")$criteria->addCondition("mk_sname  regexp '{$val}' ");
            if($key=="mk_moblie"&&$val&&$val!="手机..")$criteria->addCondition("mk_moblie  regexp '{$val}' ");
            if($key=="mk_subject"&&$val&&$val!="请选择免考科目")$criteria->addCondition("mk_subject  regexp '{$val}' ");
		}
        if(Yii::app()->user->role==4){
			$isdelStr=isset($_GET['mk_isdel'])&&$_GET['mk_isdel']=='2'?'2':"1";
			$criteria->addCondition("mk_isdel  = '{$isdelStr}' ");
		}else{
			$criteria->addCondition("mk_isdel  = '1' ");
		}
        
        $orderArr=array(
			"azy"=>"mk_specialty asc",
			"bzu"=>"mk_status asc",			
			"bzy"=>"mk_specialty desc",
			"bzd"=>"mk_status desc",
		);
         
        $order=isset($_GET['order'])?$_GET['order']:"";
		$criteria->order=isset($orderArr[$order])?$orderArr[$order]:"mk_addtime asc";
        $pageSize=isset($_COOKIE['mkgl_pagesize'])?$_COOKIE['mkgl_pagesize']:"20";
		$dataProvider =  new CActiveDataProvider("Emapp", array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$pageSize
            ),
		));		
   
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}   
    
   //免考审核列表
   public function actionAuditck()
	{        
        $criteria=new CDbCriteria;
		foreach($_GET as $key=>$val){
            $val = addslashes($val);
			if($key=="mk_sfztype"&&$val&&$val!="证件类型")$criteria->addCondition("mk_sfztype  ={$val} ");
			if($key=="mk_sfz"&&$val&&$val!="证件号码..")$criteria->addCondition("mk_sfz regexp '{$val}' ");
			if($key=="mk_xh"&&$val&&$val!="学号..")$criteria->addCondition("mk_xh  regexp '{$val}' ");
            if($key=="mk_sname"&&$val&&$val!="姓名..")$criteria->addCondition("mk_sname  regexp '{$val}' ");
            if($key=="mk_moblie"&&$val&&$val!="手机..")$criteria->addCondition("mk_moblie  regexp '{$val}' ");
            if($key=="mk_subject"&&$val&&$val!="请选择免考科目")$criteria->addCondition("mk_subject  regexp '{$val}' ");
		}         
        $criteria->addCondition("mk_isdel  = '1' ");
        $criteria->addCondition("mk_status  = '1' ");
        $pageSize=isset($_COOKIE['m_pagesize'])?$_COOKIE['m_pagesize']:"20";
		setcookie("shenhereturnurl",$_SERVER['REQUEST_URI'],0,"/");
		$dataProvider =  new CActiveDataProvider("Emapp", array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pageSize
			),
		));		
       
		$this->render('auditck',array(
			'dataProvider'=>$dataProvider,
		));
	} 
    
    /**
      *免考审核操作
	 */     
	public function actionShedit($id)
	{   
		$model=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model); 
		if(!empty($_POST))
		{        
			$model->attributes=$_POST;
            //以下在字段在修改中数据丢失，必须单条追加
            $model->mk_editid=Yii::app()->user->id;
            $model->mk_statustime=time();
            $model->setAttribute("mk_statusabout",$_POST['mk_statusabout']);
			if($model->mk_cardimg&&file_exists(DOCUMENTROOT.$model->mk_cardimg)){
                $Arr=explode("/",$model->mk_cardimg);
                if(in_array("SF1",$Arr)){
                    $filename=time().substr( $model->mk_cardimg , strrpos($model->mk_cardimg ,'/')+1 );
                    if(copy(DOCUMENTROOT.$model->mk_cardimg,PIC_PATH.$filename)){
                         $model->mk_cardimg=PIC_URL.$filename;
                    }
                }
            }
			if($model->save()){
                if($model->mk_status=='2'){
                    if($model->mk_cardimg){
                        $checkHD=Files::model()->SaveFile($model->mk_cardimg,$model->mk_cardnumber."_sf",8,$model->mk_addid);
                        if($checkHD){
                            $model->mk_cardimg=$checkHD;
                        }
                    }
                }
                $model->save();
                Yii::app()->user->setFlash("message","审核成功");
				$this->redirect(array('auditck'));
            }
		}
		$this->render('shedit',array(
			'model'=>$model,
		));
	}
    
    /**
     * 免考申请表导出筛选条件
     */
    public function ActionOutemapp()
     {
       $OutExeclAction="OutExcelemapp";       
        if (Yii::app()->request->isPostRequest){
			$criteria=new CDbCriteria;
			if(isset($_POST['mk_cardtype'])&&$_POST['mk_cardtype'])$criteria->addCondition("mk_cardtype  = '{$_POST['mk_cardtype']}' ");
			if(isset($_POST['mk_subject'])&&$_POST['mk_subject'])$criteria->addCondition("mk_subject  = '{$_POST['mk_subject']}' ");
            if(isset($_POST['mk_status'])&&$_POST['mk_status'])$criteria->addCondition("mk_status  = '{$_POST['mk_status']}' ");
			if(Yii::app()->user->role!=4&&Yii::app()->user->role!=5){
                   $criteria->addCondition("mk_addid=".Yii::app()->user->id);
            }
            $criteria->addCondition("mk_isdel  = '1' ");
            $criteria->order="mk_addtime asc";
			$models=Emapp::model()->findAll($criteria);
			spl_autoload_unregister(array('YiiBase','autoload'));
			include_once(DOCUMENTROOT."/protected/vendors/PHPExcel.php");
			include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
			spl_autoload_register(array('YiiBase','autoload'));
            $this->$OutExeclAction($models);
		}
    }    
    
    /**
     * 免考管理表导出筛选条件
     */
    private function OutExcelemapp($models)
    {
        $templateFile = PIC_PATH.'template/mkaotemplate.xls';
		$objPHPExcel = PHPExcel_IOFactory::load($templateFile);
		$objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);            //获取excel中sheet(0)的数据
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);		
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			->setLastModifiedBy("Maarten Balliauw")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
			->setKeywords("office 2007 openxml php")
			->setCategory("Test result file"); 

		$num=5;
		foreach($models as $val){
                $Ocode=Yii::app()->cache->get("ocode_{$val->mk_addid}");
			if($Ocode==false) {
				$umodel=User::model()->getUserInfoById($val->mk_addid);
				$OModel=Organization::model()->getOById($umodel->user_organization);
				if($OModel->o_code){
					$Ocode=$OModel->o_code;
				}else{
					$Ocode=Organization::model()->getCodeById($OModel->o_pid);
				}
				Yii::app()->cache->set("ocode_{$val->mk_addid}",$Ocode,Yii::app()->params->cacheTime);
			}
            
            $e_trip = unserialize($val->mk_reason);
            $reason='';
            foreach($e_trip as $j=>$v){                
                 if($v==1){$reason.=$reason?";".Emapp::$arrreason[$j].",\t\n":Emapp::$arrreason[$j];}
            }
            //如何自动换行
            // $objPHPExcel->getActiveSheet()->getStyle($num)->getAlignment()->setWrapText(true);
			$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A'.$num,  $val->mk_xh,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B'.$num,  $val->mk_sname,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C'.$num,   $Ocode, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D'.$num,   'aa', PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E'.$num,  isset(Emapp::$subject[$val->mk_subject])?Emapp::$subject[$val->mk_subject]:"", PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('F'.$num,  $reason, PHPExcel_Cell_DataType::TYPE_STRING);				
				$num++;
		}
         
        $jnum=$num+10; 
        foreach(Emapp::$textarr as $val){
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A'.$jnum,  $val,  PHPExcel_Cell_DataType::TYPE_STRING);        
            $jnum++;
        }        
			$objPHPExcel->getActiveSheet()->setTitle('免考数据');
			$filename = "免考信息导出.xls";
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Emapp the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Emapp::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
        if(Yii::app()->user->role!="5"&&!in_array(Yii::app()->user->id,array(1,2))){
             $uid=Yii::app()->user->id;
             $usermodel=User::model()->getUserInfoById($uid);
             $OArr=Organization::model()->getAllid($usermodel->user_organization);
             $UArr=User::model()->getAllByOid($OArr);
             if(!in_array($model->mk_addid,$UArr))throw new CHttpException(404,'您访问的页面不存在。');
         }
		return $model;
	}
 
}
