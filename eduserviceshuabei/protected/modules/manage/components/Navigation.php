<?php
Yii::import("zii.widgets.CPortlet");
Yii::import("system.web.widgets.CTreeView");
class Navigation extends CPortlet {
    public $currentMenu = 0;//记录当前的菜单id
    public $parentsMenuIds = array();//记录当前菜单id的所有父级id集合
    public function init() {
        if(array_key_exists("m", $_GET)) {
            $this->currentMenu = $_GET['m'];
        }
        parent::init();
    }
    //得到第一级菜单
    protected function getHeadMenu() {
        return $this->getMenuByParent(0);
    }
    /**
     * 根据父类id得到子集菜单
     * @param <type> $parentId
     * @return <type>
     */
    protected function getMenuByParent($parentId) {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("select * from `35_managemenu` where `m_parentid`='{$parentId}'");  
		$data = $command->queryAll();  
        return $menus;
    }
    /*
     * @return data for the tree
    */
    protected function formatData($person) {
        return array(
                'text'=>$person['m_link']?CHtml::link($person['m_name'],array($person['m_link'],'m'=>$person['m_id'])):$person['m_name'],
                'id'=>$person['m_id'],
                'hasChildren'=>isset($person['children']),
                'expanded'=>false,
        );
    }
    /*
     * 得到所有的菜单数据。普通用户看不到配置数据
    */
    public function getData() {
        $userId = Yii::app()->user->id;
        $data = array();
        $connection = Yii::app()->db;
        $command = $connection->createCommand("SELECT * FROM `es_managemenu` where find_in_set({$userId},`m_role`) ORDER BY m_parentid");  
		$data = $command->queryAll();  
        return $data;
    }
    /**
     * 根据菜单数据递归循环,得到需要使用的数据结构
     * @param <int> $id 父级菜单主键id
     * @param <array> $data 所有菜单数据
     * @return <array> CTreeView需要使用的数据结构
     */
    public function getDataFormatted($id,$data) {
        // $cacheId = Yii::app()->params['authMenueCacheFix'].Yii::app()->user->id;
        //if(($personFormatted=Yii::app()->cache->get($cacheId))===FALSE) {
            $personFormatted = array();
            foreach($data as $k=>$person) {
               
                if($person['m_parentid']==$id) {
               
                    $personFormatted[$k]=$this->formatData($person);
                    $children=$this->getDataFormatted($person['m_id'],$data);
                    if($children) {
                        $personFormatted[$k]['children']=$children;
                    }
                    if( ! Yii::app()->user->checkAccess(strtolower($person['m_link'])) ) {
                        if($children){
                            $personFormatted[$k]['text'] = $person['m_name'];
                        }else{
                            // unset($personFormatted[$k]);
                        }
                    }
                }
            }
                    
            //Yii::app()->cache->set($cacheId,$personFormatted,86400);
        //}
        
        return $personFormatted;
    }
    /**
     * 递归查询当前菜单的父类节点id
     * @param <type> $childId 子类节点id
     * @param <type> $data 所有菜单数据
     */
    public function recursiveFindParentMenuIds($childId,$data) {
        foreach($data as $ke=>$cell) {
            if($cell['m_id']==$childId) {
                array_push($this->parentsMenuIds,$cell['m_parentid']);
                $this->recursiveFindParentMenuIds($cell['m_parentid'],$data);
            }
        }
    }
    public function renderContent() {
        $cacheId = Yii::app()->params['authMenueCacheFix'].Yii::app()->user->id;
        if(($menuData=Yii::app()->cache->get($cacheId."data"))===FALSE){
            $menuData = $this->getData();
            Yii::app()->cache->set($cacheId."data",$menuData);
        }

        if(Yii::app()->controller->beginCache($cacheId, array('duration'=>Yii::app()->params->cacheTime,'varyByRoute'=>FALSE))) {
                $parentIds = $this->recursiveFindParentMenuIds($this->currentMenu,$menuData);
                echo '<script>var parentslist=['.implode(',', $this->parentsMenuIds).'];</script>';
                $allMenu = $this->getDataFormatted(0,$menuData);
                $this->render('navigation',array('data'=>$allMenu));
                Yii::app()->controller->endCache();
        }
    }
    /**
     * 类变量赋值
     */
    public function __set($key, $value) {
        $this->$key = $value;
    }

    /**
     * 获取类变量值
     */
    public function __get($key) {
        return $this->$key;
    }
}