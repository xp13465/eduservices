<?php

/**
 * This is the model class for table "{{pici}}".
 *
 * The followings are the available columns in table '{{pici}}':
 * @property integer $p_id
 * @property string $p_value
 * @property integer $p_status
 * @property integer $p_isdel
 */
class Pici extends CActiveRecord
{
    public static $status=array(
        "1"=>"启用",
        "2"=>"禁用",
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pici the static model class
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
		return '{{pici}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('p_value', 'required'),
			array('p_status, p_isdel', 'numerical', 'integerOnly'=>true),
            array('p_value', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('p_id, p_value, p_status, p_isdel', 'safe', 'on'=>'search'),
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
			'p_value' => 'P Value',
			'p_status' => 'P Status',
			'p_isdel' => 'P Isdel',
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
		$criteria->compare('p_value',$this->p_value,true);
		$criteria->compare('p_status',$this->p_status);
		$criteria->compare('p_isdel',$this->p_isdel);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * 获取所有入学考批次
     * @param boolean $type 是否验证启用状态
     * @param boolean $empty 是否添加无批次
     * @ return array 入学考批次数组 attributes(p_value=>p_value)
     */
	public function getAllPC($type=true,$empty=false){
        $a=$type?"1":"2";
        $b=$empty?"1":"2";
        
        $return=Yii::app()->cache->get("get_allrxk_pc_{$a}_{$b}");
        if($return==false){         
            $criteria = new CDbCriteria;
            $str=$type?'p_isdel=1 and p_status=1':"p_isdel=1 ";
            $criteria->addCondition($str);    
            $criteria->select='p_value,p_id';
            $model=$this->findAll($criteria);        
            $return=$this->toArray($model,$empty);         
            Yii::app()->cache->set("get_allrxk_pc_{$a}_{$b}",$return,Yii::app()->params->cacheTime);	
        }	
		return $return;       
	}
    
    /**
     * 把结果集数组化
     * @param object $models 数据库查询结果集对象
     * @param boolean $empty 是否添加无批次
     * @return array 入学考批次数组 attributes(p_value=>p_value)
     */
	public function toArray($models,$type=false){
        $return=array();
        if($type){
            $return[999]='无批次';
        }
        foreach($models as $val){
            $return[$val->p_id]=$val->p_value;
        }
        	
		return $return;	
	}
    public function getPcById($id) {
        $model= $this->findByPk($id);
		return $model?$model->p_value:"";
    }
}