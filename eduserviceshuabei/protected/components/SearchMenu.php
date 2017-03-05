<?php
Yii::import("zii.widgets.CPortlet");
class SearchMenu extends CPortlet {
    /**
     * 搜索中出现的键名
     * @var <type>
     */
    private static $templeteKey = array(
            "type"=>"a",//类型
            "district"=>"b",//区
            "section"=>"c",//版块
            "company"=>"d",//公司名称
            "level"=>"e",//等级
            "order"=>"f",//排序
    );
    public static $getName= "search";//搜索中get名称


    private $searchCondition = array();//当前的查询条件
    private $baseUrl = "";
    private $unUseKey = "";//没有使用的key
    public function renderContent() {
        $controller = Yii::app()->controller->getID();
        $action = Yii::app()->controller->getAction()->getID();
        $this->baseUrl = "/".$controller."/".$action;//基本地址

        $existOptions = $this->explodeAllParamsToArray();//用来记录已经保存的条件
        $this->searchCondition = $existOptions;
        if(isset($existOptions["type"])) {
            if($existOptions["type"]==0) {//个人，显示版块
                //去除不可使用的参数
                $this->searchCondition = $this->delUnUseParam("company");//不能有公司的参数
                $this->unUseKey = "section";
            }else {//显示公司
                $this->searchCondition = $this->delUnUseParam("section");//不能有版块的参数
                $this->unUseKey = "company";
            }
        }
        echo '<div class="city">';
        $this->showType();
        $this->showDistrict();
        if(isset($existOptions["type"])&&isset($existOptions["district"])) {
            echo '<div class="citycont">';
            if($existOptions["type"]==0) {//个人，显示版块
                $this->showSection();
            }else {//显示公司
                $this->showCompany();
            }
            echo "</div>";
        }
        $this->showLevel();
        echo "</div>";
    }
    private function delUnUseParam($templeteKey) {
        $arr = array();
        foreach($this->searchCondition as $key=>$value) {
            if($key!=$templeteKey) {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }
    /**
     * 显示公司名称
     */
    private function showCompany() {
        $templeteKey = "company";
        $this->getBuXianUrl($templeteKey);
        $data = Companymanage::model()->getAllCompanyList($this->searchCondition['district'], $this->searchCondition['type'], false);
        foreach($data as $value) {
            if(isset($this->searchCondition[$templeteKey])&&$this->searchCondition[$templeteKey]==$value->cm_id) {
                echo "<em>".$value->cm_companyname."</em>";
            }else {
                $this->getConditionUrl($value->cm_companyname, $value->cm_id, $templeteKey);
            }
        }
    }
    /**
     * 显示版块
     */
    private function showSection() {
        $templeteKey = "section";
        $this->getBuXianUrl($templeteKey);

        $data = Region::model()->getAllGroupList($this->searchCondition['district'],false, "re_pinyin");
        $pinyin = $data[0]["re_pinyin"];
        echo '<code>'.$pinyin.'</code>';
        foreach($data as $value) {
            if($value->re_pinyin!=$pinyin) {
                $pinyin = $value->re_pinyin;
                echo '<code>'.$pinyin.'</code>';
            }
            if(isset($this->searchCondition[$templeteKey])&&$this->searchCondition[$templeteKey]==$value->re_id) {
                echo "<em>".$value->re_name."</em>";
            }else {
                $this->getConditionUrl($value->re_name, $value->re_id, $templeteKey);
            }
        }
    }
    /**
     * 显示类型
     */
    private function showType() {
        $data = Companytype::model()->getAllType();
        $data[0] = "个人";
        $this->baseShow($data, "type");
    }
    private function showLevel(){
        $data = Memberlevel::model()->getAllLevle(true);
        $this->baseShow($data, "level");
    }
    /**
     * 显示区
     */
    private function showDistrict() {
        $data = Region::model()->getAllGroupList(35);
        $this->baseShow($data, "district");
    }
    private function baseShow($data,$templeteKey) {
        echo "<p>";
        $this->getBuXianUrl($templeteKey);
        foreach($data as $key=>$value) {
            if(isset($this->searchCondition[$templeteKey])&&$this->searchCondition[$templeteKey]==$key) {
                echo "<em>".$value."</em>";
            }else {
                $this->getConditionUrl($value, $key, $templeteKey);
            }
        }
        echo "</p>";
    }
    private function getConditionUrl($name,$value,$templeteKey) {
        $createUrlCondition = $this->searchCondition;
        $unUseKey = $this->unUseKey;
        if($unUseKey) {
            $createUrlCondition = $this->delUnUseParam($unUseKey);
        }
        $param = $this->dealOptions($createUrlCondition, $templeteKey, $value);
        $paramArr = array($this->baseUrl);
        if($param) {
            $paramArr[self::$getName] = $param;
        }
        echo CHtml::link($name,$paramArr);
    }
    private function getBuXianUrl($templeteKey) {
        if(isset($this->searchCondition[$templeteKey])) {
            $arr = array();
            foreach($this->searchCondition as $key=>$value) {
                if($key!=$templeteKey) {
                    $arr[$key] = $value;
                }
            }
            $paramArr = array($this->baseUrl);
            $param = $this->dealOptions($arr);
            if($param) {
                $paramArr[self::$getName] = $param;
            }
            echo CHtml::link("不限",$paramArr);
        }else {
            echo "<em>不限</em>";
        }
    }
    /**
     *经过短地址处理后，得到完整的get参数
     * @return <array>
     */
    public function explodeAllParamsToArray() {
        $optionStr = (isset($_GET[self::$getName])&&$_GET[self::$getName]!="")?strtolower($_GET[self::$getName]):"";
        $optionArr = explode("-", $optionStr);
        $existOptions = array();
        if($optionArr) {
            foreach(self::$templeteKey as $tkey=>$tvalue) {
                foreach($optionArr as $sv) {
                    if(preg_match ("/^".$tvalue."[0-9]+$/", $sv)) {//如果参数在可以出现的参数之内
                        $existOptions[$tkey] = substr($sv, 1);
                    }
                }
            }
        }
        return $existOptions;
    }
    /**
     *把所有参数变成一个可以使用的集合。返回值要用creatUrl生成链接
     * @param <type> $demoOption 已有的参数
     * @param <type> $key 要加的参数键名
     * @param <type> $val要加的参数健值
     * @return <array>
     */
    public function dealOptions($demoOption,$key="",$val="") {
        if($key) {
            $demoOption[$key]=$val;
        }
        $rArray = array();
        foreach($demoOption as $k=>$v) {
            if(isset(self::$templeteKey[$k])) {
                $rArray[] = self::$templeteKey[$k].$v;
            }
        }
        $return = "";
        if($rArray) {
            $return = implode("-", $rArray);
        }
        return $return;
    }
    /**
     * 外部调用去除某个key
     * @param <type> $removeKey
     * @return <type>
     */
    public function removeKey($removeKey){
        $condition = self::explodeAllParamsToArray();
        $return = array();
        foreach($condition as $key=>$value){
            if($key!=$removeKey){
                $return[$key] = $value;
            }
        }
        return $return;
    }
}