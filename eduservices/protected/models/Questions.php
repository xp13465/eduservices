<?php

/**
 * This is the model class for table "{{questions}}".
 *
 * The followings are the available columns in table '{{questions}}':
 * @property integer $q_id
 * @property string $q_name
 * @property integer $q_pid
 * @property integer $q_type
 * @property integer $q_isdel
 */
class Questions extends CActiveRecord
{
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Questions the static model class
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
		return '{{questions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('q_pid, q_type, q_isdel', 'numerical', 'integerOnly'=>true),
			array('q_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('q_id, q_name, q_pid, q_type', 'safe', 'on'=>'search'),
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
			'q_id' => 'ID',
			'q_name' => '题库名称',
			'q_pid' => '题库父ID',
			'q_type' => '题库类型',
			'q_isdel' => '是否删除',
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

		$criteria->compare('q_id',$this->q_id);
		$criteria->compare('q_name',$this->q_name,true);
		$criteria->compare('q_pid',$this->q_pid);
		$criteria->compare('q_type',$this->q_type);
		$criteria->compare('q_isdel',$this->q_isdel);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * 根据题库集ID，获取相应题库
     * @param integer $pid  题库ID
     * @return array 返回经过对象转换层数组的题库数组 attributes (q_id=>q_name)
     */
    public function getAllTK($Pid=0){
        $return =array();
        if($Pid){
            $models=$this->findAll("q_pid='{$Pid}' and q_isdel=1");
            $return =$this->toArray($models);
        }else{
             $models=$this->findAll("q_pid=0 and q_type=1 and q_isdel=1");
             $return =$this->toArray($models);
        }
        return $return ;
    }
    
    /**
     * 将题库对象转成数组
     * @param object $models  数据结果集对象  
     * @return array 数据 attributes (q_id=>q_name)
     */
    public function toArray($models){
        $array=array();
        foreach($models as $key=>$val){
            $array[$val->q_id]=$val->q_name;
        }
        return $array;
    
    }
    
    /**
     * 获取题库父ID获取题库集名称
     * @param integer $id  主键ID
     * @return string 返回题库集名称
     */
    public function getNameById($id){
        $return='';
        $cacheTime=Yii::app()->params->cacheTime;
        if($id){
            $return=@Yii::app()->cache->get("question_name_{$id}");
            if($return==false){
                $criteria=new CDbCriteria;
                $criteria->select='q_name,q_id';
                $criteria->addCondition("q_id ='{$id}'");
                $model = $this->find($criteria);
                $return=$model?$model->q_name:"";
                Yii::app()->cache->set("question_name_{$id}",$return,$cacheTime);
            }
        }
        return $return;
    }
    
    /**
     * 根据主键获取一条记录
     * @param integer $uid 主键ID
     * @return object 记录集对象
     */
	public function getQById($uid) {
        return $this->findByPk($uid);
    }
    
    /**
     * 获取所有题库集ID数组
     * @return array 返回所有题库集ID组成的一维数组
     */
	public function getAlltikujiId() {
        $cacheTime=Yii::app()->params->cacheTime;
		$PidArr=array();
        $PidArr=@Yii::app()->cache->get("questions_qp");
        if(!$PidArr){
            $Pmodel=$this->findAll("q_pid='0' and q_isdel=1");
            foreach($Pmodel as $val)$PidArr[]=$val->q_id;
            Yii::app()->cache->set("questions_qp",$PidArr,$cacheTime);
        }
		return $PidArr;
    }
    
    /**
     * 获取所有题库集ID为key,题库集名称为value的一维数组
     * @param integer $pid  题库集ID
     * @return array 返回所有题库集ID为key,题库集名称为value的一维数组
     */
	public function getQrByPid($pid){
        $cacheTime=Yii::app()->params->cacheTime;
		$PidArr=array();
        $PidArr=@Yii::app()->cache->get("questions_qn_arr_{$pid}");
		if($pid||$pid=="0"){
            if(!$PidArr){
                $criteria = new CDbCriteria;
                $criteria->select='q_name,q_id';
                $criteria->addCondition("q_pid='{$pid}'");
                $criteria->addCondition("q_isdel=1");
                $Pmodel = $this->findAll($criteria);
                foreach($Pmodel as $val)$PidArr[$val->q_id]=$val->q_name;
                Yii::app()->cache->set("questions_qn_arr_{$pid}",$PidArr,$cacheTime);
            }
		}
		return $PidArr;
	}
    
    /**
     * 根据题库集ID获取题库ID
     * @param integer $pid
     * @return array
     */
    public function getAlltikuIdByPid($pid){
        $cacheTime=Yii::app()->params->cacheTime;
		$PidArr=array();
        $PidArr=@Yii::app()->cache->get("questions_qid_arr_{$pid}");
		if($pid||$pid=="0"){
            if(!$PidArr){
                $criteria = new CDbCriteria;
                $criteria->select='q_id';
                $criteria->addCondition("q_pid='{$pid}'");
                $criteria->addCondition("q_isdel=1");
                $Pmodel = $this->findAll($criteria);
                foreach($Pmodel as $val)$PidArr[]=$val->q_id;
                Yii::app()->cache->set("questions_qid_arr_{$pid}",$PidArr,$cacheTime);
            }
		}
		return $PidArr;
    }
    
    /**
     * 根据题库名称获取题库ID
     * @param string $tname
     * @return integer $ID;
     */
    public function getTikuIdByName($tname){
        $cacheTime=Yii::app()->params->cacheTime;
		$ID=0;
        $ID=@Yii::app()->cache->get("questions_qname_arr_{$tname}");
        if($tname!=""){
            if(!$ID){
                $criteria = new CDbCriteria;
                $criteria->select='q_id';
                $criteria->addCondition("q_name = '{$tname}' ");
                $criteria->addCondition("q_isdel=1");
                $Pmodel = $this->find($criteria);  
                $ID = $Pmodel->q_id;
                Yii::app()->cache->set("questions_qname_arr_{$tname}",$ID,$cacheTime);
            }
		}
		return $ID;
    }    
}