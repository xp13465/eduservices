<?php

class SiteController extends Controller {
    public $defaultAction  = "index";
    public $layout='column1';
    //默认用的column1的layout
    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
                // captcha action renders the CAPTCHA image displayed on the contact page
                // 'captcha'=>array(
                        // 'class'=>'CCaptchaAction',
                        // 'backColor'=>0xFFFFFF,
                // ),
                // page action renders "static" pages stored under 'protected/views/site/pages'
                // They can be accessed via: index.php?r=site/page&view=FileName
                'page'=>array(
                        'class'=>'CViewAction',
                ),
        );
    }
    /**
     *
     * @param object $action
     * @return bool
     */
    public function beforeAction($action){
        return true;
    }
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
                'accessControl', // perform access control for CRUD operations
        );
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                        'actions'=>array('index','login','cleancache'),
                        'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions'=>array('manageIndex','getnews','logout',"changepwd",'pinyin','topicimage','checkbd'),
                        'users'=>array('@'),
                ),
                array('deny',  // deny all users
                        'users'=>array('*'),
                ),
        );
    }
    
    public function actionGetNews()
	{
        $this->layout = 'column2';
        $return='';
        $error=array();
        if($_POST){
            $url="http://www.beihangonline.com/openwindow/new.html";
            // $url="http://www.beihangonline.com/openwindow/affiche.html";
            // $url="http://www.beihangonline.com/openwindow/info.html";
            $contents=file_get_contents($url);
            $contents=iconv("gbk","utf-8",$contents);
            $proArr=@explode('<table',$contents);

            $proArr1=explode('2011-05-13',$proArr[16]);
        
            
            // $vv=preg_match_all('|<dd class="tit">(.*?)</dd>|', $contents, $r);
            $vv=preg_match_all('|<a href="(.*?)".*?>(.*?)</a>|', $proArr1[0], $r);
            $test=@explode('<a href="',$proArr1[0]);
            $URLARR=array();
            foreach($test as $k=>$value){
                if($k<1)continue;
               $testArr=explode("</a>",$value);
               $temp=explode(">",$testArr[0]);;
               $URLARR[$k]['title']=$temp[1];
               $temp=explode("\"",$testArr[0]);;
               $URLARR[$k]['url']=$temp[0];
             
            }
              
            // print_r($r[1]);
            foreach($URLARR as $key=>$val){
               
                $vcon=file_get_contents("http://www.beihangonline.com/openwindow/{$val['url']}");
                $vcon=iconv("gbk","utf-8",$vcon);
                // echo $vcon;
                $vconArr=@explode('<table',$vcon);
                // print_r($vconArr[16]);
                
                // print_r($vconArr[17] );
                // $vssss=preg_match_all('|<td width="573"  align="right">(.*?)</td>|', $vconArr[17], $ssss);
                  // print_r($ssss);
                // exit;
                $vconArr1=@explode('<div class=',$vconArr[17]);
                 unset($vconArr1[0]);
                $ccc="<div class=".join("",$vconArr1 );
                $vconArr1=@explode('</td>',$ccc);
               
                
               
                $vconArr2=@explode('<td height="28">',$vconArr[16]);
                if(!isset($vconArr2[1])){
                   continue;
                }
                 $vtime=preg_match_all('|<td align="center"><span class="STYLE11">(.*?)</span>|', $vconArr2[1], $rtime);
                // $vconArr2=@explode('</td>',$vconArr2[1]);
                
                
              
                
                
                // $CDbCriteria=new CDbCriteria();
                // $CDbCriteria->addColumnCondition($array);
                
                // $count=$dblink->count("collocation",$CDbCriteria);
              
                $news=new Information();
                $news['i_class']='1';
                $news['i_title']=$val['title'];
                $news['i_con']=$vconArr1[0];
                $time=$rtime[1][0]?strtotime($rtime[1][0]):0;
                $news['i_submitdate']=$time;
                $news['i_updatetime']=$time;
                $news['i_form']="北航现代远程教育学院";
                $news['i_author']="管理员";
                    $num=Information::model()->count("i_title ='{$news['i_title']}'  and i_author ='{$news['i_author']}'");
                if(!$num){
                    if($news->save()){
                        $return.= $news['i_title']."抓取成功<br/>";
                    }else{
                        $error[]=($news->errors)."<br/>";
                    }
                }else{
                    $return.= $news['i_title']."|||已存在<br/>";
                }
                
                
            }
        }
        $this->render("pinyin",array(
            "return"=>$return,
            'error'=>$error,
        ));
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        if(!Yii::app()->user->isGuest&&Yii::app()->user->adminisGuest=='yes'&&Yii::app()->user->role=="4") {//没有登录
            $this->redirect(array('site/manageIndex'));
        }else {
            $this->redirect(array('site/login'));
        }
    }

    

   
    /**
     * Displays the login page
     */
    public function actionLogin() {
        if(!Yii::app()->user->isGuest&&Yii::app()->user->adminisGuest=='yes'&&Yii::app()->user->role=="4") {//没有登录
            // $this->redirect(array('site/manageIndex'));
            
        }
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm'])) {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate())
                $this->redirect(array('site/manageIndex'));
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->setState("adminisGuest","");
        Yii::app()->user->setState("studentisGuest","");
		Yii::app()->user->logout();
        $this->redirect(DOMAIN."/manage");
    }
    public function actionManageIndex() {
        $this->layout = 'column2';
        
        $this->render('manageIndex',array(
            
        ));
    }
    public function actionChangepwd(){
        $this->layout = 'column2';
        $userId = Yii::app()->user->id;
        $model = User::model()->findByPk($userId);
        if(isset($_POST)&&$_POST){
            $oldPwd = md5($_POST['mag_oldpassword']);
            $newPwd = md5($_POST['mag_password']);
            if($oldPwd == $model->user_pwd){
                $model->user_pwd = $newPwd;
                $model->update();
                Yii::app()->user->setFlash('changepwd','修改密码成功！');
                $this->Redirect(array("changepwd"));
            }else{
                $model->addError("mag_password","旧密码输入不正确！");
            }
        }
        $this->render("changepwd",array(
            "model"=>$model,
        ));
    }
    public function actionPinyin(){
        $this->layout = 'column2';
        $return='';
        $error=array();
        if($_POST){
            Yii::import('application.common.*');
            $pinyin = new Pinyin;
            
            $model = School::model()->findAll();
            foreach($model as $value){
                $name = trim($value->s_name);
                $pinYinArray = $pinyin->doWord($name);
                $value->s_pinyinsuoxie = $pinYinArray['short'];
                $value->s_pinyinlongname = $pinYinArray['long'];
                $value->update();
                if(!$value->s_pinyinlongname){
                    $error[] = $value->sbi_buildingid;
                }
            }
            
            
            if($error){
                $return ="以下id没有转换成功！<br />";
                // print_r($error);
            }else{
                $return = "全部转换完成";
            }
        }
        $this->render("pinyin",array(
            "return"=>$return,
            'error'=>$error,
        ));
    }
    public function actionCleanCache(){
        $this->layout = 'column2';
        $return= "";
        if($_POST){
            Yii::app()->cache->flush();
            $return= "缓存已清除";
        }
        $this->render("pinyin",array(
            "return"=>$return,
            'error'=>''
        ));
    }
    public function actionCheckbd(){
        $this->layout = 'column2';
        $return= "";
        if($_POST){
            $StudentsModels=Students::model()->findAll();
            foreach($StudentsModels as $student){
                $oldBD=$student->s_idbd;
                $usermodel=User::model()->findByPk($student->s_addid);
                $sfcodeQZ=substr(strtolower(trim($student->s_credentialsnumber)),0,2);
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
                if($checkArr){
                    $ck=true;
                    foreach($checkArr as $qz){
                        if($sfcodeQZ==$qz){
                            $student->s_idbd=3;
                            $ck=false;
                            break;
                        }
                    }
                    $student->s_idbd=$ck?"2":$student->s_idbd;
                }else{
                    $student->s_idbd=1;
                }
                if($student->s_idbd!=$oldBD){
                    if( $student->update()){
                        $return.= "[{$student->s_id}]{$student->s_name} 更新成功<br/>";
                    }else{
                        $return.= "[{$student->s_id}]{$student->s_name} 更新失败<br/>";
                    }
                   
                }
            }
            $return.= "本地分配已批量修改";
        }
        $this->render("pinyin",array(
            "return"=>$return,
            'error'=>''
        ));
    }
    
    public function actionTopicimage(){
       
        ob_end_clean(); 
        error_reporting(E_ALL);
        set_time_limit(0);
        $this->layout = 'column2';
        $return= "";
         header("Content-type:text/html;charset=utf-8");
        echo '<script>
function downscroll(){
	document.body.scrollTop = document.body.scrollHeight;
}
</script>';
    $error=array();
        if($_POST){
            $TopicModels=Topic::model()->findAll("1=1 order by t_id asc ");
            $error0img = file_get_contents(TOPICIMG_PATH."errorimg.gif");
            $error1img = file_get_contents(TOPICIMG_PATH."errorimg1.gif");
            foreach($TopicModels as $topic){
            sleep(1);   
            echo "<hr/>{$topic->t_id}";
            flush();
            echo "<pre>";
                $str=$topic->t_con;
               /* $pattern="/<[img|IMG].*?src=\"(http:\/\/latex.codecogs.com\/.*?)\".*?title=\"(.*?)\".*?[\/]?>/"; */
                 $pattern="/<[img|IMG].*?src=\"(.*?)\".*?title=\"(.*?)\".*?[\/]?>/"; 
                preg_match_all($pattern,$str,$match);
                foreach($match[1] as $k=>$url){
                    $delArr=array(); 
                    $imgurl="http://latex.codecogs.com/gif.latex?{$match[2][$k]}";
                    $url1=str_replace("&space","",str_replace("gif.latex?","gif.latex?.",str_replace(" ","",$imgurl)));
                    $name="{$topic->t_id}_con".time().mt_rand(1000,9999).".gif";
                    echo "[{$url}]--[{$url1}]<br/>";
                    echo '<script>downscroll();</script>';flush();
                    $tmpimg=@file_get_contents($url1);
                    if($tmpimg){
                    echo "ok";
                    }else{
                    
                    echo "no";
                    }
                    if($tmpimg&&$tmpimg!=$error0img&&$tmpimg!=$error1img&&file_put_contents(TOPICIMG_PATH.$name,$tmpimg)){
                        if(strpos($url,'/topicimage/')&&file_exists(DOCUMENTROOT.$url))$delArr[]=DOCUMENTROOT.$url;
                        $topic->t_con=str_replace($url,TOPICIMG_Url.$name,$topic->t_con);
                        // var_dump($topic->t_con);echo "<br/>";
                        // var_dump($url);echo "<br/>";
                        if($topic->save()){
                            // var_dump($delArr);
                            foreach($delArr as $delfile)unlink($delfile);
                            echo "ID【{$topic->t_id}】题目的题目内容字段【t_con】图片抓取成功<br/>";
                        }else{ 
                            echo "ID【{$topic->t_id}】题目的题目选项字段【t_con】图片抓取失败<br/>";
                        }
                    }else{
                        $error[]=$topic->t_id;
                        echo "抓取错误";
                    }
                }
            flush();
                $str=$topic->t_article;
                /*$pattern="/<[img|IMG].*?src=[\"](http:\/\/latex.codecogs.com\/.*?)[\"].*?[\/]?>/"; */
                preg_match_all($pattern,$str,$match);     
                foreach($match[1] as $k=>$url){
                    $delArr=array(); 
                    
                    $imgurl="http://latex.codecogs.com/gif.latex?{$match[2][$k]}";
                    $url1=str_replace("&space","",str_replace("gif.latex?","gif.latex?.",str_replace(" ","",$imgurl)));
                    $name="{$topic->t_id}_article".time().mt_rand(1000,9999).".gif";
                    echo "[{$url}]--[{$url1}]<br/>";
                    echo '<script>downscroll();</script>';flush();
                    $tmpimg=@file_get_contents($url1);
                    if($tmpimg){
                    echo "ok";
                    }else{
                    echo "no";
                    }
                    if($tmpimg&&$tmpimg!=$error0img&&$tmpimg!=$error1img&&file_put_contents(TOPICIMG_PATH.$name,$tmpimg)){
                        if(strpos($url,'/topicimage/')&&file_exists(DOCUMENTROOT.$url))$delArr[]=DOCUMENTROOT.$url;
                        $topic->t_article=str_replace($url,TOPICIMG_Url.$name,$topic->t_article);
                        if($topic->save()){
                            // var_dump($delArr);
                            foreach($delArr as $delfile)unlink($delfile);
                            echo "ID【{$topic->t_id}】题目的题目文章字段【t_article】图片抓取成功<br/>";
                        }else{
                            echo "ID【{$topic->t_id}】题目的题目选项字段【t_article】图片抓取失败<br/>";
                        }
                    }else{
                        $error[]=$topic->t_id;
                        echo "抓取错误";
                    }
                }
            flush();
                $t_daxxArr=$topic->t_daxx?unserialize($topic->t_daxx):array();
                if($t_daxxArr){
                    $edittype=false;
                    $delArr=array();
                    foreach($t_daxxArr as $key=>$daxx){
                    $str=$daxx;
                        /*$pattern="/<[img|IMG].*?src=[\"](http:\/\/latex.codecogs.com\/.*?)[\"].*?[\/]?>/"; */
                        preg_match_all($pattern,$str,$match);       
                        foreach($match[1] as $k=>$url){
                            
                            $imgurl="http://latex.codecogs.com/gif.latex?{$match[2][$k]}";
                            $url1=str_replace("&space","",str_replace("gif.latex?","gif.latex?.",str_replace(" ","",$imgurl)));
                            $name="{$topic->t_id}_daxx".time().mt_rand(1000,9999).".gif";
                            echo "[{$url}]--[{$url1}]<br/>";
                            echo '<script>downscroll();</script>';flush();
                            $tmpimg=@file_get_contents($url1);
                            if($tmpimg){
                            echo "ok";
                            }else{
                            echo "no";
                            }
                            if($tmpimg&&$tmpimg!=$error0img&&$tmpimg!=$error1img&&file_put_contents(TOPICIMG_PATH.$name,$tmpimg)){
                                if(strpos($url,'/topicimage/')&&file_exists(DOCUMENTROOT.$url))$delArr[]=DOCUMENTROOT.$url;
                                $t_daxxArr[$key]=str_replace($url,TOPICIMG_Url.$name,$t_daxxArr[$key]);
                                $edittype=true;
                            }else{
                                echo "抓取错误";
                                $error[]=$topic->t_id;
                            }
                        }
                    }
                    if($edittype){
                        $topic->t_daxx=serialize($t_daxxArr);
                        if($topic->save()){
                            // var_dump($delArr);
                            foreach($delArr as $delfile)unlink($delfile);
                            echo "ID【{$topic->t_id}】题目的题目选项字段【t_daxx】图片抓取成功<br/>";
                        }else{
                            echo "ID【{$topic->t_id}】题目的题目选项字段【t_daxx】图片抓取失败<br/>";
                        }
                    }
                }
                
                print_r($topic->t_con);
                print_r($topic->t_article);
                print_r(unserialize($topic->t_daxx));
                echo "</pre>";
                echo '<script>downscroll();</script>';
                flush(); 
            }
            
                var_dump($error);
                echo "<br/>";
                var_dump(array_unique($error));
        }
        
        $this->render("pinyin",array(
            "return"=>$return,
            'error'=>''
        ));
    }
   
}