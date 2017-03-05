<?php

/**
 * This is the model class for table "{{studentloginlog}}".
 *
 * The followings are the available columns in table '{{studentloginlog}}':
 * @property integer $sll_id
 * @property integer $sll_sid
 * @property string $sll_ipaddress
 * @property integer $sll_logintime
 * @property integer $sll_msgid
 */
class Studentloginlog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Studentloginlog the static model class
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
		return '{{studentloginlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sll_sid, sll_ipaddress, sll_logintime', 'required'),
			array('sll_sid, sll_logintime, sll_msgid', 'numerical', 'integerOnly'=>true),
			array('sll_ipaddress', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sll_id, sll_sid, sll_ipaddress, sll_logintime, sll_msgid', 'safe', 'on'=>'search'),
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
			'sll_id' => 'Sll',
			'sll_sid' => 'Sll Sid',
			'sll_ipaddress' => 'Sll Ipaddress',
			'sll_logintime' => 'Sll Logintime',
			'sll_msgid' => 'Sll Msgid',
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

		$criteria->compare('sll_id',$this->sll_id);
		$criteria->compare('sll_sid',$this->sll_sid);
		$criteria->compare('sll_ipaddress',$this->sll_ipaddress,true);
		$criteria->compare('sll_logintime',$this->sll_logintime);
		$criteria->compare('sll_msgid',$this->sll_msgid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}