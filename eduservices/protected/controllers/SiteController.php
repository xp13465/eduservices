<?php

class SiteController extends Controller {


/**
 * Declares class-based actions.
 */
public function actions()
{
    return array(
        // captcha action renders the CAPTCHA image displayed on the contact page
        'captcha'=>array(
            'class'=>'CCaptchaAction',
            'backColor'=>0xFFFFFF,
        ),
        // page action renders "static" pages stored under 'protected/views/site/pages'
        // They can be accessed via: index.php?r=site/page&view=FileName
        'page'=>array(
            'class'=>'CViewAction',
        ),
    );
}
    public $layout='main';

    public function actionIndex() {
        $News['wykx']=Information::model()->getAllById(1,7,'i_updatetime desc');
        $News['hdgg']=Information::model()->getAllById(2,7,'i_updatetime desc');
        $News['jzgg']=Information::model()->getAllById(3,6,'i_updatetime desc');
        $this->render('index',array(
            "News"=>$News,
            
            
        ));
    }
    public function actionRecruitstudents() {
        $this->render('recruitstudents');
    }
	public function actionLogin() {
        $this->layout = "login";
        if(!Yii::app()->user->isGuest) {
            $this->redirect(array('/site/index'));
        }
        $model=new LoginForm;
		
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
            $model->attributes=$_POST;
            if($model->validate() && $model->login()) {
                echo "success";
                exit;
            }
            echo "error";
            exit;
        }
        if(isset($_POST['LoginForm'])) {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){}
                //$this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }
	 public function actionLogout(){
        Yii::app()->user->setState("adminisGuest","");
        Yii::app()->user->setState("studentisGuest","");
		Yii::app()->user->logout();
        $this->redirect(DOMAIN);
    }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
    
