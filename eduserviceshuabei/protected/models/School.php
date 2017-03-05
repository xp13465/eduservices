<?php

/**
 * This is the model class for table "{{school}}".
 *
 * The followings are the available columns in table '{{school}}':
 * @property integer $s_id
 * @property string $s_code
 * @property string $s_name
 * @property integer $s_province
 * @property string $s_history
 * @property string $s_pinyinsuoxie
 * @property string $s_pinyinlongname
 */
class School extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return School the static model class
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
		return '{{school}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('s_code, s_name, s_province', 'required'),
			array('s_province', 'numerical', 'integerOnly'=>true),
			array('s_code', 'length', 'max'=>20),
			array('s_name', 'length', 'max'=>100),
			array('s_history', 'length', 'max'=>1000),
			array('s_pinyinsuoxie, s_pinyinlongname', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('s_id, s_code, s_name, s_province, s_history, s_pinyinsuoxie, s_pinyinlongname', 'safe', 'on'=>'search'),
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
			's_id' => 'S',
			's_code' => 'S Code',
			's_name' => 'S Name',
			's_province' => 'S Province',
			's_history' => 'S History',
			's_pinyinsuoxie' => 'S Pinyinsuoxie',
			's_pinyinlongname' => 'S Pinyinlongname',
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

		$criteria->compare('s_id',$this->s_id);
		$criteria->compare('s_code',$this->s_code,true);
		$criteria->compare('s_name',$this->s_name,true);
		$criteria->compare('s_province',$this->s_province);
		$criteria->compare('s_history',$this->s_history,true);
		$criteria->compare('s_pinyinsuoxie',$this->s_pinyinsuoxie,true);
		$criteria->compare('s_pinyinlongname',$this->s_pinyinlongname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /**
     * 获取所有院校表的结果集 
     * @return  array 结果集数组
     */
    public function getAutoCompleteData(){
		$connection = Yii::app()->db;  
		 $sql = "select s_id id, s_name name, s_pinyinsuoxie egshort, s_pinyinlongname eglong from es_school "; 
		$command = $connection->createCommand($sql);  
		$result = $command->queryAll();  
        return $result;
    }
}