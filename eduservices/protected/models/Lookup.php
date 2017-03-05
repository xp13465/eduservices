<?php

/**
 * This is the model class for table "{{lookup}}".
 *
 * The followings are the available columns in table '{{lookup}}':
 * @property integer $lu_id
 * @property integer $lu_key
 * @property string $lu_value
 * @property string $lu_class
 * @property string $lu_info
 */
class Lookup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lookup the static model class
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
		return '{{lookup}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lu_key, lu_value', 'required'),
			array('lu_key', 'numerical', 'integerOnly'=>true),
			array('lu_value, lu_class', 'length', 'max'=>100),
			array('lu_info', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lu_id, lu_key, lu_value, lu_class, lu_info', 'safe', 'on'=>'search'),
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
			'lu_id' => 'Lu',
			'lu_key' => 'Lu Key',
			'lu_value' => 'Lu Value',
			'lu_class' => 'Lu Class',
			'lu_info' => 'Lu Info',
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
		
		$criteria->compare('lu_id',$this->lu_id);
		$criteria->compare('lu_key',$this->lu_key);
		$criteria->compare('lu_value',$this->lu_value,true);
		$criteria->compare('lu_class',$this->lu_class,true);
		$criteria->compare('lu_info',$this->lu_info,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * 获取类别数据组信息
     * @param $class string 数据分类条件
     * @param $id integer  数据ID
     * @return array  分类数组集 attributes( lu_key=>lu_value)
     */
	public function getClassInfo($class,$id=''){
        $str=$id?"and lu_key='{$id}'":"";
        $return=Yii::app()->cache->get("lookup_{$class}_{$id}");       
        if($return==false){
            $criteria=new CDbCriteria;
            $criteria->select='lu_value,lu_key,lu_code';
            $criteria->addCondition("lu_class ='{$class}'  {$str}  ");
            $criteria->order='lu_code asc';
            $model=$this->findAll($criteria);
            
            $return=$this->toArrayN($model);
            Yii::app()->cache->set("lookup_{$class}_{$id}",$return,Yii::app()->params->cacheTime);
        }
        return $return;
	}
    
    /**
     * 获取当前分类数组集
     * @param string $class 数据分类条件
     * @param integer $type 数据ID
     * @return array 分类数组集 attributes( lu_key=>lu_value)
     */
	public function getClass($class,$id=''){
		$str=$id?"and lu_key='{$id}'":"";
		$model=$this->findAll("lu_class ='{$class}'  {$str}  order by lu_code asc ");
		return $this->toArray($model);
	}
    
    /**
     * 获取对应ID的数据
     * @param integer $key 数据ID
     * @param string $type 数据分类条件
     * @return string 参数名称
     */
	public function getValueName($key,$type=''){
        $return=Yii::app()->cache->get("lookupvalue_{$type}_{$key}");
        if($return==false){
            $criteria=new CDbCriteria;
            $criteria->select='lu_value';
            $criteria->addCondition("lu_key ='{$key}'");
            if($type)$criteria->addCondition("  lu_class='{$type}'");
            $model=$this->find($criteria);
            $return=$model?$model->lu_value:"记录丢失";
            Yii::app()->cache->set("lookupvalue_{$type}_{$key}",$return,Yii::app()->params->cacheTime);
        }
        return $return;
        
	}
    
    /**
     * 把数据结果集数组化
     * @param object $models 查询结果数据集
     * @return array 结果集数组  attributes( lu_key=>lu_value)
     */
	public function toArrayN($models){
		$return=array();
		
		foreach($models as $val){
			if($val->lu_value=="其他"||$val->lu_value=="外国血统中国籍人士")continue;
			$return[$val->lu_key]=$val->lu_code.$val->lu_value;
		}
		foreach($models as $val){
			if($val->lu_value=="其他"||$val->lu_value=="外国血统中国籍人士"){
			$return[$val->lu_key]=$val->lu_code.$val->lu_value;
			}
		}
		return $return;
	
	}
    
    /**
     * 把数据结果集数组化
     * @param object $models 查询结果数据集
     * @return array 结果集数组  attributes( lu_key=>lu_value)
     */
	public function toArray($models){
		$return=array();
		
		foreach($models as $val){
			if($val->lu_value=="其他"||$val->lu_value=="外国血统中国籍人士")continue;
			$return[$val->lu_key]=$val->lu_value;
		}
		foreach($models as $val){
			if($val->lu_value=="其他"||$val->lu_value=="外国血统中国籍人士"){
			$return[$val->lu_key]=$val->lu_value;
			}
		}
		return $return;
	
	}
}