<?php

class QuestionsController extends Controller
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
				'actions'=>array('index','view','add','edit','delall','outquestions','outq','importq'),
				'users'=>User::model()->getManage(4),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    
    
	public function actionIndex()
	{//echo "ce";exit;
    // $type
     $type=Topic::$type;
     $qmodel=Questions::model()->findAll("q_isdel=1");
     //print_r($qmodel);
     $criteria=new CDbCriteria;
     
    // print_r($_GET);
        foreach($_GET as $key=>$val){$val = addslashes($val);
			if($key=="t_type"&&$val)$criteria->addCondition("t_type ='{$val}' ");
			if($key=="t_level"&&$val)$criteria->addCondition("t_level ='{$val}' ");
			if($key=="t_score"&&$val&&$val!="")$criteria->addCondition(" t_score = '{$val}'");
			if($key=="t_con"&&$val&&$val!="")$criteria->addCondition("t_con  regexp '{$val}'");
			if($key=="t_know"&&$val)$criteria->addCondition("t_know regexp '{$val}' ");
			if($key=="t_qid"&&$val)$criteria->addCondition("t_qid  = '{$val}' ");
            if($key=="str"&&$val)$criteria->addCondition("t_qid  in ({$val}) ");
		}	       
        
        $criteria->addCondition("t_isdel  = '1' ");
        $criteria->order="t_id asc";
        
        $pageSize=isset($_COOKIE['t_pagesize'])?$_COOKIE['t_pagesize']:"20";
		$dataProvider =  new CActiveDataProvider("Topic", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>$pageSize,
						),
		));
		setcookie("tkreturnurl",$_SERVER['REQUEST_URI'],0,"/");
        $this->render('index',array(
			//"AB"=>$GG,
			//'web'=>$web,
			//"schoolGG"=>$schoolGG,
			//"HomeSlide"=>$HomeSlide,
			"dataProvider"=>$dataProvider,
			"type"=>$type,
            "qmodel"=>$qmodel,
			//"kefu"=>$kefu,
		));
	}
	 /*预览试题*/
    public function actionView($id)
	{
        $this->render('view',array(
			'model'=>$this->loadModel($id),
		));
        // $this->render('preview',array(
            // 'dataProvider' => $dataProvider,
            // 'newmodel' => $newmodel,
        // ));
	}

    
    public function actionAdd($qid='')
	{
		$model = new Topic;//试题表的MODEL
        $model->t_qid=$qid;
        $model->zhselect=$model->zhselect?$model->zhselect:"4";
        $model = $this->fzpsot($model);
        $model->t_validity=$model->t_validity?date("Y-m-d",$model->t_validity):"2029-01-01";       
        $this->render('add',array(
			'model'=>$model,
		));
	}
    
    //优化题库赋值条件 add 与 edit共用5.17
    public function fzpsot($model){
                if($_POST){
                    $model->attributes=$_POST;
                    $model->t_know=trim($model->t_know);
                    $daxx=serialize($_POST['optionsValue']);
                    $model->t_daxx=$daxx;
                    $model->t_article=$_POST['t_article'];
                    $model->zhselect=$_POST['zhselect'];
                    $model->t_validity=strtotime($_POST['t_validity']) ;
        //print_r($model->attributes);    exit; 
                    if(is_array($_POST['optionsRadios'])){
                        foreach($_POST['optionsRadios'] as $key=>$val){
                            $model->t_answer.=$model->t_answer?",".$key:$key;
                        }
                    }else{
                        $model->t_answer=$_POST['optionsRadios'];
                    }
                    
                    if($model->validate()){
                        if($model->t_answer){
                            if($model->save())$this->redirect(array('view','id'=>$model->t_id));
                         }else{
                            $model->addError("zhselect",'请必须选择一个');
                        }
                    }            
                }  
                 return $model;
    }
    
    public function actionOutquestions(){
        $criteria=new CDbCriteria;
         
        foreach($_GET as $key=>$val){$val = addslashes($val);
            if($key=="t_type"&&$val)$criteria->addCondition("t_type ='{$val}' ");
            if($key=="t_level"&&$val)$criteria->addCondition("t_level ='{$val}' ");
            //if($key=="t_score"&&$val&&$val!="")$criteria->addCondition(" t_score = '{$val}'");
            if($key=="t_con"&&$val&&$val!="")$criteria->addCondition("t_con  regexp '{$val}'");
            if($key=="t_know"&&$val)$criteria->addCondition("t_know regexp '{$val}' ");
            if($key=="t_qid"&&$val)$criteria->addCondition("t_qid  = '{$val}' ");            
            if($key=="q_id"&&$val)$criteria->addInCondition('t_qid',Questions::model()->getAlltikuIdByPid($val));
        }	       
        
        $criteria->addCondition("t_isdel  = '1' ");
        $criteria->order="t_qid asc";
        
        $models=Topic::model()->findAll($criteria);
        
        spl_autoload_unregister(array('YiiBase','autoload'));
        include_once(DOCUMENTROOT."/protected/vendors/PHPExcel.php");
        include_once(DOCUMENTROOT."/protected/vendors/PHPExcel/IOFactory.php");
        spl_autoload_register(array('YiiBase','autoload'));  
        $this->outExcelQuestions($models);
    }
    
    public function actionImportq(){
        ob_end_clean(); 
        error_reporting(E_ALL);
        set_time_limit(0);
        date_default_timezone_set('PRC');
        $sheetDataArr=array();
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
                        $sheetDataArr[$loadedSheetName] = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                    }
                }
            }
             
            
        }
        
        $seep = 100;
        $this->render('importq',array(
            'sheetDataArr'=>$sheetDataArr,
            'seep'=>$seep,
            ));
    }
    
    public function outExcelQuestions($models){
        $templateFile = PIC_PATH.'template/tmbtemplate.xls';
        $objPHPExcel = PHPExcel_IOFactory::load($templateFile);
        $objWorksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        $type=Topic::$type;
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
            
        $num=4;
        $i=1;
        foreach($models as $val){
            $m = Questions::model()->getQById($val->t_qid);
            $tkjname = Questions::model()->getNameById($m->q_pid);
            $tkname = Questions::model()->getNameById($val->t_qid);
            $t_daxx = unserialize($val->t_daxx);
            
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit('A'.$num,  "NO.".$i,  PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B'.$num,  $tkjname, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C'.$num,  $tkname, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D'.$num,  $type[$val->t_type], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('E'.$num,  $val->t_know, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('F'.$num,  $val->t_level, PHPExcel_Cell_DataType::TYPE_STRING)
                //->setCellValueExplicit('G'.$num,  $val->t_level, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('G'.$num,  date('Y-m-d',$val->t_validity), PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('H'.$num,  $this->getLatinByNum($val->t_answer), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)            
                ->setCellValueExplicit('A'.($num+1),  "题目", PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B'.($num+1),  $val->t_con, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)     
                ->setCellValueExplicit('A'.($num+2),  "参考文章", PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B'.($num+2),  $val->t_article, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A'.($num+3),  "选项", PHPExcel_Cell_DataType::TYPE_STRING);
            foreach($t_daxx as $key => $v){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('B'.($num+2+$key),  $this->getLatinByNum($key), PHPExcel_Cell_DataType::TYPE_STRING) 
                ->setCellValueExplicit('C'.($num+2+$key),  $v, PHPExcel_Cell_DataType::TYPE_STRING); 
            }
				$num += 4 + count($t_daxx);
                $i++;
		}
		$objPHPExcel->getActiveSheet()->setTitle('题目表');
		$filename = "学员考试题库导出.xls";
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
    
    private function getLatinByNum($answer){
        $answer = explode(',',$answer);
        sort($answer);
        $arr = array(1=>'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        foreach( $answer as &$value){
            if( array_key_exists($value, $arr) )
                $value = $arr[$value];
        }
        return implode(',',$answer);
    }
    
    public function actionOutq(){
        $this->render('outq');
    }
    
    public function actionEdit($id)
	{
		$model = $this->loadModel($id);//试题表的MODEL       
         
        $model = $this->fzpsot($model);
        $model->zhselect=$model->t_daxx?count(unserialize($model->t_daxx)):"4";
        $model->t_validity=$model->t_validity?date("Y-m-d",$model->t_validity):$model->t_validity;
        $this->render('edit',array(
			'model'=>$model,
		));
	}
    
    public function actionDelall()
	 {
	
	   if (Yii::app()->request->isPostRequest&&isset($_POST['selectdel'])&&$_POST['selectdel'])
	   { 
			$count =Topic::model()->updateAll(array('t_isdel'=>'2'),"t_id in ( ".join(",",$_POST['selectdel'])." ) "); 
			if($count>0){  
			   echo "ok";  
			}
	   }
	   else
		 throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
	 }
    
	public function actionExcellead()
	{
		$this->render('excellead');
	}
	public function actionBackups()
	{
		$this->render('backups');
	}
	public function actionRestore()
	{
		$this->render('restore');
	}
	public function loadModel($id)
	{
		$model=Topic::model()->findByPk($id);
		// echo $model->s_addid;
		if($model===null)
			throw new CHttpException(404,'您访问的页面不存在。');
		return $model;
	}
}