        if(isset($_SERVER["REQUEST_URI"])) {//看看是不是后台的错误。如果是就要使用其他的layout
            $find = stripos($_SERVER["REQUEST_URI"], "/admin/");
            if($find!== false) {
                //$this->layout="frame";
            }
        }
        if($error=Yii::app()->errorHandler->error) {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }else {
            $this->render('error');
        }
    
    }

	public function actionSetcookie() {
		if($_POST['name']=="s_pagesize"){
			if($_POST['value']>100)$value=100;
			else $value=$_POST['value'];
		}else{
			$value=$_POST['value'];
		}
		setcookie($_POST['name'],$value,0,"/");
    }
	public function actionSearchschool() {
		$this->layout='upload';
		$this->pageTitle = "毕业院校搜索";
		$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';
		$province=isset($_GET['province'])?$_GET['province']:'';
		$criteria=new CDbCriteria;
		if($keyword)
		$criteria->addCondition("s_name regexp '{$keyword}' or s_history regexp '{$keyword}'");
		if($province)
		$criteria->addCondition("s_province regexp '{$province}'");
		$dataProvider =  new CActiveDataProvider("School", array(
						'criteria'=>$criteria,
						'pagination'=>array(
								'pageSize'=>10,
						),
		));
		$this->render('searchschool',array(
			'dataProvider'=>$dataProvider,
			'keyword'=>$keyword,
			'province'=>$province
		));
		
	}
    public function actionUpmkimg() {
		$this->layout='upload';
		$this->pageTitle = "照片上传";
		$upsize=array(
			"size"=>1024*200,
            // 'pixel'=>'150x210',.
           // 'pixel'=>'500x450',//限制必须多大的象素
			'title'=>"200K"
		);
		$this->Upload($upsize,"图片");
	}
	public function actionUpheadimg() {
		$this->layout='upload';
		$this->pageTitle = "照片上传";
		$upsize=array(
			"size"=>1024*10,
            // 'pixel'=>'150x210',.
            'pixel'=>'102x126',
			'title'=>"10K"
		);
		$this->Upload($upsize,"图片");
	}
    public function actionUpsfimg() {
		$this->layout='upload';
		$this->pageTitle = "身份证扫描件上传";
		$upsize=array(
			"size"=>1024*20,
			'title'=>"20K"
		);
		$this->Upload($upsize,"图片");
	}
	public function actionUpimg() {
		$this->layout='upload';
		$this->pageTitle = "图片上传";
		$upsize=array(
			"size"=>1024*250,
			'title'=>"250K"
		);
		$this->Upload($upsize,"图片");
	}
	public function actionUpfile() {
		$this->layout='upload';
		$this->pageTitle = "文件上传";
		$upsize=array(
			"size"=>1024*1024*1,
			'title'=>"1M"
		);
		$this->Upload($upsize,'文件');
	}
	private function Upload($upsize,$fname){
		$str="";
			$editid=$_GET["editid"]; //
			$imageid=isset($_GET["imgid"])?$_GET["imgid"]:""; //
			$btnid=isset($_GET["btnid"])?$_GET["btnid"]:""; //
		if (@is_uploaded_file($_FILES['upfile']['tmp_name'])){
			$upfile=$_FILES["upfile"];
			$name = date("YmdHis",time()).mt_rand(1000,9999);//$upfile["name"];
			$type = preg_replace("/[\"\']/","",$upfile["type"]);
			$size = $upfile["size"];
			$tmp_name = $upfile["tmp_name"];
			$error = $upfile["error"];
			$ok=0;
			if($fname=='文件'){
				switch ($type) {//文件格式可以在下面增加判断
					case 'application/x-zip-compressed' : 
					$name=$name.".zip";
					$ok=1;
					break;
                    case 'application/zip' : 
					$name=$name.".zip";
					$ok=1;
					break;
					case 'application/octet-stream' : 
					$name=$name.".rar";
					$ok=1;
					break;
                    case 'image/pjpeg' : 
					$name=$name.".jpg";
					$ok=1;
					break;
					case 'image/jpeg' : 
					$name=$name.".jpg";
					$ok=1;
					break;
					case 'image/gif' :
					$name=$name.".gif";
					 $ok=1;
					break;
					case 'image/png' :
					$name=$name.".png";
					$ok=1;
					break;
					case 'image/x-png' :
					$name=$name.".png";
					$ok=1;
					break;
				}
			}else{
				switch ($type) {//图片格式可以在下面增加判断
					case 'image/pjpeg' : 
					$name=$name.".jpg";
					$ok=1;
					break;
					case 'image/jpeg' : 
					$name=$name.".jpg";
					$ok=1;
					break;
					case 'image/gif' :
					$name=$name.".gif";
					 $ok=1;
					break;
					case 'image/png' :
					$name=$name.".png";
					$ok=1;
					break;
					case 'image/x-png' :
					$name=$name.".png";
					$ok=1;
					break;
				}
			}
			if (@$ok!=1){
                $str= "<script>alert('{$fname}格式不正确,请重试');location.reload();</script>";
			}else{
                if ($size>$upsize['size']){
                    $str= "<script>alert('{$fname}过大,大小请小于{$upsize['title']}');location.reload();</script>";
                }else{
                    if($ok && $error=='0'){
                        $pixelcheck=true;
                        if($fname=='图片'){
                            $IMG= @getimagesize($tmp_name);
                            if(isset($upsize['pixel'])&&$IMG){
                                $pixelArr=explode("x",$upsize['pixel']);
                                if($IMG[0]==$pixelArr[0]&&$IMG[1]==$pixelArr[1]){
                                    
                                }else{
                                    $pixelcheck=false;
                                    $str= "<script>alert('上传失败,\\n当前图片像素为：{$IMG[0]}x{$IMG[1]}，\\n{$this->pageTitle}需要{$upsize['pixel']}');location.reload();</script>";
                                }
                               
                            }
                        }     
                        // echo $str;
                            // echo $size."|";
                            // echo $upsize['size'];exit;
                        if($pixelcheck){
                            if(@move_uploaded_file($tmp_name,PIC_PATH.$name)){
                             
                                 $str="<script>alert('上传成功');window.opener.document.getElementById('".$editid."').value='".PIC_URL.$name."';";
                                    if($imageid){
                                        $str.="window.opener.document.getElementById('".$imageid."').src='".PIC_URL.$name."';";
                                        $str.="window.opener.document.getElementById('".$imageid."').style.display='';";
                                    }
                                    if($btnid){
                                        $str.="window.opener.document.getElementById('".$btnid."').style.display='';";
                                    }	
                                 $str.="window.close();</script>";
                            }else{
                                $str= "<script>alert('上传失败，请重试！');location.reload();</script>";
                            }
                        }
                    }
                }
            }
		}
		$this->render('upload',array(
			"script"=>$str,
		
		));
	}
    
    public function actionSaveheadimgbybase64(){
        if(isset($_POST['jpgbase64'])&&$_POST['jpgbase64']&&isset($_POST['zhengbase64'])&&$_POST['zhengbase64']&&isset($_POST['fanbase64'])&&$_POST['fanbase64']){
            $zp_image = <<< EOFILE
{$_POST['jpgbase64']}
EOFILE;
            $zp_name = "zp_".date("YmdHis",time()).mt_rand(1000,9999).".jpg";
            file_put_contents(PIC_PATH.$zp_name,base64_decode($zp_image) );
            
            $sfz_image = <<< EOFILE
{$_POST['zhengbase64']}
EOFILE;
            $sfz_name = "sfz_".date("YmdHis",time()).mt_rand(1000,9999).".jpg";
            file_put_contents(PIC_PATH.$sfz_name,base64_decode($sfz_image) );
            
            $sff_image = <<< EOFILE
{$_POST['fanbase64']}
EOFILE;
            $sff_name = "sff_".date("YmdHis",time()).mt_rand(1000,9999).".jpg";
            file_put_contents(PIC_PATH.$sff_name,base64_decode($sff_image) );
            
            echo json_encode(array("zp_name"=>PIC_URL.$zp_name,"sfz_name"=>PIC_URL.$sfz_name,"sff_name"=>PIC_URL.$sff_name));
        }
    }
    
	public function actionIsused() {
        if(Yii::app()->request->isAjaxRequest) {
            $valid = 'true';
            switch (true) {
                case !empty($_REQUEST['email']):
                    $model=User::model()->find('LOWER(u_email)=?',array(strtolower(trim($_REQUEST['email']))) );
                    if($model)
                        $valid = 'false';
                    break;
                case !empty($_REQUEST['user_name']):
                    $model=User::model()->find('LOWER(user_name)=?  and user_isdel=1',array(strtolower(trim($_REQUEST['user_name']))) );
                    if($model)
                        $valid = 'false';
                    break;
                case !empty($_REQUEST['telephone']):
                    $model=Member::model()->findByAttributes(array('mem_telephone'=>trim($_REQUEST['telephone'])));
                    if($model)
                         $valid = 'true';
                    break;
            }
            echo $valid;
        }
    }
    public function actionGetphonecode(){
        if(isset($_POST['phone'])&&$_POST['phone']&&isset($_POST['card'])&&$_POST['card']){
            $student=Students::model()->find("s_isdel=1 and s_status =2 and s_credentialsnumber='{$_POST['card']}' ");
            if($student){
                $EAmodels=Examarrangement::model()->findAll("ea_pkid ='{$student->s_pc}'");
                if($EAmodels){
                    $return=true;
                    foreach($EAmodels as $EA){
                        if((time()+1800)>$EA->ea_stime&&time()<$EA->ea_etime){
                            $return=false;;
                            break;
                        }
                    }
                    if($return){
                        echo "nottime";
                        exit;
                    }
                }else{
                    echo "noea";
                    exit;
                }
            }
            if($student&&$student->s_phone==$_POST['phone']){
                $time=time()+28800;
                $code=mt_rand(100000,999999);
                $verifyType=Config::model()->getConfig('verifyType');
                $content=false;
                if($verifyType==2){//速达
                    $url = "http://sdk2.sudas.cn:8060/z_mdsmssend.aspx?";
                    $url.= "sn=".SMSUSER;
                    $url.= "&pwd=".strtoupper(md5(SMSUSER.SMSPWD));
                    $url.= "&mobile={$student->s_phone}";
                    $datetime=date("Y-m-d H:i:s",$time);
                    $url.= "&content=".urlencode(mb_convert_encoding("您好，您即将参加北航现代远程教育入学测试，此次测试登录动态密码为：{$code}，有效期为{$datetime}【北航在线】", "GBK","UTF-8"));
                    $url.= "&ext=&rrid=&stime=";
                    $content=file_get_contents($url);
                }elseif($verifyType==3){//XX
                    $url = "http://sdk2.sudas.cn:8060/z_mdsmssend.aspx?";
                    $url.= "sn=".SMSUSER;
                    $url.= "&pwd=".strtoupper(md5(SMSUSER.SMSPWD));
                    $url.= "&mobile={$student->s_phone}";
                    $datetime=date("Y-m-d H:i:s",$time);
                    $url.= "&content=".urlencode(mb_convert_encoding("您好，您即将参加北航现代远程教育入学测试，此次测试登录动态密码为：{$code}，有效期为{$datetime}【北航在线】", "GBK","UTF-8"));
                    $url.= "&ext=&rrid=&stime=";
                    $content=file_get_contents($url);
                }
                if($content){
                    $model=new Phonemsgcode;
                    $model->pmc_phone=$student->s_phone;
                    $model->pmc_code=$code;
                    $model->pmc_time=$time;
                    $model->pmc_returnmsgid=$content;
                    if($model->save()){
                        echo "ok";
                        exit;
                    }else{
                        echo "nook";
                    }
                }
                
            }elseif($student){
                echo "nophone";
                exit;
            }else{
                echo "nouser";
                exit;
            }
        }else{
            echo "error";
            exit;
        }
    }
	public function actionCleanCache(){
        Yii::app()->cache->flush();
        echo "webcache is clean";exit;
    }
    
    public function actionQuery(){
        $this->layout=false;
        $return=$Smodel=false;
        if($_POST){
            $cardnumber=isset($_POST['cardnumber'])?$_POST['cardnumber']:'';
            $phone=isset($_POST['phone'])?$_POST['phone']:'';
            $criteria=new CDbCriteria;
            $criteria->with="studentinfo";
            $criteria->compare('s_credentialsnumber', $cardnumber);
            $criteria->compare('s_phone', $phone);
            // print_r($criteria);
            $Smodel=StudentsManage::model()->find($criteria);
            // print_r($_POST);
            // print_r($Smodel);
            if($Smodel){
                if($Smodel->sm_status==1){
                    $return='您还未被确认，可能一下原因造成：\n\n1.证件号码、手机号输入错误\n2.已报名、还未参加入学考试\n3.入学考试考试成绩不合格\n4.专升本一学历认证书正在进行或未通过';
                }elseif($Smodel->sm_status==2){
                    $return='您被录取了，及时至北航远程官方授权学习中心注册、交费。';
                }elseif($Smodel->sm_status==3){
                    $return='您还未被录取，可能一下原因造成：\n\n1.证件号码、手机号输入错误\n2.已报名、还未参加入学考试\n3.入学考试考试成绩不合格\n4.专升本一学历认证正在进行或未通过';
                }
            }else{
                $return='您还未被录入，可能一下原因造成：\n\n1.证件号码、手机号输入错误\n2.已报名、还未参加入学考试\n3.入学考试考试成绩不合格\n4.专升本一学历认证正在进行或未通过';
            }
            
            
        }
        $this->render('query',array(
            'return'=>$return,
            'Smodel'=>$Smodel,
        
        ));
    }
    
    public function actionCheckmk(){
    header("Content-type: text/html; charset=utf-8");
    $mkzseach=Emapp::model()->findByPk($_GET["mkid"]);    
    $type=$mkzseach["mk_subject"];  //1英语科目2计算机科目    
    
        if($type==1){
            $url = "http://chaxun.neea.edu.cn/examcenter/query.cn?op=doQueryResults&pram=certi";
            $post_data = array (
                "ksnf" => $mkzseach->mk_ksnf,
                "sf" => $mkzseach->mk_ksadder,
                "bkjb" => $mkzseach->mk_zstype,
                "zkzh" => $mkzseach->mk_zkznum,
                "name" => $mkzseach->mk_sname,
                "sfzh" => $mkzseach->mk_zjnum?$mkzseach->mk_zjnum:$mkzseach->mk_cardnumber,
                'rand'=>'',
                'state'=>'',
               // 'opt'=>'queryC',
                'ksxm'=>'280',
                );
          
        }elseif($type==2){
            $url = "http://chaxun.neea.edu.cn/examcenter/query.cn?op=doQueryResults&pram=certi";
            $post_data = array (
                "ksnf" => $mkzseach->mk_ksnf,
                "sf" => $mkzseach->mk_ksadder,
                "bkjb" => $mkzseach->mk_zstype,
                "zkzh" => $mkzseach->mk_zkznum,
                "name" => $mkzseach->mk_sname,
                "sfzh" => $mkzseach->mk_zjnum?$mkzseach->mk_zjnum:$mkzseach->mk_cardnumber,
                'rand'=>'',
                'state'=>'',
               // 'opt'=>'queryC',
                'ksxm'=>'300',
                );
        }
        echo "<form id='checkform' action='{$url}' method='post'>";
        foreach($post_data as $key=>$val){ 
            echo "<input type='hidden' name='{$key}' value='{$val}'>";
        } 
        echo '</form><script>document.getElementById("checkform").submit();</script>';
        exit;
    }
    
}