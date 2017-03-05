<?php

/**
 * This is the model class for table "{{organization}}".
 *
 * The followings are the available columns in table '{{organization}}':
 * @property integer $o_id
 * @property string $o_name
 * @property string $o_contacts
 * @property string $o_tel
 * @property string $o_web
 * @property string $o_address
 * @property string $o_code
 * @property integer $o_pid
 */
class Organization extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Organization the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{organization}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('o_name, o_pid', 'required'),
			array('o_pid', 'numerical', 'integerOnly'=>true),
			array('o_name, o_contacts, o_zone, o_tel', 'length', 'max'=>200),
			array('o_web, o_address', 'length', 'max'=>500),
			array('o_code', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('o_id, o_name, o_contacts, o_tel, o_web, o_address, o_code, o_pid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'o_id' => 'O',
			'o_name' => '名称',
			'o_contacts' => '联系人',
			'o_tel' => '电话',
			'o_web' => '网站',
			'o_address' => '地址',
			'o_code' => '代码',
			'o_pid' => '所属',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('o_id',$this->o_id);
		$criteria->compare('o_name',$this->o_name,true);
		$criteria->compare('o_contacts',$this->o_contacts,true);
		$criteria->compare('o_tel',$this->o_tel,true);
		$criteria->compare('o_web',$this->o_web,true);
		$criteria->compare('o_address',$this->o_address,true);
		$criteria->compare('o_code',$this->o_code,true);
		$criteria->compare('o_pid',$this->o_pid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * 通过公司ID获取公司名称
     * @param integer $key 公司ID
     * @retuen string 公司名称
     */
	public function getNameByOid($key){       
        $return=Yii::app()->cache->get("organization_name_{$key}");
        if($return==false){
            $criteria=new CDbCriteria;
            $criteria->select="o_name";
            $criteria->addCondition("o_id ='{$key}'");
            $model=$this->find($criteria);
            $return=$model?$model->o_name:"";
            Yii::app()->cache->set("organization_name_{$key}",$return,Yii::app()->params->cacheTime);
        }
		
       return $return;
	}
    
    /**
     * 通过公司ID获取公司数据
     * @param integer $oid 公司ID
     * @param string $fields 公司表字段 默认为空则所有
     * @retuen string or object 公司表字段数据 或 公司表数据对象
     */
	public function getOById($oid,$fields='') {
        $return=Yii::app()->cache->get("organization_{$fields}_{$oid}");
        if($return==false){        
            $criteria=new CDbCriteria;
            if($fields)$criteria->select=$fields;
            $criteria->addCondition("o_id ='{$oid}'");
            $return=$this->find($criteria);
            Yii::app()->cache->set("organization_{$fields}_{$oid}",$return,Yii::app()->params->cacheTime);
        }
        return $return;
    }
    
    /**
     * 通过公司ID得到公司代码
     * @param integer $oid 公司ID
     * @retuen string 公司代码
     */
	public function getCodeById($oid) {
        $model= $this->getOById($oid);
		return $model?$model->o_code:"";
    }
    
    /**
     * 获取所有报名点
     * @retuen array 报名点列表数组 attributes(key=>o_id)
     */
	public function getAllbaomingdianId() {
        $Pmodel=$this->findAll("o_pid='0' and o_isdel=1");
		$PidArr=array();
		foreach($Pmodel as $val)$PidArr[]=$val->o_id;
		return $PidArr;
    }
    
    /**
     * 获取所有机构
     * @retuen array 机构列表数组 attributes(key=>o_id)
     */
	public function getAlljigouId($order='o_id asc') {
		$JigouIdArr=$this->getAllbaomingdianId();
		$PidArr=array();
		if($JigouIdArr){
			$Pmodel=$this->findAll("o_pid in (".join(",",$JigouIdArr).") and o_isdel=1");
			foreach($Pmodel as $val)$PidArr[]=$val->o_id;
		}
		return $PidArr;
    }
    
    /**
     * 获取下一级公司列表
     * @pid integer 上一级公司ID
     * @retuen array 公司列表数组 attributes(o_id=>o_name)
     */
	public function getOrByPid($pid,$isAll=false){
        $PidArr=Yii::app()->cache->get("organization_array_{$pid}");       
        if($PidArr==false){
            $criteria = new CDbCriteria;
            $criteria->select='o_id,o_name';
            $criteria->addCondition('o_pid='.$pid.' ');
            if($isAll==false)$criteria->addCondition('o_isdel=1');
            $PidArr=array();
            if($pid||$pid=="0"){
                $Pmodel=$this->findAll($criteria);
                foreach($Pmodel as $val)$PidArr[$val->o_id]=$val->o_name;
            }
            Yii::app()->cache->set("organization_array_{$pid}",$PidArr,Yii::app()->params->cacheTime);
        }
        return $PidArr;
	}
    
    /**
     * 获取所有下级公司列表
     * @pid integer 父公司ID
     * @PidArr array 已有的ID数组 默认为空传值用
     * @type boolean 真的情况下保留自我ID
     * @retuen array 公司列表数组 attributes(key=>o_id)
     */
	public function getAllid($id,$PidArr=array(),$type=true,$isAll=false){
        $typeStr=$type?"true":"false";
        $return=Yii::app()->cache->get("organization_".join("-",$PidArr)."_{$typeStr}_{$id}"); 
        if($return==false){
            if($id){
                if($type)$PidArr[]=$id;
                $criteria = new CDbCriteria;
                $criteria->addCondition("o_pid='{$id}'");
                if(!$isAll)$criteria->addCondition('o_isdel=1');
                $Pmodel=$this->findAll($criteria);
                foreach($Pmodel as $val){
                    $PidArr=$this->getAllid($val->o_id,$PidArr);
                } 
                $return=$PidArr;          
            }
        Yii::app()->cache->set("organization_".join("-",$return)."_{$typeStr}_{$id}",$PidArr,Yii::app()->params->cacheTime);
        }
		return $return;
	}
	
    /**
     * 获取所有下级公司列表
     * @pid integer 父公司ID
     * @PidArr array 已有的ID数组 默认为空传值用
     * @type boolean 真的情况下保留自我ID
     * @retuen array 公司列表数组 attributes(o_id=>o_name)
     */
	public function getAllC($id,$PidArr=array(),$index=0){
        $return=$PidArr?$PidArr:Yii::app()->cache->get("organization_allc_{$id}{$index}");
        if($return == false){
			$str='';
			for($i=0;$i<$index;$i++){
				if($i==1)$str.="　　";
				if($i+1==$index)$str.="└──";
			}
			$Pmodel=$this->findAll("o_pid='{$id}' and o_isdel=1");
			foreach($Pmodel as $val){
				$PidArr[$val['o_id']]=$str." ".$val['o_name'];
				$index++;
				$PidArr=$this->getAllC($val->o_id,$PidArr,$index);
				$index--;
				
			}
            $return=$PidArr;
            Yii::app()->cache->set("organization_allc_{$id}{$index}",$return,Yii::app()->params->cacheTime);
        }
        return  $return;
	}
    
    /**
     * 循环获取帐户所属机构
     * @param integer $oid 公司ID
     * @return array 公司数组级 键越小 级别越大 attributes(key=>object)
     */
    public function getOrgnization($oid){
        $OModel=array();
        for($i=0;$i<3;$i++){    
            $omodel1=Organization::model()->getOById($oid);//Organization::model()->findByPk($oid);
            $OModel[$i]=$omodel1;
            if(!$omodel1||$omodel1->o_pid=="0"||!$omodel1->o_pid)break;
            else $oid=$omodel1->o_pid;
        }
        
        return $OModel;
     }
}