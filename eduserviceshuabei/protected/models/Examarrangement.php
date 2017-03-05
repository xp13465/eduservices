<?php

/**
 * This is the model class for table "{{examarrangement}}".
 *
 * The followings are the available columns in table '{{examarrangement}}':
 * @property integer $ea_id
 * @property integer $ea_pkid
 * @property integer $ea_examid
 * @property integer $ea_stime
 * @property integer $ea_etime
 * @property integer $ea_status
 */
class Examarrangement extends CActiveRecord
{
	public static $status=array(
        "1"=>"启用",
        "2"=>"禁用",
    );
    public static $type=array(
        "1"=>"正考",
        "2"=>"补考",
    );
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Examarrangement the static model class
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
		return '{{examarrangement}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ea_pkid, ea_examid, ea_stime, ea_etime', 'required'),
			array('ea_pkid, ea_examid, ea_stime, ea_etime, ea_status, ea_type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ea_id, ea_pkid, ea_examid, ea_stime, ea_etime, ea_status,ea_isdel', 'safe', 'on'=>'search'),
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
			'ea_id' => 'Ea',
			'ea_pkid' => 'Ea Pkid',
			'ea_examid' => 'Ea Examid',
			'ea_stime' => 'Ea Stime',
			'ea_etime' => 'Ea Etime',
			'ea_status' => 'Ea Status',
            'ea_type' => 'Ea Type',
            'ea_isdel' => 'Ea Isdel',
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

		$criteria->compare('ea_id',$this->ea_id);
		$criteria->compare('ea_pkid',$this->ea_pkid);
		$criteria->compare('ea_examid',$this->ea_examid);
		$criteria->compare('ea_stime',$this->ea_stime);
		$criteria->compare('ea_etime',$this->ea_etime);
		$criteria->compare('ea_status',$this->ea_status);
        $criteria->compare('ea_isdel',$this->ea_isdel);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}