<?php
class AdminController extends Controller
{
    public $layout = "admin";
    public function actionIndex()
    {
        $this->render("index");
    }
	public function actionGetbk($mid = 0,$typeid=0) {
		// echo $mid;
		// echo $typeid;	
		$cacheTime=Yii::app()->params->cacheTime;
		$data=array();
		if($typeid==1){
			$name='请选择报考层次';
			$bname='选择最高学历加载层次...';
			$data=@Yii::app()->cache->get("professionallevel_{$mid}");
			if(!$data){
				if($mid==1)$data=Lookup::model()->getClassInfo('professionallevel','3');
				elseif($mid	==0)$data=array();
				else$data=Lookup::model()->getClassInfo('professionallevel');
				Yii::app()->cache->set("professionallevel_{$mid}",$data,$cacheTime);
			}
			
		}elseif($typeid==2){
			$name='请选择报考专业';
			$bname='选择层次加载专业...';
			$data=@Yii::app()->cache->get("professional_{$mid}");
			if(!$data){
				$data=	Professional::model()->getKCInfo($mid);
				Yii::app()->cache->set("professional_{$mid}",$data,$cacheTime);
			}
		}
	   // $data = Students::$highesteducation;
	   
	   echo CHtml::tag('option', array('value'=>''), $data?$name:$bname, true);

	   foreach($data as $value=>$name) {

		   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

	   }

	}
	public function actionCleanCache(){
        Yii::app()->cache->flush();
        echo "admincache is clean";exit;
    }
    public function actionChangeverifytype(){
        if(Yii::app()->user->role==4&&isset($_POST['value'])&&in_array($_POST['value'],array(1,2,3))){
            $count =Config::model()->updateAll(array('c_value'=>$_POST['value']),"c_varname = 'verifyType'"); 
			if($count>0){  
			   echo "ok";  
			}
        }
    }
	public function actionGetorganization($pid = 0,$typeid=1) {
		// echo $pid;
		// echo $typeid;	
		$data=array();
		$cacheTime=Yii::app()->params->cacheTime;
			if($typeid==1){
				$name='请选择报名点名称';
				if($pid){
					$data=@Yii::app()->cache->get("baomingdian_{$pid}");
					if(!$data){
					$data=	Organization::model()->getOrByPid($pid);
					 Yii::app()->cache->set("baomingdian_{$pid}",$data,$cacheTime);
					}
				}
			}elseif($typeid==2){
				$name='请选择机构名称';
				if($pid){
					$data=@Yii::app()->cache->get("jigou_{$pid}");
					if(!$data){
					$data=	Organization::model()->getOrByPid($pid);
					 Yii::app()->cache->set("jigou_{$pid}",$data,$cacheTime);
					}
				}
			}
		
		// var_dump($data);
	   // $data = Students::$highesteducation;
	   echo CHtml::tag('option', array('value'=>''), $name, true);

	   foreach($data as $value=>$name) {

		   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

	   }

	}
	public function actionGetscode(){
		if(Yii::app()->request->isAjaxRequest && isset($_GET['name'])) {
			$school=School::model()->find("s_name='{$_GET['name']}'");
			if($school)echo $school->s_code;
		
		}
	}
	public function actionGetsfcode(){
		if(isset($_GET['num'])){
			$cacheTime = Yii::app()->params->cacheTime;
			$sfjsoncode = Yii::app()->cache->get("sfcode_{$_GET['num']}");
            if($sfjsoncode==false) {
                $sfcode=simplexml_load_file("http://www.youdao.com/smartresult-xml/search.s?type=id&q={$_GET['num']}");
				$array=array();
				if($sfcode){
					foreach($sfcode as $tmp){
						$array['birthday']=$tmp->birthday;
						$array['location']=$tmp->location;
						$array['code']=$tmp->code;
						$array['sex']=$tmp->gender=='m'?1:0;
					}
				}
				Yii::app()->cache->set("sfcode_{$_GET['num']}",json_encode($array),$cacheTime);
				$sfjsoncode=$array?json_encode($array):'';
			}
			echo $sfjsoncode;
			exit();
		}
	}
	/**
     * 自动完成
     */
    public function actionAjaxAutoComplete() {
        if(Yii::app()->request->isAjaxRequest && isset($_GET['q'])&&isset($_GET['type'])) {
            $cacheTime = Yii::app()->params->cacheTime;
            //先得到所有数据 $allDate 的格式为array(id, name, egshort, eglong)
            switch($_GET['type']) {
                default:
                    $allDate = array();
                    break;
                case 1://楼盘
                    $allDate = @@Yii::app()->cache->get("autocomplete_school");
                    if($allDate==false) {
                        $allDate = School::model()->getAutoCompleteData(1);
                        Yii::app()->cache->set("autocomplete_school",$allDate,$cacheTime);
                    }
                    break;
            }
			// print_r($allDate);
            $name = $_GET['q'];
            $limit = min($_GET['limit'], 50);
            $returnVal = '';
            if($allDate) {
                $num = 0;
                foreach($allDate as $key=>$value) {
                    if($num>$limit) {
                        break;
                    }
                    $check = false;
                    if(preg_match ("/".$name."/i", $value['name'])) {
                        $check = true;
                    }elseif(preg_match ("/".$name."/i", $value['egshort'])) {
                        $check = true;
                    }elseif(preg_match ("/".$name."/i", $value['eglong'])) {
                        $check = true;
                    }
                    //如果符合条件
                    if($check) {
                        $num += 1;
                        $returnVal .= trim($value['name']).'|'.$value['id']."\n";
                    }
                }
            }
//            return  array("1"=>"asdf");
            echo $returnVal;
        }
    }

