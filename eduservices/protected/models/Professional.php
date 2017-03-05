<?php

/**
 * This is the model class for table "{{professional}}".
 *
 * The followings are the available columns in table '{{professional}}':
 * @property integer $p_id
 * @property string $p_code
 * @property string $p_name
 * @property integer $p_pid
 */
class Professional extends CActiveRecord
{
    public static $type=array(
        1=>"文科",
        2=>"理科",
    );
     public static $status=array(
        "1"=>"启用",
        "2"=>"禁用",
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Professional the static model class
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
		return '{{professional}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('p_code, p_name, p_pid', 'required'),
			array('p_pid, p_type, p_status', 'numerical', 'integerOnly'=>true),
			array('p_code', 'length', 'max'=>50),
			array('p_name', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('p_id, p_code, p_name, p_pid', 'safe', 'on'=>'search'),
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
			'p_id' => 'P',
			'p_code' => 'P Code',
			'p_name' => 'P Name',
			'p_pid' => 'P Pid',
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

		$criteria->compare('p_id',$this->p_id);
		$criteria->compare('p_code',$this->p_code,true);
		$criteria->compare('p_name',$this->p_name,true);
		$criteria->compare('p_pid',$this->p_pid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * 通过专业ID获取报考专业下拉列表
     * @param integer $zyID 专业ID
     * @retuen array 专业列表 attributes(p_id=>p_name)
     */
	public function getKCInfo($zyID,$type=true){
        if($zyID==0)return array();
        $return=Yii::app()->cache->get("get_kc_{$zyID}");
        if($return==false){
            $criteria = new CDbCriteria;
            $criteria->select='p_name,p_id';
            if($type)$criteria->addCondition("p_status = 1 ");
            $criteria->addCondition("p_pid ='{$zyID}' and p_isdel=1 ");
            $criteria->order="p_id asc ";         
            $model=$this->findAll($criteria);
            $return=$this->toArray($model);
            Yii::app()->cache->set("get_kc_{$zyID}",$return,Yii::app()->params->cacheTime);
        }
        return $return;
	}
    
    /**
     * 获取所有专业名称
     * @retuen array 专业列表 attributes(p_id=>p_name)
     */
    public function getKCName(){
		$model=$this->findAll();
		return $this->toArray($model,'p_name');
	}
    
    /**
     * 获取所有专业代码
     * @retuen array 专业代码 attributes(p_id=>p_code)
     */
	public function getKCCode(){
		$model=$this->findAll();
		return $this->toArray($model,'p_code');
	}
    
    /**
     * 根据$id 获取专业名称
     * @param integer $id 专业ID
     * @retuen string 专业名称
     */
	public function getZyName($id){ 
        if($id==0)return '';
        $return=Yii::app()->cache->get("professional_name_{$id}");
        if($return==false){
            $criteria = new CDbCriteria;
            $criteria->select='p_name';
            $criteria->addCondition("p_id ={$id} and p_isdel=1 ");
            $model=$this->find($criteria);
            $return=$model?$model->p_name:"";
            Yii::app()->cache->set("professional_name_{$id}",$return,Yii::app()->params->cacheTime);
        }
        return $return;
	}
    
    /**
     * 把结果集数组化
     * @param object $model 结果集对象
     * @param string $field  字段名称 返回数据库对应字段名称的值赋予 数组的值 
     * @return array 字段名称的数组 attributes(p_id=>$field)
     */
	public function toArray($models,$field='p_name'){
		$return=array();
		foreach($models as $val){
			$return[$val->p_id]=$val->$field;
		}
		return $return;
	
	}
}