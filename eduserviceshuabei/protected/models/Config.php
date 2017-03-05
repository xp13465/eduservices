<?php

/**
 * This is the model class for table "{{config}}".
 *
 * The followings are the available columns in table '{{config}}':
 * @property string $c_varname
 * @property string $c_info
 * @property integer $c_groupid
 * @property string $c_value
 * @property integer $c_lang
 */
class Config extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Config the static model class
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
		return '{{config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_value', 'required'),
			array('c_groupid, c_lang', 'numerical', 'integerOnly'=>true),
			array('c_varname', 'length', 'max'=>20),
			array('c_info', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('c_varname, c_info, c_groupid, c_value, c_lang', 'safe', 'on'=>'search'),
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
			'c_varname' => 'C Varname',
			'c_info' => 'C Info',
			'c_groupid' => 'C Groupid',
			'c_value' => 'C Value',
			'c_lang' => 'C Lang',
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

		$criteria->compare('c_varname',$this->c_varname,true);
		$criteria->compare('c_info',$this->c_info,true);
		$criteria->compare('c_groupid',$this->c_groupid);
		$criteria->compare('c_value',$this->c_value,true);
		$criteria->compare('c_lang',$this->c_lang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getConfig($varname)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        $model=$this->find(" c_varname='{$varname}'");
		return $model?$model->c_value:'';
	}
}