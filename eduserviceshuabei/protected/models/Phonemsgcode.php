<?php

/**
 * This is the model class for table "{{phonemsgcode}}".
 *
 * The followings are the available columns in table '{{phonemsgcode}}':
 * @property integer $pmc_id
 * @property string $pmc_phone
 * @property integer $pmc_code
 * @property integer $pmc_time
 * @property string $pmc_returnmsgid
 */
class Phonemsgcode extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Phonemsgcode the static model class
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
		return '{{phonemsgcode}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pmc_phone, pmc_code, pmc_time, pmc_returnmsgid', 'required'),
			array('pmc_code, pmc_time', 'numerical', 'integerOnly'=>true),
			array('pmc_phone', 'length', 'max'=>50),
			array('pmc_returnmsgid', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pmc_id, pmc_phone, pmc_code, pmc_time, pmc_returnmsgid', 'safe', 'on'=>'search'),
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
			'pmc_id' => 'Pmc',
			'pmc_phone' => 'Pmc Phone',
			'pmc_code' => 'Pmc Code',
			'pmc_time' => 'Pmc Time',
			'pmc_returnmsgid' => 'Pmc Returnmsgid',
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

		$criteria->compare('pmc_id',$this->pmc_id);
		$criteria->compare('pmc_phone',$this->pmc_phone,true);
		$criteria->compare('pmc_code',$this->pmc_code);
		$criteria->compare('pmc_time',$this->pmc_time);
		$criteria->compare('pmc_returnmsgid',$this->pmc_returnmsgid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}