     public function actionGettk($mid = 0) {
		// echo $mid;
		// echo $typeid;	
       
		$cacheTime=Yii::app()->params->cacheTime;
		$data=array();
        
		$name='请选择题库';
		$bname='选择题库集加载题库';
		$data=@Yii::app()->cache->get("questions_{$mid}");
		if(!$data){
            $data=$mid?Questions::model()->getAllTK($mid):array();
			Yii::app()->cache->set("questions_{$mid}",$data,$cacheTime);
		}
			
		
	   // $data = Students::$highesteducation;
	   
        echo CHtml::tag('option', array('value'=>''), $data?$name:$bname, true);

        foreach($data as $value=>$name) {

		   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

	   }

	}
    public function actionGetzs($mid = 0) {
		// echo $mid;
		// echo $typeid;	
       
		$cacheTime=Yii::app()->params->cacheTime;
		$data=array();
		$name='所有';
		$bname='所有';
		$data=@Yii::app()->cache->get("know_{$mid}");
		if(!$data){
            $data=$mid?Topic::model()->getAllZS($mid):array();
			Yii::app()->cache->set("know_{$mid}",$data,$cacheTime);
		}
			
        echo CHtml::tag('option', array('value'=>''), $data?$name:$bname, true);

        foreach($data as $value=>$name) {

		   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);

	   }

	}
    public function actionGetstcl($tkj,$tk,$level,$know='') {
        
        $criteria=new CDbCriteria;
        $criteria->addCondition("t_qid ='{$tk}'");
        $criteria->addCondition("t_level ='{$level}'");
		if($know)$criteria->addCondition("t_know ='{$know}'");
		$count=Topic::model()->count($criteria);
        // print_r($count);
		// print_r($_GET);exit;
        $tkjName=Questions::model()->getNameById($tkj);
        $tkName=Questions::model()->getNameById($tk);
        $knowName=$know?$know:"所有";
        echo '<tr>';
		echo "<td>{$tkjName}</td>";
        echo "<td>{$tkName}</td>";
        echo "<td>{$knowName}</td>";
        echo "<td>{$level}</td>";
        echo "<td>
        <input class='span2' type='hidden' name='tkcltkj[]' value='{$tkj}'>
        <input class='span2' type='hidden' name='tkcltk[]' value='{$tk}'>
        <input class='span2' type='hidden' name='tkcllevel[]' value='{$level}'>
        <input class='span2' type='hidden' name='tkclknowName[]' value='{$knowName}'>
        <input class='span2' type='text' onchange='checktmnum(this)' name='tkclvalue[]' value='0'><span>&nbsp;/&nbsp;</span><font >{$count}</font></td>";
		echo "<td><a href='javascript::void()' onclick='delcl(this)'>删除</a></td>";
		echo '</tr>';

	}
    
    public function actionStatistics() {
        
        if(Yii::app()->user->role!=4)throw new CHttpException(400,'无效的请求。请不要再这样的要求。');
        $this->render("statistics");
        
	}
}