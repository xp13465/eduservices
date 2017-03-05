<?php

class ExamController extends Controller
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
				'actions'=>array('delall','index','equery','manualmark','view','stopall'),
				'users'=>User::model()->getManage(4)
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    /**
    * 考试管理中$cat的考生的状态
    * @param int $cat
    * @return array
    */
	public function actionIndex($cat='')
	{ 
        
        
        //考试中的学生  sc_status = 0   其它为非0
        $criteria = new CDbCriteria;
        if(Yii::app()->user->role!="4"){
            $Scriteria=new CDbCriteria;
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->getUserInfoById($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			$Scriteria->addInCondition('s_addid', $UArr);
            $Smodels=Students::model()->findAll($Scriteria);
            $SArr=array();
            foreach($Smodels as $Smodel){
                $SArr[]=$Smodel->s_id;
            }
            $criteria->addInCondition('sc_sid', $SArr);
		}
       
        $criteria->addCondition(' sc_isdel = 1 ');
        $criteria->addCondition(' sc_thanswer is not NULL ');
        if($cat==3){//有成绩的考生
            $criteria->addCondition(' sc_status != 0 ');
            $criteria->select='sc_id,sc_sid,sc_sjid,sc_pkid,sc_ldt,sc_kgmark,sc_readerid,sc_zgmark,sc_status,sc_time';
        }elseif($cat==2){//待批改的考生生
            $criteria->addCondition(' sc_status = 0 ');
        }elseif($cat==4){//缺考的考生
            $criteria->addCondition(' sc_status != 0 ');
        }else{ //默认显示考试中的学生
            //删除过期记录
            $delcriteria = new CDbCriteria;
            $delcriteria->addCondition(' sc_status = 0 or sc_thanswer is NULL'); 
            $sdttime=time()-(86400*30);
            $delcriteria->addCondition(" sc_sdt  <'{$sdttime}'");
            Score::model()->deleteAll($delcriteria); 
            
            $sdttime=time()-(86400);
            $criteria->addCondition(' sc_status = 0 '); 
            $criteria->addCondition(" sc_sdt  >'{$sdttime}'");
            $criteria->select='sc_id,sc_sid,sc_sjid,sc_pkid,sc_sdt,sc_status,sc_time';
        }
        $orderArr = array(
            "tmeu"=>"sc_ldt asc",
            "tmbu"=>"sc_sdt asc",
            "bzu"=>"sc_id asc",
            
            "tmed"=>"sc_ldt desc",
            "tmbd"=>"sc_sdt desc",
            "bzd"=>"sc_id desc",
        );
        $order=isset($_GET['order'])?$_GET['order']:$cat=='3'?"sc_ldt asc":"sc_sdt asc";
        $criteria->order=isset($orderArr[$order])?$orderArr[$order]:"";
        foreach($_GET as $key=>$val){$val = addslashes($val); // 搜索查询
            if($key=="stname"&&$val&&$val!="姓名...")//姓名字段
            {                
                $srow=Students::model()->findAll("s_name regexp '{$val}'");
                $strarr=array();
                foreach($srow as $k=>$v){
                    $strarr[]=$v['s_id'];
                }
                $scsid=join(',',$strarr)?"sc_sid  in(".join(',',$strarr).") ":"sc_sid  =0";
                $criteria->addCondition($scsid);
            }
            if($key=="stsfz"&&$val&&$val!="身份证...")//身份证字段
            {
               $srow=Students::model()->findAll("s_credentialsnumber regexp '{$val}'");
               $strarr=array();
                foreach($srow as $k=>$v){
                     $strarr[]=$v['s_id'];
                }
                $scsid=join(',',$strarr)?"sc_sid  in(".join(',',$strarr).") ":"sc_sid  =0";
                $criteria->addCondition($scsid);
            }                    
            if($key=="stpkcc"&&is_numeric($val)&&$val&&$val!="排考场次...")
            {                             
                $criteria->addCondition("sc_pkid={$val}");
            }
        }
        $order=isset($_GET['order'])?$_GET['order']:"";
        $criteria->order=isset($orderArr[$order])?$orderArr[$order]:"";
        $pageSize=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20";
        setcookie("ksgllistreturnurl",$_SERVER['REQUEST_URI'],0,"/");
        $dataProvider = new CActiveDataProvider('Score',array(
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
    * 手工阅卷
    * @param int $id 当前访问成绩的id
    */
    public function actionManualMark($id)
    {
        $model = $this->loadModel($id);//成绩ID
        $examModel = Exampaper::model()->findByPk($model->sc_sjid);//试卷ID
        if($_POST)
        {
          // echo "<pre>";  print_r($_POST); //$_POST出来的是status[对错] 与sfs[分数]
            $TMARR=unserialize($model->sc_thanswer);//sc_thanswer:题号与答题内容
            $num=0;
            foreach($TMARR as $tkid=>$tkArr){ //题库
                foreach($tkArr as $typeid=>$tmArr){ //题目类型
                    foreach($tmArr as $key=>$val){//题目
                        foreach($val as $kss=>$vss){//考试
                            $data=Topic::model()->findByPk($vss['tid'])->attributes;//通过题目自增id 来获取当前的题目表中的内容
                            if(isset($_POST['sfs'][$kss])){
                                $TMARR[$tkid][$typeid][$key][$kss]['sfs']=floor($_POST['sfs'][$kss]);
                                $num+=floor($_POST['sfs'][$kss]); //floor():取整
                            }else{
                                $num+=$vss['sfs'];
                            }
                            if(isset($_POST['status'][$kss])){
                                $TMARR[$tkid][$typeid][$key][$kss]['status']=$_POST['status'][$kss];
                            }
                        }
                    }
                }
            }
            $model->sc_kgmark=$num;
            $model->sc_thanswer=serialize($TMARR);
            $model->sc_status = 2;
            $model->sc_readerid=Yii::app()->user->id;
            if($model->save()){
                Yii::app()->user->setFlash("message","手工阅卷成功");
                $this->redirect(array("view","id"=>$model->sc_id));
            }else{
                 Yii::app()->user->setFlash("message","手工阅卷失败");
            }
        }
        $this->render('manualmark',array(
            'model'=>$model,
            'examModel'=>$examModel,
        ));
    }
    
    /*
    * 查看答案
	* @param int $id 当前访问成绩的id
    */
    public function actionView($id)
	{
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
	}
    public function loadModel($id)
	{
		$model=Score::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
    
	public function actionEquery()
	{
        $criteria=new CDbCriteria;
        if(Yii::app()->user->role!="4"){
            $Scriteria=new CDbCriteria;
			$uid=Yii::app()->user->id;
			$usermodel=User::model()->getUserInfoById($uid);
			$OArr=Organization::model()->getAllid($usermodel->user_organization);
			$UArr=User::model()->getAllByOid($OArr);
			$Scriteria->addInCondition('s_addid', $UArr);
            $Smodels=Students::model()->findAll($Scriteria);
            $SArr=array();
            foreach($Smodels as $Smodel){
                $SArr[]=$Smodel->s_id;
            }
            $criteria->addInCondition('sc_sid', $SArr);
		}
        foreach($_GET as $key=>$val){$val = addslashes($val); 
   
            if($key=="stpkcc"&&is_numeric($val)&&$val&&$val!="排考场次...")
            {                             
                $criteria->addCondition("sc_pkid={$val}");
            }                     
        
			if($key=="stname"&&$val&&$val!="姓名...")
            {                
               $srow=Students::model()->findAll("s_name regexp '{$val}'");
               $strarr=array();
                foreach($srow as $k=>$v){
                     $strarr[]=$v['s_id'];
                }
                
            $scsid=join(',',$strarr)?"sc_sid  in(".join(',',$strarr).") ":"sc_sid  =0";
            $criteria->addCondition($scsid);
            }

			 if($key=="stsfz"&&$val&&$val!="身份证...")
             {
               $srow=Students::model()->findAll("s_credentialsnumber regexp '{$val}'");
               $strarr=array();
                foreach($srow as $k=>$v){
                     $strarr[]=$v['s_id'];
                }
             $scsid=join(',',$strarr)?"sc_sid  in(".join(',',$strarr).") ":"sc_sid  =0";
            $criteria->addCondition($scsid);
             }
             
             if($key=="exename"&&$val&&$val!="关键字...")
             {
               $srow=Exampaper::model()->findAll("e_name regexp '{$val}'");
               $strarr=array();
                foreach($srow as $k=>$v){
                     $strarr[]=$v['e_id'];
                }
             $scsid=join(',',$strarr)?"sc_sjid  in(".join(',',$strarr).") ":"sc_sjid  =0";
            $criteria->addCondition($scsid);
             }
			// if($key=="s_birthaddress"&&$val&&$val!="出生地..")$criteria->addCondition(" s_birthaddress regexp '{$val}'");
			// if($key=="s_baokaocengci"&&$val)$criteria->addCondition("s_baokaocengci  = '{$val}' ");
			// if($key=="s_baokaozhuanye"&&$val)$criteria->addCondition("s_baokaozhuanye  = '{$val}' ");
			// if($key=="s_status"&&$val)$criteria->addCondition("s_status  = '{$val}' ");
			
		}
        $criteria->addCondition("sc_status!=0");        
        $criteria->addCondition("sc_isdel  = '1' ");//屏闭删除了的
        $criteria->select='sc_id,sc_sid,sc_sjid,sc_pkid,sc_time,sc_kgmark,sc_zgmark,sc_source,sc_status,sc_isdel';
        $criteria->order = "sc_kgmark desc";
        $criteria->having='`sc_kgmark` =(select max(sc_kgmark) from es_score where sc_pkid=t.sc_pkid and sc_sjid=t.sc_sjid and sc_sid=t.sc_sid and sc_status!=0 and sc_isdel  = "1")';
        $pageSize=isset($_COOKIE['e_pagesize'])?$_COOKIE['e_pagesize']:"20";
        setcookie("ksgllistreturnurl",$_SERVER['REQUEST_URI'],0,"/");
		$dataProvider =  new CActiveDataProvider("Score", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>$pageSize,
						),
		));
        $this->render('equery',array(
			"dataProvider"=>$dataProvider,
		));
	}
    public function actionDelall()
	{
		
        if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
        {
			$tid=isset($_POST['tid'])&&in_array($_POST['tid'],array(1,2))?$_POST['tid']:"2";
			$count =Score::model()->updateAll(array('sc_isdel'=>$tid),"sc_id in ( ".join(",",$_POST['selectdel'])." ) ");
			if($count>0){  
			   echo "ok";  
			}
        }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}
    
    public function actionStopall()
	{
		
        if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
        {
			$tid=isset($_POST['tid'])&&in_array($_POST['tid'],array(1,2))?$_POST['tid']:"2";
			$count =Score::model()->updateAll(array('sc_ldt'=>time()),"sc_id in ( ".join(",",$_POST['selectdel'])." ) ");
			if($count>0){  
			   echo "ok";  
			}
        }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	}
    
    public function actionOutexcel()
	{	
		// print_r($_POST);
		// exit;
		if (Yii::app()->request->isPostRequest){
			$criteria=new CDbCriteria;		
			$criteria->addCondition("sc_isdel  = '1' ");			
			// $criteria->addCondition("s_status='2'");			
			
			echo $models=Score::model()->findAll($criteria);exit;
			spl_autoload_unregister(array('YiiBase','autoload'));
			include_once(DOCUMENTROOT."/protected/vendors/PHPExcel.php");
			include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
			spl_autoload_register(array('YiiBase','autoload'));         
			
			$templateFile = PIC_PATH.'template/template.xls';
			$objPHPExcel = PHPExcel_IOFactory::load($templateFile);
			$objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);                                               //获取excel中sheet(0)的数据
														 //重新启用YII的自动载入
		   
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
			$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
				->setLastModifiedBy("Maarten Balliauw")
				->setTitle("Office 2007 XLSX Test Document")
				->setSubject("Office 2007 XLSX Test Document")
				->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
				->setKeywords("office 2007 openxml php")
				->setCategory("Test result file");


		// Add some data
			$Parr=array();
			// $pmodels=Professional::model()->getKCCode();
			// $nationalityArr=Lookup::model()->getClass('nationality');
			// $ScorefromArr=Lookup::model()->getClass('Scorefrom');
			// $ScorefromstatusArr=Lookup::model()->getClass('Scorefromstatus');
			// $politicalstatusArr=Lookup::model()->getClass('politicalstatus');
			$num=4;
			foreach($models as $val){
				// $baokaozhuanye=isset($pmodels[$val->s_baokaozhuanye])?$pmodels[$val->s_baokaozhuanye]:"丢失";
				// $Address=$val->s_birthaddress;
				
				// $Ocode=Yii::app()->cache->get("ocode_{$val->s_addid}");
				// if($Ocode==false) {
					// $umodel=User::model()->getUserInfoById($val->s_addid);
					// $OModel=Organization::model()->getOById($umodel->user_organization);
					// if($OModel->o_code){
						// $Ocode=$OModel->o_code;
					// }else{
						// $Ocode=Organization::model()->getCodeById($OModel->o_pid);
					// }
					// Yii::app()->cache->set("ocode_{$val->s_addid}",$Ocode,Yii::app()->params->cacheTime);
				// }
				
				// if(strpos($Address,"市")){
					// $ADArr=explode("市",$Address);
					// $Address=$ADArr[0]."市";
				// }else if(strpos($Address,"省")){
					// $ADArr=explode("省",$Address);
					// $Address=$ADArr[0]."省";
				// }
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit('A'.$num, "$Ocode",  PHPExcel_Cell_DataType::TYPE_STRING);
					// ->setCellValueExplicit('B'.$num,  $val->s_baokaocengci, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('C'.$num,  $baokaozhuanye, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('D'.$num,  $val->s_name, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('E'.$num,  Score::$sex[$val->s_sex], PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('F'.$num,  Score::$credentialstype[$val->s_credentialstype], PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('G'.$num,  $val->s_credentialsnumber, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('H'.$num,  date("Ymd",$val->s_birthdate), PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('I'.$num,  $nationalityArr[$val->s_nationality], PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('J'.$num,  $politicalstatusArr[$val->s_politicalstatus], PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('K'.$num,  Score::$highesteducation[$val->s_highesteducation], PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('L'.$num,  $val->s_phone, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('M'.$num,  $val->s_email, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('N'.$num,  Score::$profession[$val->s_zhiyezhuangkuang])
					// ->setCellValueExplicit('O'.$num,  Score::$marital[$val->s_hunyinzhuangkuang])
					// ->setCellValueExplicit('P'.$num,  $val->s_familyaddress, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('Q'.$num,  $val->s_gongzuodanwei, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('R'.$num,  $val->s_youbian, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('S'.$num,  $val->s_contactaddress, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('T'.$num,  $val->s_tel, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('U'.$num,  $ScorefromArr[$val->s_sfromaddress], PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('V'.$num,  $Address, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('W'.$num,  $ScorefromstatusArr[$val->s_sfromtype], PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('X'.$num,  date("Y-m",$val->s_cjgztime), PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('Y'.$num,  $val->s_oldschool, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('Z'.$num,  $val->s_oldschoolcode, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('AA'.$num, $val->s_oldzhuanye, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('AB'.$num, date("Y-m",$val->s_oldtime), PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('AC'.$num, $val->s_oldimgnumber, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('AD'.$num, Score::$enrollment[$val->s_enrollment], PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit('AE'.$num, Score::$study[$val->s_study], PHPExcel_Cell_DataType::TYPE_STRING);
					$num++;
			}
			$objPHPExcel->getActiveSheet()->setTitle('成绩数据');

			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			// header('Content-Disposition: attachment;filename="ScoreExcel.xls"');
			$ua = $_SERVER["HTTP_USER_AGENT"];
			$filename = "学员成绩导出.xls";
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
	}	
}